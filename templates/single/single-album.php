<?php
/**
 * The Template for displaying all single albums
 *
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php get_header(); ?>


<?php MPACK_Utils::get_template('cpt-head.php'); ?>

<?php while (have_posts()) {
	the_post();
	$album_ID = get_the_ID();
	?>

	<div class="mp_boxed_content">
		<div class="mp_album_single_content clearfix">
			<div class="album_left">
				<?php the_post_thumbnail('large', ['class' => 'music-album-cover-img']); ?>

				<div class="lc_event_entry">
					<i class="far fa-calendar-alt" aria-hidden="true"></i>
					<?php
						$album_release_date = get_post_meta($album_ID, 'album_release_date', true);
						$album_release_date = str_replace("/","-", $album_release_date);
						try {
							$output_date = new DateTime($album_release_date);	
						} catch(Exception $e) {
							$output_date = new DateTime('NOW');
						}

						echo date_i18n(get_option('date_format'), $output_date->format('U')); 	
					?>
				</div>

				<div class="lc_event_entry">
					<i class="fas fa-music" aria-hidden="true"></i>
					<?php 
					$album_artist = get_post_meta($album_ID, 'album_artist', true);
					echo esc_html($album_artist); 
					?>
				</div>

				<?php $album_label = get_post_meta($album_ID, 'album_label', true); ?>
				<?php if (!empty($album_label)) { ?>
				<div class="lc_event_entry">
					<i class="fas fa-tag" aria-hidden="true"></i>
					<?php echo esc_html($album_label); ?>
				</div>
				<?php } ?>

				<?php $album_cat_no	= get_post_meta($album_ID, 'album_catalogue_number', true); ?>
				<?php if (!empty($album_cat_no)) { ?>
				<div class="lc_event_entry">
					<i class="fas fa-hashtag" aria-hidden="true"></i>
					<?php echo esc_html($album_cat_no); ?>
				</div>
				<?php } ?>	

				<?php $album_producer	= get_post_meta($album_ID, 'album_producer', true);  ?>
				<?php if (!empty($album_producer)) { ?>
				<div class="lc_event_entry">
					<span class="album_detail_name"><?php echo esc_html__('Producer:', 'slide'); ?></span>
					<?php echo esc_html($album_producer); ?>
				</div>
				<?php } ?>
				
				<?php $album_no_disc = get_post_meta($album_ID, 'album_no_disc', true);  ?>
				<?php if (!empty($album_no_disc)) { ?>
				<div class="lc_event_entry">
					<span class="album_detail_name"><?php echo esc_html__('Number of discs:', 'slide'); ?></span>
					<?php echo esc_html($album_no_disc); ?>
				</div>
				<?php } ?>

				<div class="lc_event_entry small_content_padding clearfix">
					<?php 
					$album_buy_message1 = get_post_meta($album_ID, 'album_buy_message1', true);
					$album_buy_link1 = get_post_meta($album_ID, 'album_buy_link1', true);

					$album_buy_message2 = get_post_meta($album_ID, 'album_buy_message2', true);
					$album_buy_link2 = get_post_meta($album_ID, 'album_buy_link2', true);

					$album_buy_message3 = get_post_meta($album_ID, 'album_buy_message3', true);
					$album_buy_link3 = get_post_meta($album_ID, 'album_buy_link3', true);
					
					$album_buy_message4 = get_post_meta($album_ID, 'album_buy_message4', true);
					$album_buy_link4 = get_post_meta($album_ID, 'album_buy_link4', true);
					
					$album_buy_message5 = get_post_meta($album_ID, 'album_buy_message5', true);
					$album_buy_link5 = get_post_meta($album_ID, 'album_buy_link5', true);
					
					$album_buy_message6 = get_post_meta($album_ID, 'album_buy_message6', true);
					$album_buy_link6 = get_post_meta($album_ID, 'album_buy_link6', true);
					?>

					<?php if (!empty($album_buy_message1)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link1); ?>">
								<?php echo esc_html($album_buy_message1); ?>
							</a>
						</div>
					<?php } ?>

					<?php if (!empty($album_buy_message2)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link2); ?>">
								<?php echo esc_html($album_buy_message2); ?>
							</a>
						</div>
					<?php } ?>

					<?php if (!empty($album_buy_message3)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link3); ?>">
								<?php echo esc_html($album_buy_message3); ?>
							</a>
						</div>
					<?php } ?>

					<?php if (!empty($album_buy_message4)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link4); ?>">
								<?php echo esc_html($album_buy_message4); ?>
							</a>
						</div>
					<?php } ?>

					<?php if (!empty($album_buy_message5)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link5); ?>">
								<?php echo esc_html($album_buy_message5); ?>
							</a>
						</div>
					<?php } ?>

					<?php if (!empty($album_buy_message6)) { ?>
						<div class="album_buy_from">
							<a target="_blank" class="lc_button" href="<?php echo esc_url($album_buy_link6); ?>">
								<?php echo esc_html($album_buy_message6); ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="album_right">
				<div class="album_tracks">
					<?php 
					$track_order = 1;
					$album_songs_ids = get_post_meta($album_ID, 'album_songs_ids', true);
					$idsArray = explode(',', $album_songs_ids);
					$idsArray = array_filter($idsArray);

					foreach($idsArray as $single_song_ID) {
						$track = get_post($single_song_ID)
						?>

						<div class="single_track">
							<div class="track_name">
								<span class="track_order"><?php echo esc_html($track_order) . '.'; ?></span><?php echo esc_html($track->post_title); ?>
							</div>
							<?php 
							$attr = array(
								'src'      => wp_get_attachment_url($track->ID),
								'loop'     => '',
								'autoplay' => '',
								'preload' => 'none'
							);
							echo wp_audio_shortcode($attr);
							?>
						</div>
						<?php
						$track_order++;
					}
					?>
				</div>

				<?php the_content(); ?>


				<?php 
				$album_youtube = get_post_meta($album_ID, 'album_youtube', true );
				$album_vimeo = get_post_meta($album_ID, 'album_vimeo', true );
				?>

				<?php if (($album_youtube != "") || ($album_vimeo != "")) { ?>
					<div class="lc_embed_video_container_full album_cpt_video">
						<?php MPACK_Utils::render_embedded_video($album_youtube, $album_vimeo); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

<?php }

get_footer();