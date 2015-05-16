<?php

/**
 * The Minit Manual Inclusion Plugin
 *
 * Use Minit only for manually whitelisted files.
 *
 * @package Minit_Manual_Inclusion
 * @subpackage Class
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Use Minit only for manually whitelisted files.
 *
 * @since 1.0
 */
class Minit_Manual_Inclusion {
	/**
	 * Instance of Minit class.
	 *
	 * @var $enqueue
	 * @since 1.0
	 * @access public
	 */
	public $minit_instance;

	/**
	 * Unhooking of Minit's and hooking of this class' methods.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		$this->minit_instance = Minit::instance();

		remove_filter( 'print_scripts_array', array( $this->minit_instance, 'init_minit_js'  ) );
		remove_filter( 'print_styles_array',  array( $this->minit_instance, 'init_minit_css' ) );

		add_filter( 'print_scripts_array', array( $this, 'init_minit_js'  ) );
		add_filter( 'print_styles_array',  array( $this, 'init_minit_css' ) );
	}

	/**
	 * Helper to process only manually selected styles or scripts with Minit.
	 *
	 * @since 1.0
	 * @access protected
	 */
	protected function init_minit( $object, $todo, $type ) {
		/**
		 * Filter the array of enqueued files before Minit.
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @param array $todo An array of files that should go to Minit.
		 *                    By default an empty array.
		 */
		$include = (array) apply_filters( 'minit_manual_inclusion_' . $type, array() );

		if ( $include ) {
			$minit = $this->minit_instance->minit_objects( $object, $include, $type );

			/**
			 * Filter whether Minit file should be enqueued first or last.
			 *
			 * @since 1.0
			 * @access public
			 *
			 * @param bool $status Whether Minit file should be enqueued first or last.
			 *                     By default true.
			 */
			$late = apply_filters( 'minit_manual_inclusion_enqueue_' . $type . '_late', true );

			$merged = $late ? array_merge( $todo, $minit ) : array_merge( $minit, $todo );

			return array_diff( $merged, $include );
		}

		return $todo;
	}

	/**
	 * Process only manually selected scripts with Minit.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $todo An array of script dependencies.
	 * @return array $todo New array of script dependencies.
	 */
	public function init_minit_js( $todo ) {
		global $wp_scripts;

		return $this->init_minit( $wp_scripts, $todo, 'js' );
	}

	/**
	 * Process only manually selected styles with Minit.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $todo The list of enqueued styles about to be processed.
	 * @return array $todo New list of enqueued styles about to be processed.
	 */
	public function init_minit_css( $todo ) {
		global $wp_styles;

		return $this->init_minit( $wp_styles, $todo, 'css' );
	}
}
