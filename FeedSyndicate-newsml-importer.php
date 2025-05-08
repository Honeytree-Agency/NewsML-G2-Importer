<?php
/**
 * Plugin Name: FeedSyndicate for WordPress
 * Plugin URI: https://wordpress.feedsyndicate.com
 * Description: Automatically add ready to use full text news articles, images and content into your Wordpress site from FeedSyndicate.
 * Version: 1.2.2
 * Author: FeedSyndicate
 * Author URI: https://www.feedsyndicate.com
 * Text Domain: FeedSyndicate
 * Domain Path: /languages
 */

if ( ! class_exists( 'FeedSyndicateSMLFeeds' ) ) {

	class FeedSyndicateSMLFeeds {

		public static function instance() {
			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self();
			}

			return $instance;
		}

		public function __construct() {
			$this->define_constants();
			$this->includes();

			load_plugin_textdomain('FeedSyndicateFeeds', false, FeedSyndicate_URL);

			$cron_worker = new feed_syndicate_cron(array(
				"5_min_fs" => 5,
				"10_min_fs" => 10,
				"15_min_fs" => 15,
				"30_min_fs" => 30,
				"1_hr_fs" => 1,
				"4_hr_fs" => 4,
				"6_hr_fs" => 6,
				"12_hr_fs" => 12,
				"24_hr_fs" => 24));

			$cron_worker->hooks();

			new FeedSyndicateFeeds();

		}

		public function define_constants() {
			$defines = array(
				'FeedSyndicateFeeds_PATH' => dirname(__FILE__),
				'FeedSyndicate_URL' => plugins_url('', __FILE__),
			);

			foreach( $defines as $k => $v ) {
				if ( !defined( $k ) ) {
					define( $k, $v );
				}
			}
		}

		public function includes() {
			require FeedSyndicateFeeds_PATH . '/classes/FeedSyndicateFeeds.class.php';
			require FeedSyndicateFeeds_PATH . '/classes/FeedSyndicateFeedsTable.class.php';
			require FeedSyndicateFeeds_PATH . '/classes/FeedSyndicateNewsML.class.php';
			require FeedSyndicateFeeds_PATH . '/classes/feed_syndicate_xml.php';
			require FeedSyndicateFeeds_PATH . '/classes/feed_syndicate_cron.php';
			if (!class_exists('FeedSyndicateAJAX')) {
				require 'classes/FeedSyndicateAJAX.class.php';
			}

			if (!class_exists('FeedSyndicateAdmin')) {
				require 'classes/FeedSyndicateAdmin.class.php';
			}
		}

	}

	function newsml() {
		return FeedSyndicateSMLFeeds::instance();
	}

	$GLOBALS['newsml'] = newsml();

}