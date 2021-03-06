<?php
/**
 * Bootstrap the testing environment
 * Uses wordpress tests (http://github.com/nb/wordpress-tests/) which uses PHPUnit
 * @package wordpress-plugin-tests
 *
 * Usage: change the below array to any plugin(s) you want activated during the tests
 *        value should be the path to the plugin relative to /wp-content/
 *
 * Note: Do note change the name of this file. PHPUnit will automatically fire this file when run.
 *
 */
 
$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array( 'Multisite-Language-Switcher/MultisiteLanguageSwitcher.php' ),
);

require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';
