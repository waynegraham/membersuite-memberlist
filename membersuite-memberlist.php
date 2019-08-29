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
if ( ! defined( 'WPINC' ) ) {
	die;
}

 /**
  * The core plugin class that is used to define internationalization,
  * admin-specific hooks, and public-facing site hooks.
  */
 require plugin_dir_path( __FILE__ ) . 'includes/class-membersuitememberlist.php';
 require plugin_dir_path( __FILE__ ) . 'includes/class-userconfig.php';
 require plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
 require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php'; // geocoder from composer dependencies

function plugin_version() {
	return '0.1.0';
}

 use Geocoder\Query\GeocodeQuery;

 /**
  * Begins the execution of the plugin.
  */
function run_membersuite_membershiplist() {
	 $plugin = new MembersuiteMemberlist();
	$plugin->run();
}

run_membersuite_membershiplist();

// TODO: move to MembersuiteMemberlist_Admin

function reset_membersuite_list() {
	 echo 'Deleting Data';
	global $wpdb;

	$query = $wpdb->get_results( "DELETE FROM `{$wpdb->prefix}membersuite-memberlist`" );
	var_dump( $query );
}

function delete_from_membersuite_list() {
	echo "Deleting row {$_POST['member_id']}";

	if ( ! empty( $_POST['member_id'] ) ) {
		global $wpdb;

		$table  = $wpdb->prefix . 'membersuite-memberlist';
		$id     = $_POST['member_id'];
		$result = $wpdb->delete( $table, array( 'id' => $id ) );

		var_dump( $result );
	}
}

function geocode_membersuite_list() {
	echo '<h1>Geocoding</h1>';
	global $wpdb;

	// TODO: Move to object
	$options        = get_option( 'membersuite_memberlist_option_name', array() );
	$google_api_key = $options['google_api_key'];
	$bing_api_key   = $options['bing_api_key'];
	$httpClient     = new \Http\Adapter\Guzzle6\Client();
	$geocoder       = new \Geocoder\ProviderAggregator();
	$chain          = new \Geocoder\Provider\Chain\Chain(
		[
			new \Geocoder\Provider\BingMaps\BingMaps( $httpClient, $google_api_key ),
			new \Geocoder\Provider\GoogleMaps\GoogleMaps( $httpClient, null, $google_api_key ),
		]
	);
	$geocoder->registerProvider( $chain );

	// iterate over each record and geocode
	$members = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}membersuite-memberlist` WHERE (longitude IS NULL OR latitude IS NULL)", ARRAY_A );

	foreach ( $members as $member ) {
		$address = preg_replace( '/<br\W*?\/>/i', ' ', $member['address'] );

		// can't geocode PO Boxes; need a test for this
		if ( strstr( $address, 'PO Box' ) ) {
			$address_split = preg_split( '/<br\W*?\/>/i', $member['address'] );
			$address       = $address_split[1];
		}

		$address_name = $member['name'] . ' ' . $address;

		echo "<p>Looking up <strong>{$address_name}</strong></p>";
		// TODO flush object
		$address_query = GeocodeQuery::create( $address_name );
		$coded         = $geocoder->geocodeQuery( $address_query )->first();

		$latitude  = $coded->getCoordinates()->getLatitude();
		$longitude = $coded->getCoordinates()->getLongitude();

		echo "<p>Location: ({$longitude}, {$latitude})</p>";
		// https://developer.wordpress.org/reference/classes/wpdb/update/
		$table = $wpdb->prefix . 'membersuite-memberlist';

		$data = array(
			'longitude' => $longitude,
			'latitude'  => $latitude,
		);

		$format = array( '%s' );
		$wpdb->update( $table, $data, array( 'ID' => $member['id'] ) );
	}
}

// TODO: move to MembersuiteMemberlist_Admin
function import_membersuite_list() {
	// session_start();
	// ob_start();
	// TODO: pull Query in to a setting with directions on how to create it
	// $Query = "SELECT Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.Type.Name AS membership_type, Name, _Preferred_Address FROM Organization WHERE (Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.ReceivesMemberBenefits=1) ORDER BY SortName, Name";
	$membersuite_memberlist_options = get_option( 'membersuite_memberlist_option_name' );
	$Query                          = $membersuite_memberlist_options['membersuite_query_5'];

	echo '<p>Connecting to Membersuite...</p>';

	$api             = new MemberSuite();
	$Startrecord     = '0';
	$NumberofRecords = '';

	// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$api->accesskeyId    = Userconfig::read( 'AccessKeyId' );
	$api->associationId  = Userconfig::read( 'AssociationId' );
	$api->secretaccessId = Userconfig::read( 'SecretAccessKey' );
	// $api->signingcertificateId = Userconfig::read('SigningcertificateId');
	// }
	//
	$response = $api->WhoAmI();
	echo '<p>Testing server response...</p>';

	if ( $response->aSuccess == 'false' ) {
		echo '<p>There was an issue connecting to MemberSuite</p>';
		echo $response->aErrors->bConciergeError->bMessage;
		die;
	}

	$response = $api->ExecuteMSQL( $Query, $Startrecord, $NumberofRecords );
	$result   = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;

	if ( $result->Table ) {
		foreach ( $result->Table as $row ) {
			$r = (array) $row; // PHP fails on the object name; explicitly convert to array

			global $wpdb;
			// get ms_id columns as a cache
			$cache = $wpdb->get_results( "SELECT membersuite_id FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membersuite_id = '{$r['ID']}';", ARRAY_A );
			if ( sizeof( $cache ) == 0 ) {
				// @see https://developer.wordpress.org/reference/classes/wpdb/insert/
				$table = $wpdb->prefix . 'membersuite-memberlist';

				$data = array(
					'name'            => $r['Name'],
					'membership_type' => $r['Membership_b909aef5_0068_c9b1_bc68_0b3ba3931465.Type.Name'],
					'address'         => $r['_Preferred_Address'],
					'membersuite_id'  => $r['ID'],
				);

				$format = array( '%s' );

				echo "<p>Adding <strong>{$data['name']}</strong>...</p>\n";
				$wpdb->insert( $table, $data, $format );
			} else {
				echo "<p><strong>{$r['Name']}</strong> already exists in database. Skipping...</p>";
			}
		}
	}

	// ob_flush();
}

add_action( 'admin_post_import_membersuite_list', 'import_membersuite_list' );
add_action( 'admin_post_geocode_membersuite_list', 'geocode_membersuite_list' );
add_action( 'admin_post_reset_membersuite_list', 'reset_membersuite_list' );
add_action( 'admin_post_delete_from_membersuite_list', 'delete_from_membersuite_list' );

function membersuite_memberlist_install() {
	 global $wpdb;
	$msml_db_version = plugin_version();
	$table_name      = $wpdb->prefix . 'membersuite-memberlist';
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

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'membersuite-memberlist_db_version', $msml_db_version );
}

function membersuite_memberlist_upgrade() {
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
}

function membersuite_memberlist_db_check() {
	if ( get_site_option( 'membersuite-memberlist_db_version' ) !== plugin_version() ) {
		membersuite_memberlist_upgrade();
	}
}

function ms_reset() {
	check_ajax_referer( 'ms_reset_nonce' );
}

// move to admin object
function membersuite_delete_row( $data ) {
	check_ajax_referer( 'membersuite-nonce' );
	global $wpdb;
	// echo $_POST['record_id'];
	$id         = intval( $_POST['record_id'] );
	$table_name = $wpdb->prefix . 'membersuite-memberlist';
	$result     = $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );
	$response   = json_encode( $result );
	ob_clean();
	echo 'success';
	wp_die();
	// $status = "Nonce not verified";
	// if (wp_verify_nonce($id[2], $id[0] . '_' . $id[1])) {
	// $table_name = $wpdb->prefix . "membersuite-memberlist";
	// $wpdb->delete($table_name, array('id' => $id), array('%d'));
	// $status = 'Deleted record.';
	// }
	//
	// return $status;
}
add_action( 'wp_ajax_post_membersuite_delete_row', 'delete_row' );
add_action( 'wp_ajax_post_membersuite_reset', 'ms_reset' );
// add_action('wp_ajax_nopriv_your_delete_action', 'delete_row');
// add_action('wp_ajax_delete_row', 'delete_row');

add_action( 'wp_ajax_jsforwp_add_like', 'ms_reset' );


add_action( 'plugins_loaded', 'membersuite_memberlist_db_check' );

function register_scripts() {
	wp_register_script( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.js' );
	wp_register_script( 'membersuite-memberlist', plugins_url( 'public/js/main.min.js', __FILE__ ), array( 'leaflet' ), null, true );

	wp_register_style( 'membersuite-memberlist', plugins_url( 'public/css/main.min.css', __FILE__ ) );
	wp_register_style( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.css' );
}

function load_custom_wp_admin_style() {
	 global $main_menu_url;

	$nonce = wp_create_nonce( 'ms_reset_nonce' );

	wp_register_style( 'membersuite-memberlist-admin', plugins_url( 'public/css/admin.min.css', __FILE__ ) );
	wp_register_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );

	wp_enqueue_style( 'membersuite-memberlist-admin' );
	wp_enqueue_style( 'bootstrap' );

	wp_register_script(
		'membersuite-memberlist-admin',
		plugins_url( 'public/js/admin.min.js', __FILE__ ),
		array(
			'jquery',
		),
		time()
	);
	wp_register_script(
		'popper',
		'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',
		array( 'jquery' )
	);
	wp_register_script(
		'bootstrap',
		'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
		array( 'jquery', 'popper' )
	);

	wp_enqueue_script( 'membersuite-memberlist-admin' );
	wp_enqueue_script( 'popper' );
	wp_enqueue_script( 'bootstrap' );

	wp_localize_script(
		'membersuite-memberlist-admin',
		'membersuite_ajax',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'membersuite-nonce' ),
		)
	);
}

function enqueue_styles() {
	 wp_enqueue_script( 'membersuite-memberlist' );
	wp_enqueue_script( 'leaflet' );

	wp_enqueue_style( 'membersuite-memberlist' );
	wp_enqueue_style( 'leaflet' );
}

add_action( 'init', 'register_scripts' );
add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
