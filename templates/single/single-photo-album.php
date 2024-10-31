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

<?php
$content = trim(get_the_content());
if (!empty($content)) { ?>
	<div class="mp_boxed_content">
		<?php the_content(); ?>
	</div>
<?php } ?>

<?php 
$galleryImages = MPACK_Utils::create_photo_album_gallery_from_ids(get_the_ID()); 
$allowed_html = array(
	'img'	=> array(
		'width'		=> array(),
		'height'	=> array(),
		'src'		=> array(),
		'class'		=> array(),
		'alt'		=> array(),
		'srcset'	=> array(),
		'sizes'		=> array()
	)
); 
?>

<div class="lc_masonry_container gallery_single_img_container">
	<div class="brick-size"></div>
	<?php foreach ($galleryImages as $imageObj) { ?>
		<div class="lc_masonry_brick clearfix lc_single_gallery_brick">
			<div class="gallery_brick_overlay"></div>
			<a href="<?php echo esc_url($imageObj['href']); ?>" data-lightbox="photo_album">

				<?php echo wp_kses($imageObj['image'], $allowed_html); ?>
				
				<?php if (!empty($imageObj['caption'])) { ?>
					<div class="swp_img_caption">
						<?php echo esc_html($imageObj['caption']); ?>
					</div>
				<?php } ?>
			</a>
		</div>
	<?php } ?>
</div>

<?php get_footer();