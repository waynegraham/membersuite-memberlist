<?php
/**
 * Provides basic viewing methods for data pulled from MemberSuite.
 *
 * @package MemberSuite
 */
class MembersuiteMemberlist
{
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        $this->plugin_name = 'membersuitememberlist';
        $this->version     = '0.1.0';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        // $this->define_public_hooks();
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_version()
    {
        return $this->version;
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-membersuite-memberlist-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-membersuite-memberlist-admin.php';

        /**
          * The membersuite sdk
          */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ms-sdk/MemberSuite.php';
        // require_once plugin_dir_path(__FILE__) . 'lib/phpsdk.phar';
        // require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ms-sso/ConciergeApiHelper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-userconfig.php';

        $this->loader = new MembersuiteMemberlist_Loader();
    }

    private function set_locale()
    {
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new MembersuiteMemberlist_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu');
        $this->loader->add_action('admin_menu', $plugin_admin, 'membersuite_memberlist_page_init');
    }

    private function define_public_hooks()
    {
    }

    public function run()
    {
        $this->loader->run();
    }
}
