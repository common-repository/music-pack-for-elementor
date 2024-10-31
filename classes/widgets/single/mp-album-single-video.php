<?php 

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MP_Album_Single_Video extends MPACK_Widget_Single_Video {

	public function get_name() {
		return 'sm-album-single-video';
	}

	public function get_title() {
		return __('Album Single: Video', 'music-pack');
	}

	public function get_icon() {
		return 'eicon-play mpack-widget-icon';
	}

	public function get_categories() {
		return ['mpack-widgets'];
	}

	public function get_keywords() {
		return [ 'music pack', 'event single', 'album video', 'vimeo', 'youtube'];
	}

	protected function register_controls() {
		parent::register_controls();

		global $post;
		$album_ID = $post->ID;

		if (!MPACK_Utils::is_post_type($album_ID, "js_albums")) {
			/*for some reason, is_singular() does not work here*/
			return;
		}

		$album_youtube = esc_url(get_post_meta($album_ID, 'album_youtube', true));
		$album_vimeo = esc_url(get_post_meta($album_ID, 'album_vimeo', true));

		if (!strlen($album_youtube) && !strlen($album_vimeo)) {
			return;
		}

		$video_type = strlen($album_youtube) ? 'youtube' : 'vimeo';
		$this->update_control(
			'video_type',
			[
				'default' => $video_type,
			]
		);			

		if ("youtube" == $video_type) {
			$this->update_control(
				'youtube_url',
				[
					'default' => $album_youtube,
				]
			);

			return;
		}

		if ("vimeo" == $video_type) {
			$this->update_control(
				'vimeo_url',
				[
					'default' => $album_vimeo,
				]
			);
		}
	}
}