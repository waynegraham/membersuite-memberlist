<?php
/**
 * Plugin Name:     Membersuite Memberlist
 * Plugin URI:      https://github.com/clirdlf/membersuite-memberlist
 * Description:     Membersuite membership list for WordPress
 * Author:          CLIR
 * Author URI:      https://www.clir.org
 * Text Domain:     clir
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Membersuite_Memberlist
 */

 // If this file is called directly, abort.
 if (! defined('WPINC')) {
     die;
 }

 /**
  * The core plugin class that is used to define internationalization,
  * admin-specific hooks, and public-facing site hooks.
  */
 require plugin_dir_path(__FILE__) . 'includes/class-membersuitememberlist.php';
 require plugin_dir_path(__FILE__) . 'includes/class-userconfig.php';
 require plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
 require plugin_dir_path(__FILE__) . 'vendor/autoload.php'; // geocoder from composer dependencies

 global $msml_db_version; // php is the worst
 $msml_db_version = '0.1.0';

 use Geocoder\Query\GeocodeQuery;

 /**
 * Begins the execution of the plugin.
 *
 */
function run_membersuite_membershiplist()
{
    $plugin = new MembersuiteMemberlist();
    $plugin->run();
}

run_membersuite_membershiplist();

function geocode_membersuite_list()
{
    echo "<h1>Geocoding</h1>";
    global $wpdb;

    // TODO: Move to object
    $options = get_option('membersuite_memberlist_option_name', array());
    $google_api_key = $options['google_api_key'];
    $bing_api_key   = $options['bing_api_key'];
    $httpClient = new \Http\Adapter\Guzzle6\Client();
    $geocoder = new \Geocoder\ProviderAggregator();
    $chain = new \Geocoder\Provider\Chain\Chain([
      new \Geocoder\Provider\BingMaps\BingMaps($httpClient, $google_api_key),
      new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, $google_api_key)
    ]);
    $geocoder->registerProvider($chain);

    // iterate over each record and geocode
    $members = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}membersuite-memberlist` WHERE (longitude IS NULL OR latitude IS NULL)", ARRAY_A);

    foreach ($members as $member) {
        $address = preg_replace("/<br\W*?\/>/i", " ", $member['address']);

        // can't geocode PO Boxes; need a test for this
        if (strstr($address, 'PO Box')) {
            $address_split = preg_split("/<br\W*?\/>/i", $member['address']);
            $address = $address_split[1];
        }

        $address_name = $member['name'] . ' ' . $address;

        echo "<p>Looking up <strong>{$address_name}</strong></p>";
        // TODO flush object
        $address_query = GeocodeQuery::create($address_name);
        $coded = $geocoder->geocodeQuery($address_query)->first();

        $latitude = $coded->getCoordinates()->getLatitude();
        $longitude = $coded->getCoordinates()->getLongitude();

        echo "<p>Location: ({$longitude}, {$latitude})</p>";
        // https://developer.wordpress.org/reference/classes/wpdb/update/
        $table = $wpdb->prefix . 'membersuite-memberlist';

        $data = array(
          'longitude' => $longitude,
          'latitude'  => $latitude
        );

        $format = array('%s');
        $wpdb->update($table, $data, array('ID' => $member['id']));
        // break;
    }
}

function import_membersuite_list()
{
    // session_start();
    // ob_start();
    // TODO: pull Query in to a setting with directions on how to create it
    $Query = "SELECT Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.Type.Name AS membership_type, Name, _Preferred_Address FROM Organization WHERE (Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.ReceivesMemberBenefits=1) ORDER BY SortName, Name";

    echo "<p>Connecting to Membersuite...</p>";

    $api = new MemberSuite();
    $Startrecord = "0";
    $NumberofRecords = "";

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $api->accesskeyId    = Userconfig::read('AccessKeyId');
    $api->associationId  = Userconfig::read('AssociationId');
    $api->secretaccessId = Userconfig::read('SecretAccessKey');
    // $api->signingcertificateId = Userconfig::read('SigningcertificateId');
    // }
    //
    $response = $api->WhoAmI();

    if ($response->aSuccess=='false') {
        echo '<p>There was an issue connecting to MemberSuite</p>';
        echo $response->aErrors->bConciergeError->bMessage;
        die;
    }

    $response = $api->ExecuteMSQL($Query, $Startrecord, $NumberofRecords);
    $result = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;

    if ($result->Table) {
        foreach ($result->Table as $row) {
            $r = (array) $row; // PHP fails on the object name; explicitly convert to array

            global $wpdb;
            // get ms_id columns as a cache
            $cache = $wpdb->get_results("SELECT membersuite_id FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membersuite_id = '{$r['ID']}';", ARRAY_A);
            if (sizeof($cache) == 0) {
                // @see https://developer.wordpress.org/reference/classes/wpdb/insert/
                $table = $wpdb->prefix . 'membersuite-memberlist';

                $data = array(
                  'name'            => $r['Name'],
                  'membership_type' => $r['Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.Type.Name'],
                  'address'         => $r['_Preferred_Address'],
                  'membersuite_id'  => $r['ID']
                );

                $format = array('%s');

                echo "<p>Adding <strong>{$data['name']}</strong>...</p>\n";
                $wpdb->insert($table, $data, $format);
            } else {
                echo "<p><strong>{$r['Name']}</strong> already exists in database. Skipping...</p>";
            }
        }
    }


    // ob_flush();
}

add_action('admin_post_import_membersuite_list', 'import_membersuite_list');
add_action('admin_post_geocode_membersuite_list', 'geocode_membersuite_list');

function membersuite_memberlist_install()
{
    global $wpdb;
    global $msml_db_version;
    $table_name = $wpdb->prefix . "membersuite-memberlist";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `membership_type` varchar(45) DEFAULT NULL,
      `address` varchar(255) DEFAULT NULL,
      `latitude` float DEFAULT NULL,
      `longitude` float DEFAULT NULL,
      `membersuite_id` char(36) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('membersuite-memberlist_db_version', $msml_db_version);
}

function membersuite_memberlist_db_check()
{
    if (get_site_option('membersuite-memberlist_db_version') != $msml_db_version) {
        membersuite_memberlist_install();
    }
}

add_action('plugins_loaded', 'membersuite_memberlist_db_check');
