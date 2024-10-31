<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Video {
	public function __construct() {
		add_action('init', array($this, 'create_video_post'));
		add_action('admin_init', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'mp_save_video_fields'), 10, 2);

		add_filter('manage_edit-js_videos_columns', array($this, 'mc_custom_video_cols'));
		add_action('manage_js_videos_posts_custom_column', array($this, 'mc_manage_video_cols'), 10, 2);
		add_filter('manage_edit-js_videos_sortable_columns', array($this, 'mc_video_sortable_cols'));

		add_action('init', array($this, 'mp_create_video_category'), 11);
	}


	public function create_video_post() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("js_videos");
		if ( "" == $slug) {
			$slug = "js_videos";
		}
		
		register_post_type( 'js_videos',
			array(
				'labels' => array(
					'name' =>  esc_html__('Videos', 'music-pack'),
					'singular_name' =>  esc_html__('Video', 'music-pack'),
					'add_new' => esc_html__('Add New Video', 'music-pack'),
					'add_new_item' => esc_html__('Add New Video', 'music-pack'),
					'edit' => esc_html__('Edit', 'music-pack'),
					'edit_item' => esc_html__('Edit Video', 'music-pack'),
					'new_item' => esc_html__('New Video', 'music-pack'),
					'view' => esc_html__('View', 'music-pack'),
					'view_item' => esc_html__('View Video', 'music-pack'),
					'search_items' => esc_html__('Search Videos', 'music-pack'),
					'not_found' => esc_html__('No Videos Found','music-pack'),
					'not_found_in_trash' => esc_html__('No Videos Found in Trash','music-pack'),
					'parent' => esc_html__('Parent Video','music-pack')
				),
			'public' => true,
			'rewrite' => array(
				'slug' => $slug,
				'with_front' => false
				),			
			'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'author'),
			'menu_icon' => 'dashicons-video-alt2'
			)
		); 
	}

	public function add_meta_boxes() {
	    add_meta_box(
	    	'video_meta_box',
	        esc_html__('Video Custom Settings', 'music-pack'),
	        array($this, 'render_meta_box'),
	        'js_videos',
			'normal',
			'high'
		);
	}

	public function render_meta_box($videoObject) {
		$youtube_url = esc_html(get_post_meta($videoObject->ID, 'video_youtube_url', true)); 	
		$vimeo_url = esc_html(get_post_meta($videoObject->ID, 'video_vimeo_url', true)); 		
		
	    ?>
	    <table style= "width: 100%;">
	        <tr >
	            <td class="mp_setting_label_td"><?php echo esc_html__('Youtube URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text"  name="js_video_youtube_url" value="<?php echo esc_url($youtube_url); ?>" />
					<div class="mp_setting_desc"><?php echo esc_html__('Youtube short url like - http://youtu.be/jUk-5nsGedM .','music-pack'); ?></div>
				</td>
	        </tr>		
	        <tr>
	            <td style= "width: 30%;"><?php echo esc_html__('Vimeo URL','music-pack');?></td>
				<td>
					<input class="mp_setting_input"  type="text" name="js_video_vimeo_url" value="<?php echo esc_url($vimeo_url); ?>" />
					<div class="mp_setting_desc"> <?php echo esc_html__('Vimeo short url like - http://vimeo.com/8119784 .','music-pack'); ?></div>
				</td>
	        </tr>
			<tr>
				<td>
					<?php wp_nonce_field('mpack_video_save_action', 'mpack_video_save_nonce');?>
				</td>
	        </tr>	        
	    </table>
	    <?php
	}

	public function mp_save_video_fields($js_video_id, $js_video) {
		if (wp_is_post_autosave($js_video_id) || wp_is_post_revision($js_video_id)) {
			return;
		}
		
	    if ('js_videos' != $js_video->post_type) {
			return;
		}
		if (!isset($_POST['mpack_video_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_video_save_nonce'])), 'mpack_video_save_action')) {
			return;
		}
		if (!current_user_can('edit_post', $js_video_id)) {
			return;
		}
				
		if ( isset( $_POST['js_video_youtube_url'])) {
			update_post_meta( $js_video_id, 'video_youtube_url', sanitize_url($_POST['js_video_youtube_url']));
		}		
		if ( isset( $_POST['js_video_vimeo_url'])) {
			update_post_meta( $js_video_id, 'video_vimeo_url', sanitize_url($_POST['js_video_vimeo_url']));
		}
	}

	public function mc_custom_video_cols($columns) {
		$columns = array(
			'cb'	=> '<input type="checkbox" />',
			'title' => esc_html__('Video Title', 'music-pack'),
			'video_youtube_url'	=>	__('Youtube URL', 'music-pack'),		
			'video_vimeo_url'	=>	__('Vimeo URL', 'music-pack'),
			'author'	=> esc_html__('Author', 'music-pack'),
			'date'		=> esc_html__('Date', 'music-pack')		
			
		);
		
		return $columns;
	}

	public function mc_manage_video_cols($column, $js_video_id) {
		global $post;
		
		switch($column) {
			case 'video_youtube_url' :
				$youtube_url = get_post_meta($js_video_id, 'video_youtube_url', true);
				echo esc_url($youtube_url);
				break;
			case 'video_vimeo_url':
				$vimeo_url = get_post_meta($js_video_id, 'video_vimeo_url', true);
				echo esc_url($vimeo_url);
				break;
			default:
				break;
		}
	}

	public function mc_video_sortable_cols($columns) {
		$columns['video_youtube_url'] = 'video_youtube_url';
		$columns['video_vimeo_url'] = 'video_vimeo_url';
		$columns['author'] = 'author';

		return $columns;
	}

	public function mp_create_video_category() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("video_category");
		if ( "" == $slug) {
			$slug = "video_category";
		}

		register_taxonomy(
				'video_category',
				'js_videos',
				array(
					'labels' => array(
						'name' => esc_html__('Video Categories', 'music-pack'),
						'singular_name'     => esc_html__( 'Video Category', 'music-pack'),
						'search_items'      => esc_html__( 'Search Video Categories', 'music-pack' ),
						'all_items'         => esc_html__( 'All Video Categories', 'music-pack' ),
						'parent_item'       => esc_html__( 'Parent Video Category', 'music-pack' ),
						'parent_item_colon' => esc_html__( 'Parent Video Category:', 'music-pack' ),
						'edit_item'         => esc_html__( 'Edit Video Category', 'music-pack' ),
						'update_item'       => esc_html__( 'Update Video Category', 'music-pack' ),
						'add_new_item' 		=> esc_html__('Add New Video Category', 'music-pack'),
						'new_item_name' 	=> esc_html__('New Video Category', 'music-pack'),
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

$video_pt_inst = new MPACK_Video();