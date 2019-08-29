<?php
/**
 * Class MembersuiteMemberlistTest
 *
 * @package MembersuiteMemberlist
 */
class MembersuiteMemberlistTest extends WP_UnitTestCase {

	/**
	 * Set up the test harness
	 */
	public function setUp() {
		parent::setUp();
		$this->class_instance = new MembersuiteMemberlist();
	}

	public function test_version() {
		$expected = '0.1.0';
		$this->assertEquals( $this->class_instance->get_version(), $expected );
	}

	public function test_plugin_name() {
		$expected = 'membersuitememberlist';
		$this->assertEquals( $this->class_instance->get_plugin_name(), $expected );
	}
}
