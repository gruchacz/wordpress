<?php
/**
 * Author: Alin Marcu
 * Author URI: https://deconf.com
 * Copyright 2017 Alin Marcu
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit();

if ( ! class_exists( 'GADWP_Tracking' ) ) {

	class GADWP_Tracking {

		private $gadwp;

		public $analytics;

		public $amp;

		public $tagmanager;

		public function __construct() {
			$this->gadwp = GADWP();

			$this->init();
		}

		public function init() {
			// excluded roles
			if ( GADWP_Tools::check_roles( $this->gadwp->config->options['ga_track_exclude'], true ) || ( $this->gadwp->config->options['ga_dash_excludesa'] && current_user_can( 'manage_network' ) ) ) {
				return;
			}

			if ( 'universal' == $this->gadwp->config->options['ga_dash_tracking_type'] && $this->gadwp->config->options['ga_dash_tableid_jail'] ) {

				// Analytics
				require_once 'tracking-analytics.php';
				$this->analytics = new GADWP_Tracking_Analytics();
			}

			if ( 'tagmanager' == $this->gadwp->config->options['ga_dash_tracking_type'] && $this->gadwp->config->options['web_containerid'] ) {

				// Tag Manager
				require_once 'tracking-tagmanager.php';
				$this->tagmanager = new GADWP_Tracking_TagManager();
			}
		}
	}
}
