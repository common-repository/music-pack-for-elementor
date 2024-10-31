<?php 

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MPACK_Event_Single_Video extends MPACK_Widget_Single_Video {

	public function get_name() {
		return 'sm-event-single-video';
	}

	public function get_title() {
		return __('Event Single: Video', 'music-pack');
	}

	public function get_icon() {
		return 'eicon-play mpack-widget-icon';
	}

	public function get_categories() {
		return ['mpack-widgets'];
	}

	public function get_keywords() {
		return [ 'music pack', 'event single', 'event video', 'vimeo', 'youtube'];
	}

	protected function register_controls() {
		parent::register_controls();

		global $post;
		$event_id = $post->ID;

		if (!MPACK_Utils::is_post_type($event_id, "js_events")) {
			/*for some reason, is_singular() does not work here*/
			return;
		}

		$event_youtube_url  = esc_url(get_post_meta($event_id, 'event_youtube_url', true));	
		$event_vimeo_url  = esc_url(get_post_meta($event_id, 'event_vimeo_url', true));

		if (!strlen($event_youtube_url) && !strlen($event_vimeo_url)) {
			return;
		}

		$video_type = strlen($event_youtube_url) ? 'youtube' : 'vimeo';
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
					'default' => $event_youtube_url,
				]
			);

			return;
		}

		if ("vimeo" == $video_type) {
			$this->update_control(
				'vimeo_url',
				[
					'default' => $event_vimeo_url,
				]
			);
		}
	}

}