<?php

class WDSACFJSONJ_Views_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDSACFJSONJ_Views') );
	}

	function test_class_access() {
		$this->assertTrue( wds_acf_json_juggler()->views instanceof WDSACFJSONJ_Views );
	}
}
