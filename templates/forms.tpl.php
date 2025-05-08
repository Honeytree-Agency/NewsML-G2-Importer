<div id='feedsyndicate-all'>

	<div id="delete-confirm" title="Delete all feeds?" name="dialog" class="hide-popups">
		<p><span class="ui-icon ui-icon-alert"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
	</div>

	<div id='FeedSyndicateFeedDelete' title='Confirm!' name="dialog" class="hide-popups">
		Are you sure, you want to delete this?
	</div>

	<div id='FeedSyndicateLoader' title='Downloading News...' class="hide-popups">
		<center><img src='<?php echo FeedSyndicate_URL; ?>/assets/images/loading2.gif'/></center>
	</div>

	<div id='FeedSyndicateNotices' title='Finished!' class="hide-popups">
	</div>

	<div id='FeedSyndicateEditFeed' title='Edit Feed' class="hide-popups">
	<?php require('form-edit-feed.php'); ?>
	</div>

	<div id='FeedSyndicateFeedWizardForm' title='Feed Wizard' class="hide-popups">
	<?php require('form-feed-wizard.php'); ?>
	</div>

	<div id='FeedSyndicateAddFeedForm' title='Add Feed from URL' class="hide-popups">
	<?php require('form-feed-from-url.php'); ?>
	</div>

	<div id='FeedSyndicateAccountForm' title='Update Account Key' class="hide-popups">
	<?php require('form-account-options.php'); ?>
	</div>

	<div class='wrap' id='NewsML_Feeds'>
		<h2>FeedSyndicate for WordPress</h2>
	</div>

	<div id='FeedSyndicateData'>
		<?php do_action("FeedSyndicate_show_table"); ?>
	</div>
</div>
