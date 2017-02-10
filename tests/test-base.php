<?php

class BaseTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDS_ACF_JSON_Juggler') );
	}
	
	function test_get_instance() {
		$this->assertTrue( wds_acf_json_juggler() instanceof WDS_ACF_JSON_Juggler );
	}
}
