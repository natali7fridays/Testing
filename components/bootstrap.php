<?php
/**
 * Class loading
 *
 * @package adaptdev/base
 */

if ( file_exists( ADAPT_DEV_THEME_DIR . '/vendor/autoload.php' ) ) {
	require ADAPT_DEV_THEME_DIR . '/vendor/autoload.php';
} else {
	/**
	 * Automatically require each class file
	 *
	 * @param string $class_name The name of the class.
	 */
	function adapt_dev_autoload( $class_name ) {
		$namespace = 'AdaptDevBase\\Components\\';
		if ( false !== strpos( $class_name, $namespace ) ) {
			$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR;
			$class_file  = str_replace( array( '_', '\\', '\\\\' ), DIRECTORY_SEPARATOR, str_replace( $namespace, '', $class_name ) ) . '.php';
			require_once $classes_dir . $class_file;
		}
	}
	spl_autoload_register( 'adapt_dev_autoload' );
}

require ADAPT_DEV_THEME_DIR . '/components/functions.php';

$adapt_dev_component_registry = call_user_func( 'AdaptDevBase\\Components\\init' );
