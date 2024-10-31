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

<?php $artist_id = get_the_ID(); ?>

<div class="mp_boxed_content swp_artist_social_web clearfix">
	<div class="mp-artist-top">
		<div class="artist_website artist_single">
			<?php $artist_website = esc_url(get_post_meta($artist_id, 'artist_website', true)); ?>
			<?php if (!empty($artist_website)) { ?>
				<a href="<?php echo esc_attr(esc_url($artist_website)) ;?>" target="_blank">
					<?php echo esc_html__("Official website", 'slide'); ?>
				</a>	
			<?php } ?>
		</div>

		<div class="artist_social_single">
			<span class="artist_follow">
				<?php echo esc_html__("Follow:", 'slide'); ?>
			</span>

			<?php
			/*social options*/
			$available_artist_profiles = array(
				/*'icon name fa-[icon name]'	=> 'settings name'*/
				'facebook-f'		=> 'artist_facebook',
				'twitter'			=>'artist_twitter',		
				'instagram'			=> 'artist_instagram',
				'soundcloud'		=>'artist_soundcloud',	
				'youtube'			=>'artist_youtube',
				'spotify'			=>'artist_spotify',
				'apple'				=>'artist_apple',
				'tiktok'			=>'artist_tiktok'
			);

			$artist_profiles = array();
			foreach ($available_artist_profiles as $key =>	$profile) {
				$profile_url = esc_url(get_post_meta($artist_id, $profile, true));

				if (!empty($profile_url)) {
					$single_profile = array();
					$single_profile['url'] 	= $profile_url;
					$single_profile['icon'] 	= $key;

					$artist_profiles[] = $single_profile;
				}
			}
			?>

			<?php foreach ($artist_profiles as $social_profile) { ?>
				<div class="artist_social_profile artist_single">
					<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
						<i class="fab fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
					</a>
				</div>
			<?php }	?>		
		</div>
	</div>

	<div class="mp-artist-content">
		<?php the_content(); ?>
	</div>
</div>


<?php get_footer();