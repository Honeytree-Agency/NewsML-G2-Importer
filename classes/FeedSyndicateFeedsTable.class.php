<?php

if ( ! class_exists( 'WP_List_Table' ) ) { require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ); }

class FeedSyndicateFeedsTable extends WP_List_Table {

	function __construct( $args = array() ) {
		parent::__construct( array(
			'singular'	=> 'feed',
			'plural'	=> 'feeds',
			'ajax'		=> true,
			'screen'	=> 'feed-syndicate'
			)
		);
	}

	function get_columns() {
		$columns = array(
			'feed_title'	=> __('Feed Title', "FeedSyndicateFeeds"),
			//'feed_url'		=> __('Feed URL', "FeedSyndicateFeeds"),
			'cat'			=> __('Article Category', "FeedSyndicateFeeds"),
			'cron'			=> __('Next Auto Publish', "FeedSyndicateFeeds")
			);
		return $columns;
	}

	function column_feed_title($item) {

		$actions = array(
			'publish'	=> sprintf( '<a onclick="updateFeed(\'%s\', \'publish\');" href="#">%s</a>', $item["hash"], __("Publish", "FeedSyndicateFeeds") ),
			'draft'		=> sprintf( '<a onclick="updateFeed(\'%s\', \'draft\');" href="#">%s</a>', $item["hash"], __("Publish as Drafts", "FeedSyndicateFeeds") ),
			'edit'		=> sprintf( '<a onclick="editFeed(\'%s\');" href="#">%s</a>', $item["hash"], __("Edit", "FeedSyndicateFeeds") ),
			'delete'	=> sprintf( '<a onclick="removeFeed(\'%s\');" href="#">%s</a>', $item["hash"], __("Remove", "FeedSyndicateFeeds") )
			);
		return $item["feed_title"] . $this->row_actions($actions);
	}

	function column_feed_url($item) {
		return $item["feed_url"];
	}

	function column_cat($item) {
		$cat = $item["cat"];
		$oCat = get_category($cat);
		return $oCat->name;
	}

	function column_cron($item) {

		$when = wp_next_scheduled( "cron_update", array( $item["hash"], $item["publish"] ) );

		if ( ! $when ) {
			return __("Never", "FeedSyndicateFeeds");
		} else {
			return date( "F j, Y, g:i a", $when + ( get_option('gmt_offset') * HOUR_IN_SECONDS ) ) . " (" . $item["cron"] . ")";
		}
	}

	function column_default($item, $column_name='column') {
		return $item;
	}

	function prepare_items() {

		$per_page = 20;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$current_page = $this->get_pagenum();

		$this->items = get_option( "FeedSyndicateFeeds" );

		$total_items = count( $this->items );

		$this->set_pagination_args( array(
			'total_items'	=> $total_items,
			'per_page'		=> $per_page,
			'total_pages'	=> ceil($total_items / $per_page)
			)
		);
	}

	function extra_tablenav( $which ) {
		if ( $which == "top" ) {
			$buttons = array(
				'PublishAll'		=> 'Publish',
				'DraftAll'			=> 'Publish as Drafts',
				'RemoveAll'			=> 'Remove All Feeds',
				'FeedWizardButton'	=> 'Feed Wizard',
				'FeedURLButton'		=> 'Add Feed from URL',
				'AccountButton'		=> 'Account Key',
			);
			foreach ( $buttons as $name => $label ) {
				$nam = 'FeedSyndicate' . $name;
				$val = __( $label, "FeedSyndicateFeeds" );
				$pri = ( $label == 'Feed Wizard' ) ? 'primary' : 'secondary';
				echo '<input class="button-' . $pri . ' action" type="button" name="' . $nam . '" id="' . $nam . '" value="' . $val . '"/>&nbsp;&nbsp;';
			}
		}
	}

}
