jQuery(document).ready(function($) {
	'use strict';

	runMasonryGallery($);

	$(window).on("debouncedresize", function(event) {
		runMasonryGallery($);
	});
});
function runMasonryGallery($) {
	var $grid = $('.lc_masonry_container.gallery_single_img_container').imagesLoaded(function() {

		$grid.find('.lc_single_gallery_brick').each(function(){
			var brick_height = Math.ceil($(this).find('img').height()); 
			$(this).css("height", brick_height);
		});

		$grid.masonry({
			itemSelector: '.lc_masonry_brick',
			percentPosition: true,
			columnWidth: '.brick-size',
		}); 
	});
}
!function(e){var n,t,i=e.event;n=i.special.debouncedresize={setup:function(){e(this).on("resize",n.handler)},teardown:function(){e(this).off("resize",n.handler)},handler:function(e,o){var r=this,s=arguments,d=function(){e.type="debouncedresize",i.dispatch.apply(r,s)};t&&clearTimeout(t),o?d():t=setTimeout(d,n.threshold)},threshold:150}}(jQuery);