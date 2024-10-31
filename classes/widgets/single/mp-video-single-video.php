<?php 

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Video_Single_Video extends MPACK_Widget_Single_Video {

	public function get_name() {
		return 'sm-video-single-video';
	}

	public function get_title() {
		return __('Video Single: Video', 'music-pack');
	}

	public function get_icon() {
		return 'eicon-play mpack-widget-icon';
	}

	public function get_categories() {
		return ['mpack-widgets'];
	}

	public function get_keywords() {
		return [ 'music pack', 'video single', 'video', 'vimeo', 'youtube'];
	}

	protected function register_controls() {
		parent::register_controls();

		global $post;
		$videoID = $post->ID;

		if (!MPACK_Utils::is_post_type($videoID, "js_videos")) {
			/*for some reason, is_singular() does not work here*/
			return;
		}

		$album_youtube = esc_html(get_post_meta($videoID, 'video_youtube_url', true)); 			
		$album_vimeo = esc_html(get_post_meta($videoID, 'video_vimeo_url', true));

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