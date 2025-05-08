<form method='post' name='FeedSyndicateFeedWizard' id='FeedSyndicateFeedWizard' action='#'>

	<?php wp_nonce_field('FeedSyndicateNewFeed', 'FeedSyndicateNonce'); ?>

	<?php

	$iptc = array(
		'1000000'	=> "Arts, Culture & Entertainment",
		'2000000'	=> "Crime, Law and Justice",
		'3000000'	=> "Disasters and Accidents",
		'4000000'	=> "Economy, Business and Finance",
		'5000000'	=> "Education",
		'6000000'	=> "Environmental Issues",
		'7000000'	=> "Health",
		'8000000'	=> "Human Interest",
		'9000000'	=> "Labor",
		'10000000'	=> "Lifestyle and Leisure",
		'11000000'	=> "Politics",
		'12000000'	=> "Religion and Belief",
		'13000000'	=> "Science and Technology",
		'14000000'	=> "Social Issues",
		'15000000'	=> "Sport",
		'16000000'	=> "Unrest, Conflicts and War",
		'17000000'	=> "Weather",
		);

	$account_key = get_option( "FeedSyndicateAccountKey" );

	?>

	<table class="feedwizard fs-form-table">
		<tbody>

			<tr>
				<td width="40%" class="label">Title of Feed</td>
				<td width="60%" class="field"><input type="text" name="wizard_feed_title" id="wizard_feed_title"/></td>
			</tr>

			<tr>
				<td colspan='2' class="label" style="padding-bottom: 0;">Categories &nbsp; <span style='font-weight: normal;'><a id='select_all_categories'>select all</a> | <a id='clear_all_categories'>clear all</a></span></td>
			</tr>
			<tr>
				<td colspan='2' class="field" style="padding-top: 0;">
					<table style="width: 100%"><tr><td style="width: 58%; vertical-align: top;">
					<?php
						$i = 0;
						foreach ( $iptc as $iptc_name ) {
							$i++;
							echo '<label><input type="checkbox" name="c" value="' . strtolower( $iptc_name ) . '"/> ' . $iptc_name . '</label>';
							if ( $i > count($iptc)/2 ) {
								echo '</td><td style="width: 42%; vertical-align: top;">';
								$i = 0;
							}
						}
					?>
					</td></tr></table>
				</td>
			</tr>

			<tr>
				<td class="label">Keywords</td>
				<td class="field"><input type="text" name="k" id="k"></td>
			</tr>

			<tr>
				<td class="label">Number of Articles to Fetch</td>
				<td class="field">
					<select name="r" id="r" class="postform valid">
						<option class="level-0" value="1">1</option>
						<option class="level-0" value="2">2</option>
						<option class="level-0" value="3">3</option>
						<option class="level-0" value="4">4</option>
						<option class="level-0" value="5" selected>5</option>
						<option class="level-0" value="6">6</option>
						<option class="level-0" value="7">7</option>
						<option class="level-0" value="8">8</option>
						<option class="level-0" value="9">9</option>
						<option class="level-0" value="10">10</option>
					</select>
				</td>
			</tr>

			<tr>
				<td class="label">Media</td>
				<td class="field">
					<label><input type="radio" name="m" value="0" checked>Fetch All Articles</label>
					<label><input type="radio" name="m" value="2">Only Fetch Articles with Images</label>
				</td>
			</tr>

			<tr>
				<td class="label">Place articles in this Category</td>
				<td class="field"><?php
					$drop_cat = array(
						'orderby' => 'ID',
						'order' => 'ASC',
						'hide_empty' => 0,
						'hierarchical' => 1,
						'tab_index' => 10,
						'id' => 'wizard_form_cat',
						'hide_if_empty' => false
					);
					wp_dropdown_categories( $drop_cat );
					?>
				</td>
			</tr>

			<tr>
				<td class="label">Assign articles to this Author</td>
				<td class="field"><?php wp_dropdown_users(array('who' => 'authors', 'id' => 'wizard_user', 'role__not_in' => 'subscriber')); ?>
				</td>
			</tr>

			<tr>
				<td class="label">Import Articles</td>
				<td class="field">
					<label><input type="radio" name="wizard_feed_publish" value="publish" checked>Publish Articles Immediately</label>
					<label><input type="radio" name="wizard_feed_publish" value="draft">Import Articles as Drafts</label>
				</td>
			</tr>

			<tr>
				<td class="label">Fetch Interval</td>
				<td class="field">
					<select id="wizard_feed_cron">
						<?php
						foreach ( wp_get_schedules() as $cron_key => $cron_value ) {
							$ck_arr = explode( "_", $cron_key );
							if ( isset( $ck_arr[2] ) ) {
								if ( $ck_arr[2] == 'fs' ) {
									echo '<option name="wizard_feed_cron" value="' . $cron_key . '">' . $cron_value["display"] . '</option>';
								}
							}
						}
						?>
					</select>
				</td>
			</tr>

			<input type="hidden" name="qk" id="qk" value="<?php echo $account_key; ?>">
			<input type="hidden" name="t"  id="t"  value="full_article">
			<input type="hidden" name="f"  id="f"  value="nml">
			<input type="hidden" name="af" id="af" value="f">
			<input type="hidden" name="la" id="la" value="1en">

			<!--
			<input type="hidden" name="sh" id="sh" value="">
			<input type="hidden" name="nc" id="nc" value="">
			<input type="hidden" name="ai" id="ai" value="">
			<input type="hidden" name="aa" id="aa" value="">
			<input type="hidden" name="av" id="av" value="">
			<input type="hidden" name="am" id="am" value="">
			<input type="hidden" name="lb" id="lb" value="">
			<input type="hidden" name="he" id="he" value="">
			<input type="hidden" name="dn" id="dn" value="">
			-->

			<tr><td colspan="2"></td></tr>

			<tr>
				<td class="submit" colspan="2">
					<input class="button-primary" type="submit" value="Add Feed" name="wizard_feed_submit" id="wizard_feed_submit"/>
					<img src='<?php echo FeedSyndicate_URL; ?>/assets/images/loading2.gif' id="submit_loading" class="feed_loading_image" style="display: none;"/>
				</td>
			</tr>

		</tbody>
	</table>
</form>
