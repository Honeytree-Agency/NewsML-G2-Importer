<form method='post' name='FeedSyndicateAccountKey' id='FeedSyndicateAccountKey' action='#'>

	<?php wp_nonce_field('FeedSyndicateNewFeed', 'FeedSyndicateNonce'); ?>

	<?php $account_key = get_option( "FeedSyndicateAccountKey" ); ?>

	<table cellspacing="2" cellpadding="5" class="form-table">
		<tbody>

			<tr>
				<td width="40%" class='label'>FeedSyndicate Account Key:</td>
				<td width="60%" class='field'><input type="text" name="account_key" id="account_key" value="<?php echo $account_key; ?>" /></td>
			</tr>

			<tr><td colspan="2">Where is my account key? <a href="http://help.feedsyndicate.com/feedsyndicate-for-wordpress/how-do-i-find-my-account-key" target="_blank">Click Here</a></td></tr>

			<tr>
				<td class="submit" colspan="2">
					<input class="button-primary" type="submit" value="Update Key" name="Upload" id="Upload"/>
					<img src='<?php echo FeedSyndicate_URL; ?>/assets/images/loading2.gif' id="submit_loading" class="feed_loading_image" style="display: none;"/>
				</td>
			</tr>

		</tbody>
	</table>
</form>
