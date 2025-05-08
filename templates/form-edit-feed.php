<form method='post' name='FeedSyndicateFeedsEditForm' id='FeedSyndicateFeedsEditForm' action='#'>

	<?php wp_nonce_field('FeedSyndicateNewFeed', 'FeedSyndicateNonce'); ?>

	<input type="hidden" name="edit_feed_array_index" id="edit_feed_array_index" value="" />

	<table cellspacing="2" cellpadding="5" class="form-table edit-form-table">
		<tbody>

			<tr>
				<td width="40%" class="label">Title of Feed</td>
				<td width="60%" class="field"><input type="text" name="edit_form_feed_title" id="edit_form_feed_title"/></td>
			</tr>

			<tr>
				<td class="label">NewsML Feed URL:</td>
				<td class="field"><input type="text" name="edit_form_feed_url" id="edit_form_feed_url"/></td>
			</tr>

			<tr>
				<td class="label">Place articles in this Category</td>
				<td class="field">
					<?php
						$drop_cat = array(
							'orderby'		=> 'ID',
							'order'			=> 'ASC',
							'hide_empty'	=> 0,
							'hierarchical'	=> 1,
							'tab_index'		=> 10,
							'id'			=> 'edit_form_cat',
							'hide_if_empty'	=> false
						);
						wp_dropdown_categories( $drop_cat );
					?>
				</td>
			</tr>

			<tr>
				<td class="label">Assign articles to this Author</td>
				<td class="field"><?php wp_dropdown_users(array('who' => 'authors', 'id' => 'edit_user', 'role__not_in' => 'subscriber')); ?>
				</td>
			</tr>

			<tr>
				<td class="label">Import Articles</td>
				<td class="field">
					<label><input type="radio" name="edit_form_feed_publish" value="publish" checked>Publish Articles Immediately</label>
					<label><input type="radio" name="edit_form_feed_publish" value="draft">Import Articles as Drafts</label>
				</td>
			</tr>

			<tr>
				<td class="label">Fetch Interval</td>
				<td class="field">
					<select id="edit_form_feed_cron">
						<?php
						foreach ( wp_get_schedules() as $cron_key => $cron_value ) {
							$ck_arr = explode( "_", $cron_key );
							if ( isset( $ck_arr[2] ) ) {
								if ( $ck_arr[2] == 'fs' ) {
									echo '<option name="edit_form_feed_cron" value="' . $cron_key . '">' . $cron_value["display"] . '</option>';
								}
							}
						}
						?>
					</select>
				</td>
			</tr>

			<tr><td colspan="2"></td></tr>

			<tr>
				<td class="submit" colspan="2">
					<input class="button-primary" type="submit" value="Update Feed" name="Upload" id="edit_Upload"/>
					<img src='<?php echo FeedSyndicate_URL; ?>/assets/images/loading2.gif' id="edit_submit_loading" class="feed_loading_image" style="display: none;"/>
				</td>
			</tr>

		</tbody>
	</table>
</form>
