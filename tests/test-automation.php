<?php

class WDSACFJSONJ_Automation_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDSACFJSONJ_Automation') );
	}

	function test_class_access() {
		$this->assertTrue( wds_acf_json_juggler()->automation instanceof WDSACFJSONJ_Automation );
	}
}
