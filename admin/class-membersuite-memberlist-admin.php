<?php
/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    MembersuiteMemberlist
* @subpackage MembersuiteMemberlist/admin
* @author    Wayne Graham <wgraham@clir.org>
*/

class MembersuiteMemberlist_Admin
{
    private $plugin_name;
    private $membersuite_memberlist_options;
    public $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function admin_menu()
    {
        add_menu_page(
            'Membersuite Memberlist ',
            'Membersuite Memberlist List',
            'manage_options',
            'membersuite-memberlist',
            array($this, 'msml_import_page'),
            'dashicons-admin-users'
    );

        add_submenu_page(
            'membersuite-memberlist',
            'Membersuite API Settings',
            'Membersuite API Settings',
            'manage_options',
            'membersuite-memberlist-settings',
            array($this, 'msml_options_page')
    );
    }

    public function get_members()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}membersuite-memberlist`;", ARRAY_A);
    }

    public function msml_import_page()
    {
        ?>
    <div class="container">
      <div class="row">
        <h1>Membersuite Members</h1>
        <div class="col-12">
          <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" name="import">
            <input type="hidden" name="action" value="import_membersuite_list">
            <input class="btn btn-primary" id="import-button" type="submit" value="Import from Membersuite" class="button" />
          </form>

          <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" name="geocode">
            <input type="hidden" name="action" value="geocode_membersuite_list">
            <input class="btn btn-primary" id="import-button" type="submit" value="Geocode" class="button" />
          </form>

          <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" name="reset">
            <input type="hidden" name="action" value="reset_membersuite_list">
            <input class="btn btn-warning" id="import-button" type="submit" value="Reset" class="button" />
          </form>

          <!-- <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" name="reset">
            <input type="hidden" name="action" value="reset_membersuite_list">
            <button type="button" class="btn btn-warning ms-reset-data" name="button">Reset Data</button>
          </form> -->

          <div id="alerts"></div>


          <!-- <div id="loading" class="d-flex justify-content-center" >
          <div class="spinner-grow" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> -->

    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">


      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Institution</th>
            <th scope="col">Membership Type</th>
            <th scope="col">Location</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $members = MembersuiteMemberlist_Admin::get_members();
        foreach ($members as $member) {
            // $nonce = 'delete_' . $member['id'] . '_' . wp_create_nonce('delete' . $member['id']);
            $nonce = $member['id']  ?>
            <tr>
              <td><?php echo $member['name'] ?></td>
              <td><?php echo $member['membership_type'] ?></td>
              <td>(<?php echo $member['longitude']?>, <?php echo $member['latitude']?>)</td>
              <!-- <td><button type="button" class="btn btn-danger membersuite_delete_row" id="<?php echo $nonce; ?>">Delete</button></td> -->
              <td>
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" name="delete">
                  <input type="hidden" name="action" value="delete_from_membersuite_list">
                  <input type="hidden" name="member_id" value="<?php echo $member['id'] ?>" />
                  <input class="btn btn-danger" type="submit" value="Delete" />
                </form>
              </td>
        </tr>

        <?php
        } ?>

    </tbody>
  </table>
</div>
</div>
</div>

<?php
    }

    public function msml_options_page()
    {
        $this->$membersuite_memberlist_options = get_option('membersuite_memberlist_option_name'); ?>
  <div class="wrap">
    <h2>Membersuite Memberlist Settings</h2>
    <p>MemberSuite API settings. See the <a href="https://www.membersuite.com/api-documentation">MemberSuite API Documentation</a> for information on obtaining these values.</p>
    <form method="post" action="options.php">
      <?php
      settings_fields('membersuite_memberlist_option_group');
        do_settings_sections('membersuite-memberlist-admin');
        submit_button(); ?>
    </form>
  </div>
  <?php
    }

    public function membersuite_memberlist_page_init()
    {
        register_setting(
            'membersuite_memberlist_option_group',
            'membersuite_memberlist_option_name',
            array($this, 'membersuite_memberlist_sanitize')
        );

        add_settings_section(
            'membersuite_memberlist_setting_section', // id
            'Membersuite Settings', // title
            array( $this, 'membersuite_memberlist_section_info' ), // callback
            'membersuite-memberlist-admin' // page
        );

        add_settings_section(
            'membersuite_query_setting_section', // id
            'Membersuite Query Settings', // title
            array( $this, 'membersuite_query_section_info' ), // callback
            'membersuite-memberlist-admin' // page
        );

        add_settings_section(
            'membersuite_geocoding_setting_section', // id
            'Geocoding Settings', // title
            array( $this, 'membersuite_gecoding_section_info' ), // callback
            'membersuite-memberlist-admin' // page
        );

        add_settings_section(
            'membersuite_mapbox_setting_section', // id
            'Mapbox Settings', // title
            array( $this, 'membersuite_mapbox_section_info' ), // callback
            'membersuite-memberlist-admin' // page
        );

        add_settings_field(
            'accesskeyid_0', // id
            'Access Key ID', // title
            array( $this, 'accesskeyid_0_callback' ), // callback
            'membersuite-memberlist-admin', // page
            'membersuite_memberlist_setting_section' // section
        );

        add_settings_field(
            'associationid_1', // id
    'Association ID', // title
    array( $this, 'associationid_1_callback' ), // callback
    'membersuite-memberlist-admin', // page
    'membersuite_memberlist_setting_section' // section
  );

        add_settings_field(
            'secretaccesskey_2', // id
    'Secret Access Key', // title
    array( $this, 'secretaccesskey_2_callback' ), // callback
    'membersuite-memberlist-admin', // page
    'membersuite_memberlist_setting_section' // section
  );

        add_settings_field(
            'signingcertificateid_3', // id
    'Signingcertificate ID', // title
    array( $this, 'signingcertificateid_3_callback' ), // callback
    'membersuite-memberlist-admin', // page
    'membersuite_memberlist_setting_section' // section
  );

        add_settings_field(
            'singingcertificatexml_4', // id
    'Singing Certificate Xml', // title
    array( $this, 'singingcertificatexml_4_callback' ), // callback
    'membersuite-memberlist-admin', // page
    'membersuite_memberlist_setting_section' // section
  );

        add_settings_field(
            'membersuite_query_5', // id
            'Membersuite Query', // title
            array( $this, 'membersuite_query_callback' ), // callback
            'membersuite-memberlist-admin', // page
            'membersuite_query_setting_section' // section
        );

        add_settings_field(
            'google_api_key',
            'Google API Key',
            array( $this, 'google_api_callback'),
            'membersuite-memberlist-admin',
            'membersuite_geocoding_setting_section'
        );

        add_settings_field(
            'bing_api_key',
            'Bing API Key',
            array( $this, 'bing_api_callback'),
            'membersuite-memberlist-admin',
            'membersuite_geocoding_setting_section'
        );

        add_settings_field(
            'mapbox_api_key',
            'Mapbox API Key',
            array( $this, 'mapbox_api_callback'),
            'membersuite-memberlist-admin',
            'membersuite_mapbox_setting_section'
        );
    }

    public function membersuite_memberlist_section_info()
    {
        printf('%s', 'These settings are your API key that you need to generate in MemberSuite.');
    }

    public function membersuite_query_section_info()
    {
        printf('%s', 'Generate a query in the Membersuite portal interface. Click on the SQL at the bottom of the page to get the correct format.');
    }

    public function membersuite_mapbox_section_info()
    {
        printf('%s', 'Get your API key at <a href="https://www.mapbox.com/">Mapbox</a>.');
    }

    public function membersuite_gecoding_section_info()
    {
        printf('%s', 'These settings are your API keys for Geocoding. You will need <a href="https://developers.google.com/maps/documentation/geocoding/start">Google</a> and/or <a href="https://docs.microsoft.com/en-us/bingmaps/getting-started/bing-maps-dev-center-help/getting-a-bing-maps-key">Bing</a>.');
    }

    public function bing_api_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[bing_api_key]" id="bing_api_key" value="%s">',
            isset($this->$membersuite_memberlist_options['bing_api_key']) ? esc_attr($this->$membersuite_memberlist_options['bing_api_key']) : ''
    );
    }

    public function mapbox_api_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[mapbox_api_key]" id="mapbox_api_key" value="%s">',
            isset($this->$membersuite_memberlist_options['mapbox_api_key']) ? esc_attr($this->$membersuite_memberlist_options['mapbox_api_key']) : ''
    );
    }

    public function google_api_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[google_api_key]" id="google_api_key" value="%s">',
            isset($this->$membersuite_memberlist_options['google_api_key']) ? esc_attr($this->$membersuite_memberlist_options['google_api_key']) : ''
    );
    }

    public function accesskeyid_0_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[accesskeyid_0]" id="accesskeyid_0" value="%s">',
            isset($this->$membersuite_memberlist_options['accesskeyid_0']) ? esc_attr($this->$membersuite_memberlist_options['accesskeyid_0']) : ''
    );
    }

    public function associationid_1_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[associationid_1]" id="associationid_1" value="%s">',
            isset($this->$membersuite_memberlist_options['associationid_1']) ? esc_attr($this->$membersuite_memberlist_options['associationid_1']) : ''
    );
    }

    public function secretaccesskey_2_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[secretaccesskey_2]" id="secretaccesskey_2" value="%s">',
            isset($this->$membersuite_memberlist_options['secretaccesskey_2']) ? esc_attr($this->$membersuite_memberlist_options['secretaccesskey_2']) : ''
    );
    }

    public function signingcertificateid_3_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="membersuite_memberlist_option_name[signingcertificateid_3]" id="signingcertificateid_3" value="%s">',
            isset($this->$membersuite_memberlist_options['signingcertificateid_3']) ? esc_attr($this->$membersuite_memberlist_options['signingcertificateid_3']) : ''
    );
    }

    public function singingcertificatexml_4_callback()
    {
        printf(
            '<textarea class="large-text" rows="10" name="membersuite_memberlist_option_name[singingcertificatexml_4]" id="singingcertificatexml_4">%s</textarea>',
            isset($this->$membersuite_memberlist_options['singingcertificatexml_4']) ? $this->$membersuite_memberlist_options['singingcertificatexml_4'] : ''
    );
    }

    public function membersuite_query_callback()
    {
        printf(
            '<textarea class="large-text" rows="5" name="membersuite_memberlist_option_name[membersuite_query_5]" id="membersuite_query_5">%s</textarea>',
            isset($this->$membersuite_memberlist_options['membersuite_query_5']) ? $this->$membersuite_memberlist_options['membersuite_query_5'] : ''
    );
    }

    public function membersuite_memberlist_sanitize($input)
    {
        $sanitary_values = array();

        if (isset($input['accesskeyid_0'])) {
            $sanitary_values['accesskeyid_0'] = sanitize_text_field($input['accesskeyid_0']);
        }

        if (isset($input['associationid_1'])) {
            $sanitary_values['associationid_1'] = sanitize_text_field($input['associationid_1']);
        }

        if (isset($input['secretaccesskey_2'])) {
            $sanitary_values['secretaccesskey_2'] = sanitize_text_field($input['secretaccesskey_2']);
        }

        if (isset($input['signingcertificateid_3'])) {
            $sanitary_values['signingcertificateid_3'] = sanitize_text_field($input['signingcertificateid_3']);
        }

        if (isset($input['singingcertificatexml_4'])) {
            $sanitary_values['singingcertificatexml_4'] = esc_textarea($input['singingcertificatexml_4']);
        }

        if (isset($input['membersuite_query_5'])) {
            $sanitary_values['membersuite_query_5'] = esc_textarea($input['membersuite_query_5']);
        }

        if (isset($input['google_api_key'])) {
            $sanitary_values['google_api_key'] = sanitize_text_field($input['google_api_key']);
        }

        if (isset($input['bing_api_key'])) {
            $sanitary_values['bing_api_key'] = sanitize_text_field($input['bing_api_key']);
        }

        if (isset($input['mapbox_api_key'])) {
            $sanitary_values['mapbox_api_key'] = sanitize_text_field($input['mapbox_api_key']);
        }

        return $sanitary_values;
    }
}
