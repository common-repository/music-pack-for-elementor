<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Photo_Album {
	public function __construct() {
		add_action('init', array($this, 'create_photo_album_post'));
		add_action('admin_init', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'mp_save_photo_album_fields'), 10, 2);

		add_filter('manage_edit-js_photo_albums_columns', array($this, 'mp_custom_photo_album_admin_columns'));
		add_filter('manage_edit-js_photo_albums_sortable_columns', array($this, 'mp_albums_sortable_columns'));

		add_action('init', array($this, 'mp_create_photo_album_category'));

		add_action( 'wp_ajax_mp_update_gallery_preview', array($this, 'mp_update_gallery_preview'));
	}

	public function create_photo_album_post() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("js_photo_albums");
		if ( "" == $slug) {
			$slug = "js_photo_albums";
		}
		
		register_post_type( 'js_photo_albums',
			array(
				'labels' => array(
					'name' =>  esc_html__('Photo Albums', 'music-pack') ,
					'singular_name' =>  esc_html__('Photo Album', 'music-pack') ,
					'add_new' => esc_html__('Add New Photo Album', 'music-pack'),
					'add_new_item' => esc_html__('Add New Photo Album', 'music-pack'),
					'edit' => esc_html__('Edit', 'music-pack'),
					'edit_item' => esc_html__('Edit Photo Album', 'music-pack'),
					'new_item' => esc_html__('New Photo Album', 'music-pack'),
					'view' => esc_html__('View', 'music-pack'),
					'view_item' => esc_html__('View Photo Album', 'music-pack'),
					'search_items' => esc_html__('Search Photo Albums', 'music-pack'),
					'not_found' => esc_html__('No Photo Albums found','music-pack'),
					'not_found_in_trash' => esc_html__('No Photo Albums Found in Trash','music-pack'),
					'parent' => esc_html__('Parent Photo Album','music-pack')
				),
			'public' => true,
			'rewrite' => array(
				'slug' => $slug,
				'with_front' => false
				),			
			'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'author'),
			'menu_icon' => 'dashicons-camera'
			)
		);
	}

	public function add_meta_boxes() {
	    add_meta_box(
	    	'photo_albums_meta_box',
	        esc_html__('Image Gallery','music-pack'),
	        array($this, 'mp_render_photo_album_meta_box'),
	        'js_photo_albums',
			'normal',
			'high'
		);
	}

	public function mp_render_photo_album_meta_box($photoAlbumObject) {
		$js_swp_gallery_images_id = esc_html(get_post_meta($photoAlbumObject->ID, 'js_swp_gallery_images_id', true));		
		?>
		
		<div id="js_swp_cpt_gallery_container">
			<div id="js_swp_gallery_content">
				<?php $this->fill_gallery_preview_container($js_swp_gallery_images_id); ?>
			</div>
			
			<div id="js_swp_add_image_container">
				<input type="button" id="js_swp_add_image_gallery_cpt" class="button button-primary" value="<?php echo esc_html__('Add Images To Gallery', 'music-pack'); ?>" />
			</div>
			
			<input type="text" name="js_swp_gallery_images_id" id="js_swp_gallery_images_id" value="<?php echo esc_attr($js_swp_gallery_images_id); ?>" />
			<?php wp_nonce_field('mpack_gallery_save_action', 'mpack_gallery_save_nonce');?>
		</div>

		<?php
	}

	private function fill_gallery_preview_container($image_ids) {
		$idsArray = explode(',', $image_ids);
		$idsArray = array_filter($idsArray);
		if (empty($idsArray)) {
			return;
		}

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

		<ul class="js_swp_gallery_cpt_preview ui-sortable" id="js_gallery_admin">
			<?php foreach($idsArray as $imgID) {
				$imgTag = wp_get_attachment_image($imgID, 'small');
				?>
				<li class="image_cell ui-sortable-handle" id="<?php echo esc_attr($imgID); ?>">
					<?php echo wp_kses($imgTag, $allowed_html); ?>
					<div class="image_action remove_gallery_cpt_image" data-imid="<?php echo esc_attr($imgID); ?>"><?php echo esc_html__('Remove', 'music-pack');?></div>
				</li>
			<?php } ?>
		</ul>
		<?php
	}

	public function mp_save_photo_album_fields($gallery_id, $galleryObject) {
		if (wp_is_post_autosave($gallery_id) || wp_is_post_revision($gallery_id)) {
			return;
		}
		
		if ('js_photo_albums' != $galleryObject->post_type) {
			return;
		}
		if (!isset($_POST['mpack_gallery_save_nonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpack_gallery_save_nonce'])), 'mpack_gallery_save_action')) {
			return;
		}
		if (!current_user_can('edit_post', $gallery_id)) {
			return;
		}				

		if(isset( $_POST['js_swp_gallery_images_id'])) {
			update_post_meta($gallery_id, 'js_swp_gallery_images_id', sanitize_text_field($_POST['js_swp_gallery_images_id']));
		}
	}

	public function mp_custom_photo_album_admin_columns($columns) {
		$columns = array(
			'cb'	=> '<input type="checkbox" />',
			'title' => esc_html__('Photo Album Title', 'music-pack'),
			'author'	=> esc_html__('Author', 'music-pack'),
			'date'		=> esc_html__('Date', 'music-pack')		
			
		);
		
		return $columns;
	}

	public function mp_albums_sortable_columns($columns) {
		$columns['author'] = 'author';
		return $columns;
	}

	public function mp_create_photo_album_category() {
		$slug = MPACK_Menu_Pages::get_slug_from_settings("photo_album_category");
		if ("" == $slug) {
			$slug = "photo_album_category";
		}
		
		register_taxonomy(
				'photo_album_category',
				'js_photo_albums',
				array(
					'labels' => array(
						'name' => esc_html__('Photo Album Categories', 'music-pack'),
						'singular_name'     => esc_html__( 'Photo Album Category', 'music-pack'),
						'search_items'      => esc_html__( 'Search Photo Album Categories', 'music-pack' ),
						'all_items'         => esc_html__( 'All Photo Album Categories', 'music-pack' ),
						'parent_item'       => esc_html__( 'Parent Photo Album Category', 'music-pack' ),
						'parent_item_colon' => esc_html__( 'Parent Photo Album Category:', 'music-pack' ),
						'edit_item'         => esc_html__( 'Edit Photo Album Category' , 'music-pack'),
						'update_item'       => esc_html__( 'Update Photo Album Category', 'music-pack' ),
						'add_new_item' 		=> esc_html__('Add New Photo Album Category', 'music-pack'),
						'new_item_name' 	=> esc_html__('New Photo Album Category', 'music-pack'),
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

	public function mp_update_gallery_preview() {
		if (!isset($_POST['imageIdsNonce']) || 
			!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['imageIdsNonce'])), 'mpack_gallery_save_action')) {
			
			$ret['success'] = false;
			$ret['gallery'] = '';
			die();
		}
		
		$ret['success'] = true;
		
		$imgIds = sanitize_text_field($_POST['image_ids']);

		ob_start();
		?>
		
		<div id="js_swp_gallery_content">
			<?php $this->fill_gallery_preview_container($imgIds); ?>
		</div>

		<?php
		$ret['gallery'] = ob_get_clean();
		
		echo json_encode( $ret);
		die();
	}
}

$photo_album_pt_inst = new MPACK_Photo_Album();