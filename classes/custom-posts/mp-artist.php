<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Artist {
	public function __construct() {
		add_action('init', array($this, 'create_artist_post'));
		add_action('admin_init', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'mp_save_artst_fields'), 10, 2);

		add_filter('manage_edit-js_artist_columns', array($this, 'mc_custom_artist_cols'));
		add_action('init', array($this, 'mp_create_artist_category'), 11);
	}


	public function create_artist_post() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("js_artist");

		if (!strlen($slug)) {
			$slug = "js_artist";
		}

		register_post_type('js_artist',
			array(
				'labels' => array(
					'name' =>  esc_html__('Artists', 'music-pack') ,
					'singular_name' =>  esc_html__('Artist', 'music-pack') ,
					'add_new' => esc_html__('Add New Artist', 'music-pack'),
					'add_new_item' => esc_html__('Add New Artist', 'music-pack'),
					'edit' => esc_html__('Edit', 'music-pack'),
					'edit_item' => esc_html__('Edit Artist', 'music-pack'),
					'new_item' => esc_html__('New Artist', 'music-pack'),
					'view' => esc_html__('View', 'music-pack'),
					'view_item' => esc_html__('View Artist', 'music-pack'),
					'search_items' => esc_html__('Search Artists', 'music-pack'),
					'not_found' => esc_html__('No Artist Found','music-pack'),
					'not_found_in_trash' => esc_html__('No Event Found in Trash','music-pack'),
					'parent' => esc_html__('Parent Artist','music-pack')
				),
			'public' => true,
			'rewrite' => array(
				'slug' => $slug,
				'with_front' => false
				),
			'supports' => array('title', 'editor', 'comments', 'thumbnail'),
			'menu_icon' => 'dashicons-admin-users',
			)
		);

	}

	public function add_meta_boxes() {

	    add_meta_box(
	    	'artist_meta_box',
	        esc_html__('Artist Settings', 'music-pack'), 
	        array($this, 'render_artist_settings_meta'),
	        'js_artist', 					
			'normal', 						
			'high' 							
		);
	}

	public function render_artist_settings_meta($artistObject) {
		$artist_id = $artistObject->ID;

		/*general options*/
		$artist_nickname = esc_html(get_post_meta($artist_id, 'artist_nickname', true));
		$artist_website = esc_url(get_post_meta($artist_id, 'artist_website', true));

		/*social options*/
		$artist_facebook = esc_url(get_post_meta($artist_id, 'artist_facebook', true));
		$artist_twitter = esc_url(get_post_meta($artist_id, 'artist_twitter', true));
		$artist_instagram = esc_url(get_post_meta($artist_id, 'artist_instagram', true));
		$artist_soundcloud = esc_url(get_post_meta($artist_id, 'artist_soundcloud', true));
		$artist_youtube = esc_url(get_post_meta($artist_id, 'artist_youtube', true));
		$artist_spotify = esc_url(get_post_meta($artist_id, 'artist_spotify', true));
		$artist_apple = esc_url(get_post_meta($artist_id, 'artist_apple', true));
		$artist_tiktok = esc_url(get_post_meta($artist_id, 'artist_tiktok', true));

		?>
		<table class= "swp_artist_cpt_opts swp_cpt_opts">
			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Nickname', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_nickname" value="<?php echo esc_attr($artist_nickname); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('Artist nickname, or position in the band, ex: [bass player].', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Website', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_website" value="<?php echo esc_attr($artist_website); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist website.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Facebook URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_facebook" value="<?php echo esc_attr($artist_facebook); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist Facebook profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Twitter URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_twitter" value="<?php echo esc_attr($artist_twitter); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist Twitter profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Instagram URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_instagram" value="<?php echo esc_attr($artist_instagram); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist Instagram profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr> 

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist SoundCloud URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_soundcloud" value="<?php echo esc_attr($artist_soundcloud); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist SoundCloud profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist YouTube URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_youtube" value="<?php echo esc_attr($artist_youtube); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist YouTube profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Spotify URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_spotify" value="<?php echo esc_attr($artist_spotify); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist Spotify profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist Apple Music URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_apple" value="<?php echo esc_attr($artist_apple); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist Apple Music profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td">
	            	<?php echo esc_html__('Artist TikTok URL', 'music-pack');?>
	            </td>
				<td>
					<input class="mp_setting_input" type="text" name="artist_tiktok" value="<?php echo esc_attr($artist_tiktok); ?>" />
					<div class="description mp_setting_desc">
						<?php echo esc_html__('The URL to the artist TikTok profile.', 'music-pack'); ?>
					</div>
				</td>
	        </tr>

			<tr>
				<td>
					<?php wp_nonce_field('mpack_artist_save_action', 'mpack_artist_save_nonce');?>
				</td>
	        </tr>	        
		</table>
		<?php
	}

	public function mp_save_artst_fields($artist_id, $artistObject) {
		if (wp_is_post_autosave($artist_id) || wp_is_post_revision($artist_id)) {
			return;
		}
		
		if ($artistObject->post_type != 'js_artist') {
			return;
		}

		if (!isset($_POST['mpack_artist_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_artist_save_nonce'])), 'mpack_artist_save_action')) {
			return;
		}

		if (!current_user_can('edit_post', $artist_id)) {
			return;
		}		

		if (isset($_POST['artist_nickname'])) {
			update_post_meta($artist_id, 'artist_nickname', sanitize_text_field($_POST['artist_nickname']));
		}
		if (isset($_POST['artist_website'])) {
			update_post_meta($artist_id, 'artist_website', sanitize_url($_POST['artist_website']));
		}
		if (isset($_POST['artist_facebook'])) {
			update_post_meta($artist_id, 'artist_facebook', sanitize_url($_POST['artist_facebook']));
		}
		if (isset($_POST['artist_twitter'])) {
			update_post_meta($artist_id, 'artist_twitter', sanitize_url($_POST['artist_twitter']));
		}
		if (isset($_POST['artist_instagram'])) {
			update_post_meta($artist_id, 'artist_instagram', sanitize_url($_POST['artist_instagram']));
		}
		if (isset($_POST['artist_soundcloud'])) {
			update_post_meta($artist_id, 'artist_soundcloud', sanitize_url($_POST['artist_soundcloud']));
		}
		if (isset($_POST['artist_youtube'])) {
			update_post_meta($artist_id, 'artist_youtube', sanitize_url($_POST['artist_youtube']));
		}
		if (isset($_POST['artist_spotify'])) {
			update_post_meta($artist_id, 'artist_spotify', sanitize_url($_POST['artist_spotify']));
		}
		if (isset($_POST['artist_apple'])) {
			update_post_meta($artist_id, 'artist_apple', sanitize_url($_POST['artist_apple']));
		}
		if (isset($_POST['artist_tiktok'])) {
			update_post_meta($artist_id, 'artist_tiktok', sanitize_url($_POST['artist_tiktok']));
		}
	}

	public function mc_custom_artist_cols($columns) {
		$columns = array(
			'cb'	=> '<input type="checkbox" />',
			'title' => esc_html__('Artist Name', 'music-pack'),
			'date'		=> esc_html__('Date', 'music-pack')		
		);
		
		return $columns;
	}

	public function mp_create_artist_category() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("artist_category");
		if ("" == $slug) {
			$slug = "artist_category";
		}
		
		register_taxonomy(
				'artist_category',
				'js_artist',
				array(
					'labels' => array(
						'name' => esc_html__('Artist Categories', 'music-pack'),
						'singular_name'     => esc_html__('Artist Category', 'music-pack'),
						'search_items'      => esc_html__('Search Artist Categories', 'music-pack' ),
						'all_items'         => esc_html__('All Artist Categories', 'music-pack' ),
						'parent_item'       => esc_html__('Parent Artist Category', 'music-pack' ),
						'parent_item_colon' => esc_html__('Parent Artist Category:', 'music-pack' ),
						'edit_item'         => esc_html__('Edit Artist Category', 'music-pack' ),
						'update_item'       => esc_html__('Update Artist Category', 'music-pack' ),
						'add_new_item' 		=> esc_html__('Add New Artist Category', 'music-pack'),
						'new_item_name' 	=> esc_html__('New Artist Category', 'music-pack'),
					),
					'rewrite' => array(
						'slug' => $slug,
						'with_front' => false
					),
					'show_ui' => true,
					'show_tagcloud' => false,
					'hierarchical' => true
				)
		);
	}
}

$artist_pt_inst = new MPACK_Artist();