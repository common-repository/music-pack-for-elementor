<?php
/**
 * The Template for displaying all single videos
 *
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php get_header(); ?>

<?php MPACK_Utils::get_template('cpt-head.php'); ?>

<?php
	$album_youtube = esc_html(get_post_meta(get_the_ID(), 'video_youtube_url', true)); 			
	$album_vimeo = esc_html(get_post_meta(get_the_ID(), 'video_vimeo_url', true));
?>

<div class="mp_boxed_content">
	<?php if (($album_youtube != "") || ($album_vimeo != "")) { ?>
		<div class="lc_embed_video_container_full">
			<?php MPACK_Utils::render_embedded_video($album_youtube, $album_vimeo); ?>
		</div>
	<?php } ?>

	<div class="mp-single-video-content">
		<?php the_content(); ?>
	</div>
</div>

<?php get_footer();