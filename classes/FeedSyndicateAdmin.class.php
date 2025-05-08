<?php

class FeedSyndicateAdmin {

	private $page;

	/**
	 * @var FeedSyndicateFeeds
	 */
	private $feed_handler;

	public function __construct( $feed_handler ) {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		new FeedSyndicateAJAX( $feed_handler, $this );
		$this->feed_handler = $feed_handler;
		add_action( 'admin_notices', array( $this, 'feedSyndicate_add_settings_errors' ) );
		add_action( 'admin_notices', array( $this, 'feedSyndicate_custom_admin_notice' ) );
		add_action( 'FeedSyndicate_show_table', array( $this, 'show_table' ) );
	}

	// display admin notices
	public function feedSyndicate_add_settings_errors() {
		settings_errors();
	}

	// display welcome notice
	public function feedSyndicate_custom_admin_notice() {

		$show_notice = get_option("FeedSyndicateWelcomeNotice");

		if ( $show_notice !== 'hide'&& $pagenow ==  "admin.php" && $_GET['page'] == "FeedSyndicateFeeds" ) {
			$title = __('<h3>Welcome to FeedSyndicate for WordPress</h3>', 'feedSyndicate');
			$message = __('<p>The FeedSyndicate WordPress Plugin is a tool that will permit you to automatically import packaged news content from your FeedSyndicate account and insert it directly into your WordPress site.</p><p>The plugin requires an active FeedSyndicate account.</p>', 'feedSyndicate');
			$logo = '<img src="https://www.feedsyndicate.com/wp-content/uploads/FeedSyndicate-295x40.png"><br/>';
			echo '<div class="notice notice-info is-dismissible feedsyndicate-welcome"><h3>' . $logo . $title . '</h3>' . $message . '</div>';
		}

	}

	public function admin_print_styles($version) {
		global $wp_scripts;

		wp_register_script("FeedSyndicate", FeedSyndicate_URL . '/assets/js/admin.js', array('thickbox',
			'jquery-ui-dialog', 'jquery-ui-tabs'));
		wp_enqueue_script("FeedSyndicate");

		wp_register_script("news-validate", FeedSyndicate_URL . '/assets/js/news-validate.min.js');
		wp_enqueue_script("news-validate");

		wp_register_style("news-custom", FeedSyndicate_URL . '/assets/css/admin.css');
		wp_enqueue_style("news-custom");
	}

	public function admin_menu() {

		$image = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNGluIiBoZWlnaHQ9IjRpbiIgc3R5bGU9InNoYXBlLXJlbmRlcmluZzpnZW9tZXRyaWNQcmVjaXNpb247IHRleHQtcmVuZGVyaW5nOmdlb21ldHJpY1ByZWNpc2lvbjsgaW1hZ2UtcmVuZGVyaW5nOm9wdGltaXplUXVhbGl0eTsgZmlsbC1ydWxlOmV2ZW5vZGQ7IGNsaXAtcnVsZTpldmVub2RkIiB2aWV3Qm94PSIwIDAgNCA0IiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHBhdGggZmlsbD0iYmxhY2siIGNsYXNzPSJmaWwwIiBkPSJNMy45MzcwMWUtMDA2IDMuMjAxOTlsMC4wMDA4NzQwMTYgLTEuMjAxNzUgMC4zOTMzOTQgLTAuMDAxMDcwODdjMCwwLjIyMjk0OSAwLjE4MDcwOSwwLjQwMzY4NSAwLjQwMzYyNiwwLjQwNDI0NCAwLjQ0MDY2OSwwLjAwMDU2Mjk5MiAwLjc5Nzg5NCwwLjM1NzgzOSAwLjc5OTM1OCwwLjc5ODU3NSAwLjAwMTQ1NjY5LDAuMjIyOTQ5IDAuMTgyMTY1LDAuNDAzNjg1IDAuNDA1MDgzLDAuNDAzNjg1IDAuMjIyOTE3LDAgMC40MDM2MjYsLTAuMTgwNzM2IDAuNDA0MjQ0LC0wLjQwMzY4NSAwLjAwMDYxODExLC0wLjg4ODkzMyAtMC43MTk4ODIsLTEuNjA5NTQgLTEuNjA4NjksLTEuNjA4MDIgLTAuMjIyOTE3LDAuMDAxNTE1NzUgLTAuNDAzNjI2LDAuMTgyMjQ4IC0wLjQwMzYyNiwwLjQwNTIwMWwtMC4zOTMzOTQgMC4wMDEwNzA4NyAwLjAwMDg3NDAxNiAtMS4yMDM4OSAwLjM5MjUyIDBjMCwwLjIyMjk0OSAwLjE4MDcwOSwwLjQwMzY4NSAwLjQwMzYyNiwwLjQwMzM0NiAxLjEwNTg3LC0wLjAwMDMzODU4MyAyLjAwMjMzLDAuODk2MjYgMi4wMDM3OSwyLjAwMjI5IDAuMDAxNDY0NTcsMC4yMjI5NDkgMC4xODIxNzMsMC40MDM2ODUgMC40MDUwOTEsMC40MDM2ODUgMC4yMjI5MTcsMCAwLjQwMzYyNiwtMC4xODA3MzYgMC40MDM1NTksLTAuNDAzNjg1IC01LjkwNTUxZS0wMDUsLTEuNTUzNDggLTEuMjU5MTksLTIuODEyOCAtMi44MTI0NCwtMi44MTEwNiAtMC4yMjI5MTcsMC4wMDE3MzIyOCAtMC40MDM2MjYsMC4xODI0NjkgLTAuNDAzNjI2LDAuNDA1NDIxbC0wLjM5MjUyIDBjMCwtMC40Mzk3NzIgMC4zNTY0NDEsLTAuNzk2MjY4IDAuNzk2MTQ2LC0wLjc5NjM0MyAxLjc2ODIsLTguNjYxNDJlLTAwNSAzLjIwMTU5LDEuNDMzNTIgMy4yMDIwOSwzLjIwMTk4IDAuMDAwNTA3ODc0LDAuNDM4NDI1IC0wLjM1NDg1LDAuNzkzODM5IC0wLjc5MzIxMywwLjc5MzgzOWwtMi40MDg4OCAwLjAwNDE3MzIzYy0wLjQ0MDY2OSwwIC0wLjc5Nzg5NCwtMC4zNTcyNzYgLTAuNzk3ODk0LC0wLjc5ODAxMmwwLjM5NDI2OCAwYzAsMC4yMjI5NDkgMC4xODA3MDksMC40MDM2ODUgMC40MDM2MjYsMC40MDM2ODUgMC4yMjI5MTcsMCAwLjQwMzYyNiwtMC4xODA3MzYgMC40MDM2MjYsLTAuNDAzNjg1IDAsLTAuMjIyOTUzIC0wLjE4MDcwOSwtMC40MDM2ODUgLTAuNDAzNjI2LC0wLjQwMzY4NSAtMC4yMjI5MTcsMCAtMC40MDM2MjYsMC4xODA3MzIgLTAuNDAzNjI2LDAuNDAzNjg1bC0wLjM5NDI2OCAweiIvPjwvc3ZnPg0K";

		$this->page = add_menu_page( "FeedSyndicate Feeds", "FeedSyndicate", 'edit_posts', "FeedSyndicateFeeds", array( $this, "admin_page" ), $image, 6 );
		add_action( 'admin_print_styles-' . $this->page, array( $this, "admin_print_styles" ) );

	}

	public function admin_page() {
		load_template(FeedSyndicateFeeds_PATH . '/templates/forms.tpl.php');
	}

	public function show_table() {

		$table = new FeedSyndicateFeedsTable();
		$table->prepare_items();

		$options = get_option("FeedSyndicateFeeds");

		echo '<div class="wrap"><form id="topics-filter" method="get" action="#">';

		$table->display();

		echo '</form></div>';

	}

}
