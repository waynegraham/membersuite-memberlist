<?php
/**
 * Class SampleTest
 *
 * @package Sample_Plugin
 */
/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase
{

    /**
     * Set up the test harness
     */
    public function setUp()
    {
        parent::setUp();
        $this->class_instance = new MembersuiteMemberlist();
        // $this->class_instance = new MembersuiteMemberlist_Admin(new MembersuiteMemberlist_Admin($memberlist->get_plugin_name(), $memberlist->get_version()););
    }

    

    /**
     * A single example test.
     */
    public function test_sample()
    {
        // Replace this with some actual testing code.
        $this->assertTrue(true);
    }
}
