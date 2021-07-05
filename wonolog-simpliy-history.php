<?php
/**
 * Wonolog Simpliy history intergration
 *
 *
 * @package             wonolog-simpliy-history
 * @author              Joeri Abbo <https://www.linkedin.com/in/joeri-abbo-43a457144/>
 *
 * @wordpress-plugin
 * Plugin Name:       	Wonolog Simpliy history intergration
 * Plugin URI:        	https://www.linkedin.com/in/joeri-abbo-43a457144/
 * Description:       	Wonolog Simpliy history intergration
 * Version:           	1.0.0
 * Author URI: 			https://www.linkedin.com/in/joeri-abbo-43a457144
 * Author: 				Joeri Abbo
 **/

if ( ! class_exists('WonologSimplyHistory\WSHErrorHandler')) {
    include 'vendor/autoload.php';
}
/*----------------------------------------------------------------------------*
 * Protection for the plugin
 *----------------------------------------------------------------------------*/

if(!defined('WPINC')) // MUST have WordPress.
    exit('Do NOT access this file directly: '.basename(__FILE__));

// Check if simple history is installed.
$pluginList = get_option( 'active_plugins' );

if (!in_array('simple-history/index.php', get_option( 'active_plugins' ))){
    add_action( 'admin_notices', function() {
        $class = 'notice notice-error';
        $message =  'Please enable Simple history to start monitoring.';

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    } );
    return;
}

// Start with error monitoring.
if ( defined( 'Inpsyde\Wonolog\LOG' ) ) {
    Inpsyde\Wonolog\bootstrap()->use_handler( new WSHErrorHandler(), [
        \Inpsyde\Wonolog\Channels::DB,
        \Inpsyde\Wonolog\Channels::HTTP,
        \Inpsyde\Wonolog\Channels::SECURITY,
        \Inpsyde\Wonolog\Channels::PHP_ERROR,
        \Inpsyde\Wonolog\Channels::DEBUG
    ] );
}

/**
 * Register custom mail logger
 */
add_action("simple_history/add_custom_logger", function ($simpleHistory){
    $simpleHistory->register_logger("WSHMailHandler");
} );
