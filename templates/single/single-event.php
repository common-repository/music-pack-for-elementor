<?php
/**
 * The Template for displaying all single events
 *
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php get_header(); ?>


<?php MPACK_Utils::get_template('cpt-head.php'); ?>

<?php 
	$event_id = get_the_ID();

	$event_date = get_post_meta($event_id, 'event_date', true);
	$event_time = get_post_meta($event_id, 'event_time', true);
	
	$event_videos_link  = get_post_meta($event_id, 'event_videos_link', true);			
	$event_gallery_link  = get_post_meta($event_id, 'event_gallery_link', true);

	/*data processing*/
	$event_date = str_replace("/","-", $event_date);
	try {
		$dateObject = new DateTime($event_date);
	} catch(Exception $e) {
		$dateObject = new DateTime('NOW');
	}
	$output_date = date_i18n(get_option('date_format'), $dateObject->format('U'));

	/*default schema time stamp - if time is not specified*/
	$schema_time = $dateObject->format(DateTime::ATOM);

	$output_time = '';
	if ($event_time != '') {
		$build_time = $event_date." ".$event_time.":00";
		if (strtotime($build_time)) {
			$time_obj =  new DateTime($build_time);
			$output_time = $time_obj->format(get_option('time_format'));
			$schema_time = $time_obj->format(DateTime::ATOM);
		} else {
			$output_time = $event_time;
		}		
	}

	/*multiday & end date*/
	$event_multiday	= get_post_meta($event_id, 'event_multiday', true);
	if (!empty($event_multiday)) {
		$event_end_date = get_post_meta($event_id, 'event_end_date', true);
		if ($event_end_date != "") {
			$event_end_date = str_replace("/","-", $event_end_date);
			try {
				$endDateObject = new DateTime($event_end_date);
			} catch(Exception $e) {
				$endDateObject = new DateTime('NOW');
			}			
			$output_end_date = date_i18n(get_option('date_format'), $endDateObject->format('U'));
		}
	}

	$left_class = 'event_left';
	if (!has_post_thumbnail()) {
		$left_class = 'event_left_full';
	}

	$event_artists = get_post_meta($event_id, 'swp_artist_selection', true);
	if (!empty($event_artists)) {
		$artists_array = explode(',', $event_artists);
	}
?>

<div class="mp_boxed_content" itemscope itemtype="http://schema.org/Event">
	<div class="<?php echo esc_attr($left_class); ?>">
		<div class="event_short_details">
			<div class="lc_event_entry" itemprop="startDate" content="<?php echo esc_html($schema_time); ?>">
				<i class="far fa-calendar-alt" aria-hidden="true"></i>
				<?php 
					echo esc_html($output_date); 
					if (!empty($event_multiday)) {
						echo esc_html("&#32;&#45;&#32;" . $output_end_date);
					}
				?>
			</div>

			<?php if ($output_time != '') { ?>
			<div class="lc_event_entry">
				<i class="far fa-clock" aria-hidden="true"></i>
				<?php echo esc_html($output_time); ?>
			</div>
			<?php }?>

			<?php $event_location = get_post_meta($event_id, 'event_location', true); ?>
			<div class="swp_ev_location_venue" itemprop="location" itemscope itemtype="http://schema.org/Place">
				<?php if ($event_location != '') { ?>
				<div class="lc_event_entry">
					<i class="fas fa-map-marker-alt" aria-hidden="true"></i>
	    			<span itemprop="address"> <?php echo esc_html($event_location); ?> </span>
				</div>
				<?php } ?>

				<?php
				$event_venue = get_post_meta($event_id, 'event_venue', true);
				$event_venue_url = get_post_meta($event_id, 'event_venue_url', true);
				$have_venue_url = strlen($event_venue_url) ? true : false;
				$venue_target = get_post_meta($event_id, 'event_venue_target', true);
				if (empty($venue_target)) {
					$venue_target = "_blank";
				}
				?>

				<?php if ($event_venue) { ?>
				<div class="lc_event_entry">
					<i class="fas fa-map-pin" aria-hidden="true"></i>
					<?php if ($have_venue_url) { ?>
					<a href="<?php echo esc_url($event_venue_url); ?>" target="<?php echo esc_attr($venue_target); ?>">
					<?php } ?>
						<span itemprop="name"><?php echo esc_html($event_venue); ?></span>
					<?php if ($have_venue_url) { ?>
					</a>
					<?php } ?>
				</div>
				<?php } ?>
			</div>

			<div class="display_none" itemprop="performer" itemscope="" itemtype="http://schema.org/MusicGroup">
				<span itemprop="name"><?php bloginfo('name'); ?></span>
			</div>


			<?php if (!empty($event_artists)) { ?>
			<div class="lc_event_entry">
				<i class="far fa-user"></i>
				<?php 
				foreach($artists_array as $single_artist) { ?>
					<a class="artist_name_in_event" href="<?php echo esc_url(get_the_permalink($single_artist)); ?>"> <?php echo esc_html(get_the_title($single_artist)); ?></a>
				<?php } ?>
			</div>
			<?php } ?>

			<div class="lc_event_entry display_none" itemprop="name">
				<?php the_title(); ?>
			</div>
			<a itemprop="url" href="<?php the_permalink(); ?>" class="display_none">Event</a>
		</div>
		
		<?php
		$event_buy_tickets_message = get_post_meta($event_id, 'event_buy_tickets_message', true);
		$event_buy_tickets_url = get_post_meta($event_id, 'event_buy_tickets_url', true);
		/*if buy tickets message is empty - give it a default value*/
		if (empty($event_buy_tickets_message) && !empty($event_buy_tickets_url)) {
			$event_buy_tickets_message = esc_html__('Tickets', 'music-pack');
		}
		$tickets_target = get_post_meta($event_id, 'event_buy_tickets_target', true);
		if (empty($tickets_target)) {
			$tickets_target = "_blank";
		}
		?>

		<?php 
		$event_fb_message = get_post_meta($event_id, 'event_fb_message', true);
		$event_fb_url  = get_post_meta($event_id, 'event_fb_url', true);
		if (empty($event_fb_message) && !empty($event_fb_url)) {
			$event_fb_message = esc_html__('Facebook Event ', 'music-pack');	
		}
		?>


		<?php
		$event_canceled = get_post_meta($event_id, 'event_canceled', true);
		$event_canceled = empty($event_canceled) ? false : true;
		$event_sold_out = get_post_meta($event_id, 'event_sold_out', true);
		$event_sold_out = empty($event_sold_out) ? false : true;
		?>
		<div class="small_content_padding">
			<?php if ((!empty($event_buy_tickets_url)) || (!empty($event_fb_url))) { ?>
			<div class="lc_event_entry event_promo_btns">
				<?php 
					$button_class = "lc_button MPACK_Event_promo"; 
					$button_text = $event_buy_tickets_message;
					if ($event_canceled) {
							$button_class .= " event_canceled";
							$button_text = esc_html__("Canceled", 'music-pack');						
					} elseif ($event_sold_out) {
							$button_class .= " event_sold_out";
							$button_text = esc_html__("Sold Out", 'music-pack');						
					}
				?>

				<div class="<?php echo esc_attr($button_class); ?>">
					<a href="<?php echo esc_url($event_buy_tickets_url); ?>" target="<?php echo esc_attr($tickets_target); ?>">
						<?php echo esc_html($button_text); ?>
					</a>
				</div>

				<?php if (!empty($event_fb_url)) { ?>
					<div class="lc_button MPACK_Event_promo">
						<a href="<?php echo esc_url($event_fb_url); ?>" target="_blank">
							<?php echo esc_html($event_fb_message); ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php } ?>


			<div itemprop="description" class="event_description">
				<?php the_content(); ?>
			</div>

		</div>
	</div>

	<?php
	$event_youtube_url  = esc_url(get_post_meta($event_id, 'event_youtube_url', true));	
	$event_vimeo_url  = esc_url(get_post_meta($event_id, 'event_vimeo_url', true));
	?>

	<?php if (has_post_thumbnail() || ($event_youtube_url != "") || ($event_vimeo_url != "")) { ?>
	<div class="event_right">
		<?php 
		if (has_post_thumbnail()) {
			the_post_thumbnail('large', array("itemprop" => "image")); 
		}
		?>

		<?php if (($event_youtube_url != "") || ($event_vimeo_url != "")) { ?>
			<div class="lc_embed_video_container_full">
				<?php MPACK_Utils::render_embedded_video($event_youtube_url, $event_vimeo_url); ?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<div class="clearfix"></div>

</div>

<?php get_footer();