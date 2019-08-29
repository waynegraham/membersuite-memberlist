<?php
/**
 * Class MembersuiteMemberlistAdminTest
 *
 * @package MembersuiteMemberlist
 */
class MembersuiteMemberlist_AdminTest extends WP_UnitTestCase
{
    /**
     * Set up the test harness
     */
    public function setUp()
    {
        parent::setUp();
        $memberlist = new MembersuiteMemberlist();
        $this->class_instance = new MembersuiteMemberlist_Admin('', '');
    }

    public function test_get_members()
    {
        // there are no users
        $this->assertEquals(sizeof($this->class_instance->get_members()), 0);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    // msml_import_page
    // msml_options_page
    // membersuite_memberlist_page_init
    // membersuite_memberlist_section_info
    // membersuite_query_section_info
    // membersuite_mapbox_section_info
    // membersuite_gecoding_section_info
    // bing_api_callback
    // mapbox_api_callback
    // google_api_callback
    // accesskeyid_0_callback
    // associationid_1_callback
    // secretaccesskey_2_callback
    // signingcertificateid_3_callback
    // singingcertificatexml_4_callback
    // membersuite_query_callback
    // membersuite_memberlist_sanitize
    //
}
