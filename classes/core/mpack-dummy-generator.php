<?php 

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Dummy_Generator {
	private $post_content;
	private $placeholder_img_url;
	private $placeholder_name;
	private $placeholder_id;
	private $dummy_video_url;

	public function __construct() {
		$this->placeholder_name = 'mpack-placeholder-generic';
		$this->post_content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
		$this->placeholder_img_url = MPACK_DIR_URL . 'img/mpack-placeholder-generic.jpg';
		$this->dummy_video_url = "https://youtu.be/WsptdUFthWI";

		$this->set_placeholder_img_id();
	}

	public function generate() {
		$this->generate_discography();
		$this->generate_events();
		$this->generate_artists();
		$this->generate_videos();
	}

	private function generate_discography() {
		$post_titles = array("Woman", "Too Good at Goodbyes", "Rubbin Off The Pain", "No More Love");
		$release_dates = array("2016/11/04", "2017/11/04", "2018/11/04", "2019/11/04");

		foreach($post_titles as $album_index => $post_title) {
			$album_id = wp_insert_post(
				array(
                    'post_title'    => $post_title,
                    'post_content'  => $this->post_content,
                    'post_type'   => 'js_albums',
                    'post_status'   => 'publish',
				)
			);

			update_post_meta($album_id, 'album_artist', 'MusicPackArtist');
			update_post_meta($album_id, 'album_release_date', $release_dates[$album_index]);
			update_post_meta($album_id, 'album_label', 'RCA');
			update_post_meta($album_id, 'album_catalogue_number', '650001');
			update_post_meta($album_id, 'album_no_disc', '1');
			update_post_meta($album_id, 'album_producer', 'MP Producer');
			update_post_meta($album_id, 'album_youtube', esc_url($this->dummy_video_url));

			$this->set_thumbnail($album_id);
		}
	}

	private function generate_events() {
		$post_titles = array("AfterHills Festival", "Wakestock Festival", "Rockness Festival", "Lollapalooza Festival");
		$release_dates = array("2023/07/10", "2023/08/20", "2023/09/17", "2023/10/10");

		foreach($post_titles as $event_index => $post_title) {
			$event_id = wp_insert_post(
				array(
                    'post_title'    => $post_title,
                    'post_content'  => $this->post_content,
                    'post_type'   => 'js_events',
                    'post_status'   => 'publish',
				)
			);

			update_post_meta($event_id, 'event_date', $release_dates[$event_index]);
			update_post_meta($event_id, 'event_time', '20:00');
			update_post_meta($event_id, 'event_venue', $post_title);
			update_post_meta($event_id, 'event_venue_url', "#");
			update_post_meta($event_id, 'event_location', "Abersoch, Gwynedd, UK");

			$this->set_thumbnail($event_id);
		}
	}

	private function generate_artists() {
		$post_titles = array("Jordan Paul", "Derek Dixon", "Joel Lindsey", "Mabelle Howell");
		$nicknames = array("Jordan", "Derek", "Joel", "Mabelle");

		foreach($post_titles as $artist_index => $post_title) {
			$artist_id = wp_insert_post(
				array(
                    'post_title'    => $post_title,
                    'post_content'  => $this->post_content,
                    'post_type'   => 'js_artist',
                    'post_status'   => 'publish',
				)
			);

			update_post_meta($artist_id, 'artist_nickname', $nicknames[$artist_index]);
			update_post_meta($artist_id, 'artist_twitter', '#');
			update_post_meta($artist_id, 'artist_soundcloud', '#');
			update_post_meta($artist_id, 'artist_spotify', '#');

			$this->set_thumbnail($artist_id);
		}
	}

	private function generate_videos() {
		$post_titles = array("Something Just Like This", "Scared To Be Lonely", "Bad And Boujee", "Treat You Better");
		
		foreach($post_titles as $video_index => $post_title) {
			$video_id = wp_insert_post(
				array(
                    'post_title'    => $post_title,
                    'post_content'  => $this->post_content,
                    'post_type'   => 'js_videos',
                    'post_status'   => 'publish',
				)
			);
			update_post_meta($video_id, 'video_youtube_url', esc_url($this->dummy_video_url));

			$this->set_thumbnail($video_id);
		}
	}

	private function set_placeholder_img_id() {
		$placeholder_id = $this->get_placeholder_id_by_slug($this->placeholder_name);
		if (strlen($placeholder_id)) {
			$this->placeholder_id = $placeholder_id;
			return;
		} 

		$this->placeholder_id = $this->insert_placeholder_img_to_media_lib();
	}

	private function insert_placeholder_img_to_media_lib() {
		$wp_filetype = wp_check_filetype($this->placeholder_img_url, null);
		$bits = file_get_contents($this->placeholder_img_url);
		$upload = wp_upload_bits("mpack-placeholder-generic.jpg", null, $bits);
		$params['guid'] = $upload['url'];
		$params['post_mime_type'] = $wp_filetype['type'];
		$params['post_name'] = $this->placeholder_name;
		$attach_id = wp_insert_attachment($params, $upload['file'], 0);
		
		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			include( ABSPATH . 'wp-admin/includes/image.php' );
		}
		$attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
		wp_update_attachment_metadata( $attach_id, $attach_data);

		return $attach_id;
	}

	private function get_placeholder_id_by_slug($img_name) {
        $args           = array(
            'posts_per_page' => 1,
            'post_type'      => 'attachment',
            'name'           => trim($img_name),
        );

 		$image = get_posts($args);

 		return sizeof($image) ? $image[0]->ID : '';
	}

	private function set_thumbnail($post_id) {
		if (!strlen($this->placeholder_id)) {
			return;
		}

		set_post_thumbnail($post_id, $this->placeholder_id);
	}
}