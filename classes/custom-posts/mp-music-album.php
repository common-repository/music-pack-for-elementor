<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Music_Album {
	public function __construct() {
		add_action('init', array($this, 'create_music_album_post'));
		add_action('admin_init', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'mp_save_album_fields'), 10, 2);
		add_filter('manage_edit-js_albums_columns', array($this, 'mp_custom_album_admin_columns'));
		add_action('manage_js_albums_posts_custom_column', array($this, 'mp_manage_js_albums_columns'), 10, 2);
		add_filter('manage_edit-js_albums_sortable_columns', array($this, 'mp_albums_sortable_columns'));

		add_action('init', array($this, 'mp_create_album_category'));

		/*AJAX calls*/
		add_action('wp_ajax_mp_update_audio_list', array($this, 'mp_update_audio_list'));
	}

	public function mp_create_album_category() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("album_category");
		if ("" == $slug) {
			$slug = "album_category";
		}
		
		register_taxonomy(
				'album_category',
				'js_albums',
				array(
					'labels' => array(
						'name' => esc_html__('Album Categories', 'music-pack'),
						'singular_name'     => esc_html__('Album Category', 'music-pack' ),
						'search_items'      => esc_html__('Search Album Categories', 'music-pack'  ),
						'all_items'         => esc_html__('All Album Categories', 'music-pack'  ),
						'parent_item'       => esc_html__('Parent Album Category', 'music-pack'  ),
						'parent_item_colon' => esc_html__('Parent Album Category:' , 'music-pack' ),
						'edit_item'         => esc_html__('Edit Album Category', 'music-pack'  ),
						'update_item'       => esc_html__('Update Album Category', 'music-pack'  ),
						'add_new_item' 		=> esc_html__('Add New Album Category', 'music-pack'),
						'new_item_name' 	=> esc_html__('New Album Category', 'music-pack'),
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

	public function mp_albums_sortable_columns($columns) {
		$columns['album_artist'] = 'album_artist';
		$columns['album_label'] = 'album_label';
		$columns['author'] = 'author';
		$columns['album_producer'] = 'album_producer';	

		return $columns;
	}

	public function mp_manage_js_albums_columns($column, $album_id) {
		global $post;
		
		switch($column) {
			case 'album_artist' :
				$album_artist = get_post_meta($album_id, 'album_artist', true);
				echo esc_html($album_artist);
				break;
			case 'album_label':
				$album_label = esc_html(get_post_meta($album_id, 'album_label', true));
				echo esc_html($album_label);
				break;
			case 'album_producer':
				$album_producer = esc_html(get_post_meta($album_id, 'album_producer', true));
				echo esc_html($album_producer);
				break;
			default:
				break;
		}
	}

	public function mp_custom_album_admin_columns($columns) {
		$columns = array(
			'cb'	=> '<input type="checkbox" />',
			'title' => esc_html__('Album Title', 'music-pack'),
			'album_artist' => esc_html__('Album Artist', 'music-pack'),
			'album_label'	=>	__('Label', 'music-pack'),
			'album_producer'	=>	__('Producer', 'music-pack'),		
			'author'	=> esc_html__('Author', 'music-pack'),
			'date'		=> esc_html__('Date', 'music-pack')		
			
		);
		
		return $columns;
	}

	public function mp_save_album_fields($album_id, $album) {
		if (wp_is_post_autosave($album_id) || wp_is_post_revision($album_id)) {
			return;
		}

		if ('js_albums' != $album->post_type) {
			return;
		}
		if (!isset($_POST['mpack_music_album_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_music_album_save_nonce'])), 'mpack_music_album_save_action')) {
			return;
		}		
		if (!current_user_can('edit_post', $album_id)) {
			return;
		}

        if (isset($_POST['album_artist'])) {
            update_post_meta($album_id, 'album_artist', sanitize_text_field($_POST['album_artist']));
        }
        if (isset($_POST['album_release_date'])) {
            update_post_meta($album_id, 'album_release_date', MPACK_Utils::sanitize_date($_POST['album_release_date']));
        }
        if (isset($_POST['album_no_disc'])) {
            update_post_meta($album_id, 'album_no_disc', sanitize_text_field($_POST['album_no_disc']));
        }
        if (isset($_POST['album_label'])) {
            update_post_meta($album_id, 'album_label', sanitize_text_field($_POST['album_label']));
        }
		if (isset($_POST['album_producer'])) {
            update_post_meta($album_id, 'album_producer', sanitize_text_field($_POST['album_producer']));
        }
		if (isset($_POST['album_catalogue_number'])) {
            update_post_meta($album_id, 'album_catalogue_number', sanitize_text_field($_POST['album_catalogue_number']));
        }		
        if (isset($_POST['album_youtube'])) {
            update_post_meta($album_id, 'album_youtube', sanitize_url($_POST['album_youtube']));
        }				
        if (isset($_POST['album_vimeo'])) {
            update_post_meta($album_id, 'album_vimeo', sanitize_url($_POST['album_vimeo']));
        }
        if (isset($_POST['album_buy_message1'])) {
            update_post_meta($album_id, 'album_buy_message1', sanitize_text_field($_POST['album_buy_message1']));
        }				
        if (isset($_POST['album_buy_link1'])) {
            update_post_meta($album_id, 'album_buy_link1', sanitize_url($_POST['album_buy_link1']));
        }
        if (isset($_POST['album_buy_message2'])) {
            update_post_meta($album_id, 'album_buy_message2', sanitize_text_field($_POST['album_buy_message2']));
        }				
        if (isset($_POST['album_buy_link2'])) {
            update_post_meta($album_id, 'album_buy_link2', sanitize_url($_POST['album_buy_link2']));
        }
        if (isset($_POST['album_buy_message3'])) {
            update_post_meta($album_id, 'album_buy_message3', sanitize_text_field($_POST['album_buy_message3']));
        }				
        if (isset($_POST['album_buy_link3'])) {
            update_post_meta($album_id, 'album_buy_link3', sanitize_url($_POST['album_buy_link3']));
        }
        if (isset($_POST['album_buy_message4'])) {
            update_post_meta($album_id, 'album_buy_message4', sanitize_text_field($_POST['album_buy_message4']));
        }				
        if (isset($_POST['album_buy_link4'])) {
            update_post_meta($album_id, 'album_buy_link4', sanitize_url($_POST['album_buy_link4']));
        }
        if (isset($_POST['album_buy_message5'])) {
            update_post_meta($album_id, 'album_buy_message5', sanitize_text_field($_POST['album_buy_message5']));
        }				
        if (isset($_POST['album_buy_link5'])) {
            update_post_meta($album_id, 'album_buy_link5', sanitize_url($_POST['album_buy_link5']));
        }
        if (isset($_POST['album_buy_message6'])) {
            update_post_meta($album_id, 'album_buy_message6', sanitize_text_field($_POST['album_buy_message6']));
        }				
        if (isset($_POST['album_buy_link6'])) {
            update_post_meta($album_id, 'album_buy_link6', sanitize_url($_POST['album_buy_link6']));
        }		
        if (isset($_POST['album_songs_ids'])) {
        	update_post_meta($album_id, 'album_songs_ids', sanitize_text_field($_POST['album_songs_ids']));
        }
	}

	public function add_meta_boxes() {
		/* album information */
	    add_meta_box('albums_meta_box',
	        esc_html__('Album Settings','music-pack'),
	        array($this, 'render_album_settings_meta_box'),
	        'js_albums',
			'normal',
			'high'
	    );
		
		/* album songs */	
	    add_meta_box('albums_song_list_meta_box',
	        esc_html__('Album Song List','music-pack'),
	        array($this, 'render_album_songs_list_meta_box'),
	        'js_albums',
			'normal',
			'default'
	    );
	}

	public function mp_update_audio_list() {
		if (!isset($_POST['audio_ids_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['audio_ids_nonce'])), 'mpack_music_album_audiolist_action')) {

			$ret['success'] = false;
			$ret['audio_list'] = '';
			die();
		}

		$album_songs_str_ids	= sanitize_text_field($_POST['audio_ids']);
		$mp3List = $this->song_list_html($album_songs_str_ids);
		
		$ret['success'] = true;
		$ret['audio_list'] = $mp3List;
		
		echo json_encode($ret );
		die();
	}

	public function render_album_songs_list_meta_box($album_post) {
		$album_ID = $album_post->ID;
		$album_songs_ids = get_post_meta($album_ID, 'album_songs_ids', true);

		echo $this->song_list_html($album_songs_ids);
		?>
		<input class="mp_hidden_input" id="album_songs_ids" type="text" name="album_songs_ids" value="<?php echo esc_attr($album_songs_ids); ?>" />
		<?php wp_nonce_field('mpack_music_album_audiolist_action', 'mpack_music_album_audiolist_nonce');?>

		<div class="mp_songlist_btn_container">
			<input type="button" id="mp_add_song" class="button action" value="<?php echo esc_html__('Add New Song To Album', 'music-pack'); ?>">
		</div>
		<?php
	}

	public function render_album_settings_meta_box($album_post) {
		$album_ID = $album_post->ID;
	    // Retrieve current name of the custom fields album ID
		$album_artist = esc_html(get_post_meta($album_ID, 'album_artist', true));
	    $album_release_date = esc_html(get_post_meta($album_ID, 'album_release_date', true));
	    $album_no_disc = esc_html(get_post_meta($album_ID, 'album_no_disc', true)); 
		$album_label = esc_html(get_post_meta($album_ID, 'album_label', true)); 	
		$album_producer	= esc_html(get_post_meta($album_ID, 'album_producer', true));
		$album_catalogue_number = esc_html(get_post_meta($album_ID, 'album_catalogue_number', true));

		$album_youtube = esc_url(get_post_meta($album_ID, 'album_youtube', true)); 			
		$album_vimeo = esc_url(get_post_meta($album_ID, 'album_vimeo', true));
		
		$album_buy_message1 = esc_html(get_post_meta($album_ID, 'album_buy_message1', true)); 			
		$album_buy_link1 = esc_url(get_post_meta($album_ID, 'album_buy_link1', true)); 			
		
		$album_buy_message2 = esc_html(get_post_meta($album_ID, 'album_buy_message2', true)); 			
		$album_buy_link2 = esc_url(get_post_meta($album_ID, 'album_buy_link2', true)); 			

		$album_buy_message3 = esc_html(get_post_meta($album_ID, 'album_buy_message3', true)); 			
		$album_buy_link3 = esc_url(get_post_meta($album_ID, 'album_buy_link3', true)); 			

		$album_buy_message4 = esc_html(get_post_meta($album_ID, 'album_buy_message4', true)); 			
		$album_buy_link4 = esc_url(get_post_meta($album_ID, 'album_buy_link4', true));
		
		$album_buy_message5 = esc_html(get_post_meta($album_ID, 'album_buy_message5', true)); 			
		$album_buy_link5 = esc_url(get_post_meta($album_ID, 'album_buy_link5', true));

		$album_buy_message6 = esc_html(get_post_meta($album_ID, 'album_buy_message6', true)); 			
		$album_buy_link6 = esc_url(get_post_meta($album_ID, 'album_buy_link6', true));
		
	
	    ?>
	    <table style= "width: 100%;">
	       <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Artist/Band','music-pack');?></td>
				<td>
					<input class="mp_setting_input" type="text" name="album_artist" value="<?php echo esc_attr($album_artist); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Artist/Band Name','music-pack'); ?></div>
				</td>
	        </tr>	
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Release Date','music-pack');?></td>
	            <td >
	            	<input id="datepicker" class="swp_datepicker mp_setting_input" type="text" name="album_release_date" value="<?php echo esc_attr($album_release_date); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Album Release Date YYYY/MM/DD','music-pack'); ?></div>
				</td>
	        </tr>
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Number of Discs','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text"  name="album_no_disc" value="<?php echo esc_attr($album_no_disc); ?>" /> 
					<div class="mp_setting_desc"> <?php echo esc_html__('Number of Discs  1/2/3...','music-pack');  ?></div>
				</td>
	        </tr>
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Label','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text"  name="album_label" value="<?php echo esc_attr($album_label); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Record Label - like - Chess Records','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Producer','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text"  name="album_producer" value="<?php echo esc_attr($album_producer); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Album Producer - like - Bob Rock','music-pack'); ?></div>
				</td>
	        </tr>
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Catalogue Number','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text"  name="album_catalogue_number" value="<?php echo esc_attr($album_catalogue_number); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Catalogue Number - like - 650001','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Youtube Promo URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_youtube" value="<?php echo esc_attr($album_youtube); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Youtube URL - like - http://youtu.be/jUk-5nsGedM ','music-pack'); ?></div>
				</td>
	        </tr>						
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Vimeo Promo URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_vimeo" value="<?php echo esc_attr($album_vimeo); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Vimeo URL - like - http://vimeo.com/8119784 ','music-pack'); ?></div>
				</td>
	        </tr>
			
	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message1" value="<?php echo esc_attr($album_buy_message1); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from Amazon','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link1" value="<?php echo esc_url($album_buy_link1); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - http://www.amazon.com/Old-Sock-Eric-Clapton/dp/B00B23O96A/ref=ntt_mus_ep_dpi_1 ','music-pack'); ?></div>
				</td>
	        </tr>

	        <tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message2" value="<?php echo esc_attr($album_buy_message2); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from iTunes','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link2" value="<?php echo esc_url($album_buy_link2); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - https://itunes.apple.com/us/album/living-proof/id394442693 ','music-pack'); ?></div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message3" value="<?php echo esc_attr($album_buy_message3); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from SoundCloud','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link3" value="<?php echo esc_url($album_buy_link3); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - http://www.last.fm/music/Radiohead/1995-06-01:+Tramps,+New+York,+NY,+USA ','music-pack'); ?></div>
				</td>
	        </tr>	
			
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message4" value="<?php echo esc_attr($album_buy_message4); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from eBay','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link4" value="<?php echo esc_url($album_buy_link4); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','music-pack'); ?></div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message5" value="<?php echo esc_attr($album_buy_message5); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from Google Play','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link5" value="<?php echo esc_url($album_buy_link5); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','music-pack'); ?></div>
				</td>
	        </tr>

			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy Message','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_message6" value="<?php echo esc_attr($album_buy_message6); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy Message - like - Buy It from Google Play','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
	            <td class="mp_setting_label_td"><?php echo esc_html__('Buy URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="album_buy_link6" value="<?php echo esc_url($album_buy_link6); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','music-pack'); ?></div>
				</td>
	        </tr>		
			<tr>
				<td>
					<?php wp_nonce_field('mpack_music_album_save_action', 'mpack_music_album_save_nonce');?>
				</td>
	        </tr>
	    </table>
	    <?php
	}

	private function song_list_html($album_songs_ids) {

		$idsArray = explode(',', $album_songs_ids);
		$idsArray = array_filter($idsArray);

		ob_start()
		?>

		<div id="audio_list">
			<ul id="ul_sortable_list">
				<?php foreach($idsArray as $track_id ) { 
					$audio = get_post($track_id)
					?>
					<li id="<?php echo esc_attr($audio->ID);?>" class="mp_album_audio_list_entry">
						<div class="song_name"><?php echo esc_html($audio->post_title);?></div>
						<div class="song_controls">
							<span class="remove_audio" rel="<?php echo esc_attr($audio->ID);?>"><?php echo esc_html__('Remove', 'music-pack'); ?></span>
						</div>		
					</li>
				<?php } ?>
			</ul>
		</div>

		<?php

		$html_output = ob_get_clean();
		return $html_output;
	}

	public function create_music_album_post() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("js_albums");
		if (!strlen($slug)) {
			$slug = "js_albums";
		}
		
		register_post_type('js_albums',
			array(
				'labels' => array(
					'name' =>  esc_html__('Discography', 'music-pack') ,
					'singular_name' =>  esc_html__('Album', 'music-pack') ,
					'add_new' => esc_html__('Add New Album', 'music-pack'),
					'add_new_item' => esc_html__('Add New Album', 'music-pack'),
					'edit' => esc_html__('Edit', 'music-pack'),
					'edit_item' => esc_html__('Edit Album', 'music-pack'),
					'new_item' => esc_html__('New Album', 'music-pack'),
					'view' => esc_html__('View', 'music-pack'),
					'view_item' => esc_html__('View Album', 'music-pack'),
					'search_items' => esc_html__('Search Albums', 'music-pack'),
					'not_found' => esc_html__('No Album Found','music-pack'),
					'not_found_in_trash' => esc_html__('No Album Found in Trash','music-pack'),
					'parent' => esc_html__('Parent Album','music-pack')
				),
				'public' => true,
				'rewrite' => array(
					'slug' => $slug,
					'with_front' => false
				),	
				'supports' => array('title', 'editor', 'comments', 'thumbnail', 'author'),
				'menu_icon' => 'dashicons-format-audio',
			)
		);
	}
}

$album_pt_inst = new MPACK_Music_Album();