<?php
/*
Plugin Name: LearnPress - Satisfaction Question
Plugin URI: http://thimpress.com/learnpress
Description: Supports type of question Satisfaction lets user fill out the text into one ( or more than one ) space.
Author: ThimPress
Version: 3.0.3
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, satisfaction
Text Domain: learnpress-satisfaction
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_SATISFACTION_FILE', __FILE__ );
define( 'LP_ADDON_SATISFACTION_VER', '3.0.3' );
define( 'LP_ADDON_SATISFACTION_REQUIRE_VER', '3.0.0' );
define( 'LP_QUESTION_SATISFACTION_VER', '3.0.3' );

/**
 * Class LP_Addon_Satisfaction_Preload
 */
class LP_Addon_Satisfaction_Preload {

	/**
	 * LP_Addon_Satisfaction_Preload constructor.
	 */
	public function __construct() {
		add_action( 'learn-press/ready', array( $this, 'load' ) );
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Satisfaction', 'inc/load.php', __FILE__ );
	}

}

new LP_Addon_Satisfaction_Preload();