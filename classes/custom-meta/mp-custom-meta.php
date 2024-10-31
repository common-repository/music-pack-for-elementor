<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Custom_Meta {
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'mp_custom_meta_boxes'));
		add_action('save_post', array($this, 'mp_artist_selection_save'));
	}

	public function mp_custom_meta_boxes() {
		$artist_select_support = array(
			'js_albums', 
			'js_events', 
			'js_videos'
		);

		foreach($artist_select_support as $post_type) {
			add_meta_box( 
				'js_swp_artist_select_meta', 
				esc_html__("Artist Selection", 'music-pack'),
				array($this, 'mp_artist_select_meta_cbk'),  
				$post_type,
				'advanced',
				'high'
			);
		}
	}

	public function mp_artist_select_meta_cbk($post) {
		$stored_meta = get_post_meta($post->ID);

		$artist_selection = '';
		if (isset($stored_meta['swp_artist_selection'])) {
			$artist_selection = $stored_meta['swp_artist_selection'][0];
		}
		$artist_selection = explode(',', $artist_selection);

		$args = array(
				'numberposts'		=> 	-1,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'js_artist',
				'post_status'      => 'publish'
			);
		$artist_posts = get_posts($args);

		?>
		<div class="heading_meta_option">
			<span class="lc_swp_before_option"><?php echo esc_html__("Select one or more artists:", "music-pack"); ?></span>
			<select id="swp_artist_selection" name="swp_artist_selection[]" multiple>
			<?php
				foreach($artist_posts as $single_artist) {
					$permalink = get_the_permalink($single_artist);
					if (strpos($permalink, "lang=") != false) {
						continue;
					}
					if (in_array($single_artist->ID, $artist_selection)) {
						?>
						<option value="<?php echo esc_attr($single_artist->ID); ?>" selected="selected"> <?php echo esc_html($single_artist->post_title); ?> </option>
						<?php
					} else {
						?>
						<option value="<?php echo esc_attr($single_artist->ID); ?>"> <?php echo esc_html($single_artist->post_title); ?> </option>
						<?php
					}
				}
			?>
			</select>
			<p class="description for_artist_selection show_on_right">
				<?php 
					echo esc_html__('Select artists for this event/video/album. Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.', 'music-pack'); 
				?>
			</p>
			<?php wp_nonce_field('mpack_artist_sel_save_action', 'mpack_artist_sel_save_nonce');?>
		</div>
	<?php
	}

	public function mp_artist_selection_save($post_id) {
		if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
			return;
		}

		if (!isset($_POST['mpack_artist_sel_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_artist_sel_save_nonce'])), 'mpack_artist_sel_save_action')) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}		

		$new = isset ($_POST['swp_artist_selection'] )  ? MPACK_Utils::sanitize_ids_array($_POST['swp_artist_selection']) : array();
		$val_to_save =  empty($new) ? "" : implode(",", $new);
		
		update_post_meta($post_id, 'swp_artist_selection', $val_to_save);
	}
}

$custom_meta_inst = new MPACK_Custom_Meta();