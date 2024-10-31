(function($) {
    var MPEventsCards = function($scope, $) {
		handleCustomAspectRatio($scope, $);

	    handleJsBgImage($scope, $);

	    $(window).on("resize", function(event) {
			handleCustomAspectRatio($scope, $);
	    });
    };

    var handleJsBgImage = function($scope, $, handleBgPosition = 1) { 

        $scope.find(".lc_swp_background_image").each(function() {
            var imgSrc = $(this).data("bgimage");

            $(this).css("background-image", "url("+imgSrc+")");
            $(this).css("background-repeat", "no-repeat");
            $(this).css("background-size","cover");

            if (!handleBgPosition) {
                return;
            }
            var bg_position = "center center";

            if ($(this).hasClass('swp_align_bg_img')) {
                bg_position = "center " + $(this).data('valign');
            }
            $(this).css("background-position", bg_position);
        });
    };

	var hanldeJsLinks = function($scope, $) {
		$scope.find('.lc_js_link').click(function(event) {
			event.preventDefault();
			var newLocation = $(this).data("href");
			var newWin = '';
			if ($(this).data("target")) {
				newWin = $(this).data("target");
			}
			window.open(newLocation, newWin);
		});
	}

    var handleCustomAspectRatio = function($scope, $) {
        $scope.find('.swp_custom_ar').each(function() {
            if ($(this).hasClass("ar_square")) {
                $(this).css("height", $(this).width() );
            }       
            if ($(this).hasClass("ar_43")) {
                $(this).css("height", $(this).width() / 4 * 3);
            }
            if ($(this).hasClass("ar_169")) {
                $(this).css("height", $(this).width() / 16 * 9);
            }
            if ($(this).hasClass("ar_1910")) {
                $(this).css("height", $(this).width() / 19 * 10);
            }        
        });
    }

    var handleCountdown = function($scope, $) {
        $scope.find('.swp_event_countdown').each(function(){
            var countDownDate = new Date($(this).data("todate")).getTime();
            var currentDate = new Date().getTime();

            if (currentDate > countDownDate) {
              $(this).find('.days_amount').html(0);
              $(this).find('.hours_amount').html(0);
              $(this).find('.mins_amount').html(0);
              $(this).find('.seconds_amount').html(0);

              return;
            }
        
        var countDate = new Date($(this).data("todate"));
            var $container = $(this);
            var x = setInterval(function() {

              // Get todays date and time
              var now = new Date().getTime();

              // Find the distance between now an the count down date
              var distance = countDownDate - now;

              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              // Display the result in the element with id="demo"
              $container.find('.days_amount').html(days);
              $container.find('.hours_amount').html(hours);
              $container.find('.mins_amount').html(minutes);
              $container.find('.seconds_amount').html(seconds);

            }, 1000);       
        });
    }

    var videoImageContainer = function($scope, $) {
        $scope.find('.video_image_container').each(function() {
            var no_px_width = parseFloat($(this).css('width'));
            $(this).css("height", no_px_width * 9/16);
            $(this).closest('.single_video_item').css("opacity", 1);
        });
    }

    var handleVideosArchive = function($scope, $) {
        handleJsBgImage($scope, $);
        videoImageContainer($scope, $);
        MPVideoPlayBtn($scope, $);

        $(window).on("resize", function(event) {
            videoImageContainer($scope, $);
        });
    }

    var MPReviewSlider = function($scope, $) {
        $scope.find('.lc_reviews_slider').each(function() {
            var slide_speed = 400;
            var slide_delay = 4000;

            if (typeof $(this).parent().data('slidespeed') !== 'undefined') {
                slide_speed = $(this).parent().data('slidespeed');
            }
            if (typeof $(this).parent().data('slidedelay') !== 'undefined') {
                slide_delay = $(this).parent().data('slidedelay');
            }

            var arrows_val = {
                prev: '<a class="unslider-arrow prev"><div class="swp_unslider_arrow swp_arrow_left"></div></a>',
                next: '<a class="unslider-arrow next"><div class="swp_unslider_arrow swp_arrow_right"></div></a>',
            };

            if (1 == $(this).find('li').length) {
                arrows_val = false;
            }

            $(this).unslider({
                arrows: arrows_val,
                autoplay: true,
                nav: false,
                delay: slide_delay,
                speed: slide_speed
            });
        });
    }

    var runGallery = function($scope, $) {
        $scope.find('.lc_masonry_container').each(function(){
            var $grid = $(this).imagesLoaded(function() {
                
                var gap_width = $grid.data("gapwidth");
                var bricks_on_row = $grid.data( "bricksonrow");
                var container_outer_width = $grid.outerWidth();
                var container_width = $grid.width();

                var bricks_on_row_responsive = getGalleryResponsiveBricksOnRow($, bricks_on_row, container_outer_width);
                var brick_width = (container_width - (bricks_on_row_responsive - 1) * gap_width) / bricks_on_row_responsive;
                var default_height = 3/4 * brick_width;

                $grid.find(".brick-size").css("width", brick_width);
                $grid.find('.lc_masonry_brick').each(function() {
                    $(this).css("margin-bottom", gap_width);
                    var $image = $(this).find('img');
                    var img_src = $image.attr("src");

                    var imageObj = new Image();
                    imageObj.src = $image.attr("src");

                    if (bricks_on_row_responsive <= 2) {
                        $(this).css("height", default_height);
                        $(this).css("width", brick_width);
                    } else {
                        if ($(this).hasClass("brick_landscape")) {
                            $(this).css("width", 2*brick_width + gap_width);
                            $(this).css("height", default_height);
                        } else if ($(this).hasClass("brick_portrait")) {
                            $(this).css("width", brick_width);
                            $(this).css("height", 2*default_height + gap_width);
                        } else {
                            $(this).css("width", brick_width);
                            $(this).css("height", default_height);
                        }                        
                    }
                });

                var $mp_bricks = $grid.bricksLayout({
                    itemSelector: '.lc_masonry_brick',
                    columnWidth: brick_width,
                    gutter: gap_width,
                });

                $mp_bricks.bricksLayout();
                $grid.fadeTo("400", 1);
            });
        });
    }

    var MPBlogPosts = function($scope, $) {
        $scope.find('.lc_blog_masonry_container').each(function() {
            var $grid = $(this).imagesLoaded(function() {
                var gap_width = $grid.data("gapwidth");
                var container_width = $grid.width();
                var container_outer_width = $grid.outerWidth();
                var bricks_on_row = $grid.data( "bricksonrow" );

                var bricks_on_row_responsive = getMasonryBricksOnRow($, bricks_on_row, container_outer_width );
                var brick_width = (container_width - (bricks_on_row_responsive - 1) * gap_width) / bricks_on_row_responsive;

                $( ".lc_blog_masonry_brick" ).css("width", brick_width);
                    $grid.bricksLayout({
                        columnWidth  : brick_width,
                        itemSelector : '.lc_blog_masonry_brick',
                        gutter       : gap_width
                    });

                $grid.fadeTo("400", 1);
            });

        });
    }

    var MPMCSubscribe = function($scope, $) {
        $('.at_mc_subscr_form_container').each(function(){
            var $container = $(this);
            var $button = $(this).find('.at_news_button_entry');

            $(this).find('form.swp_mc_subscr_form').submit(function(event) {
                event.preventDefault();
                $button.val($button.data('loadingmsg'));
                $container.find('.swp_mc_form_error').empty();
                $container.find('.swp_mc_form_error').hide();

                var form_vals = {
                    newsletter_email: $(this).find('input[name="newsletter_email"]').val(),
                    mpack_subform_nonce: $(this).find('input[name="mpack_subform_nonce"]').val()
                }

                var data = {
                    action: 'swpmcform_action',
                    //data: $(this).find(":input").serialize()
                    data: form_vals
                };

                $.post(DATAVALUES.ajaxurl, data, function(response) {
                    var obj;
                    
                    try {
                        obj = $.parseJSON(response);
                    }
                    catch(e) {
                        $container.find('.swp_mc_form_error').append(DATAVALUES.generalErrorText);
                        $button.val($button.data('btnval'));
                        return;
                    }

                    if(obj.success === true) {
                        $container.find('.swp_mc_form_success').show('slow');
                        $container.find('input').each(function(){
                            $(this).val('');
                        })
                    } else {
                        $container.find('.swp_mc_form_error').append(obj.error);
                        $container.find('.swp_mc_form_error').show('slow');
                        
                    }
                    $button.val($button.data('btnval'));
                });         

            });
        });
    }

    var MPContactForm = function($scope, $) {
        $scope.find("form.swp_contactform").submit(function(event) {
            event.preventDefault();

            $("form.swp_contactform").find(".form_result_error").val('');
            $("form.swp_contactform").find(".form_result_error").hide();
            $("form.swp_contactform").find(".swp_cf_error").hide();
            
            var name = $.trim($(this).find("input#contactName").val());
            var email = $.trim($(this).find("input#contactemail").val());
            var message = $.trim($(this).find("textarea#commentsText").val());
            var required_is_empty = false;

            if ('' == name) {
                required_is_empty = true;
                $(this).find('.mp-contact-form-author').find('.swp_cf_error').show('slow');
            }

            if ('' == email) {
                required_is_empty = true;
                $(this).find('.mp-contact-form-email').find('.swp_cf_error').show('slow');
            }

            if ('' == message) {
                required_is_empty = true;
                $(this).find('.comment-form-comment').find('.swp_cf_error').show('slow');
            }

            if (required_is_empty) {
                return;
            }

            var form_data = {
                'contactName' : name,
                'email' : email,
                'comments' : message,
                'swp_cf_subject' : $("form.swp_contactform").find('input[name="swp_cf_subject"]').val(),
                'mpack_cf_nonce' : $("form.swp_contactform").find('#mpack_cf_nonce').val()
            }

            var data = {
                action: 'swpcontactform_action',
                data: form_data
            };

            var $button = $(this).find(".lc_button.contact_button");
            var old_button_val = $button.val();

            $button.val($button.data('loadingmsg'));

            $.post(DATAVALUES.ajaxurl, data, function(response) {
                var obj;
                
                try {
                    obj = $.parseJSON(response);
                }
                catch(e) {
                    $button.val(old_button_val);
                    $("form.swp_contactform").find(".form_result_error").append(obj.error);
                    $("form.swp_contactform").find(".form_result_error").show('slow');
                    return;
                }

                if(obj.success === true) {
                    $("form.swp_contactform").find(".formResultOK").find(".swp_cf_error").show("slow");

                    $("form.swp_contactform").find("input#contactName").val('');
                    $("form.swp_contactform").find("input#contactemail").val('');
                    $("form.swp_contactform").find("textarea#commentsText").val('');
                } else {

                    if (obj.error === 'wp_mail_failed') {
                        $("form.swp_contactform").find(".wp_mail_error").find(".swp_cf_error").show("slow");
                    } else {
                        $("form.swp_contactform").find(".form_result_error").append(obj.error);
                        $("form.swp_contactform").find(".form_result_error").show('slow');
                    }
                }
                $button.val(old_button_val);
            });     

        });
    }

    var MPMusicAlbums = function($scope, $) {
        handleCustomAspectRatio($scope, $);
        handleJsBgImage($scope, $);
        $(window).on("resize", function(event) {
            handleCustomAspectRatio($scope, $);
        });
    }

    var MPMusicAlbumsVinyl = function($scope, $) {
        handleJsBgImage($scope, $);
        handleVinylAR($scope, $);

        $(window).on("resize", function(event) {
            handleVinylAR($scope, $);
        });
    }

    var handleVinylAR = function($scope, $) {
        $scope.find('.album_image_container').each(function() {
            var no_px_width = parseFloat($(this).css('width'));
            $(this).css("height", no_px_width);
            $(this).parent().parent().parent().css("opacity", 1);
        });        
    }

    var MPVideoPlayBtn = function($scope, $) {
        $scope.find('.mp_play_lightbox_video').click(function() {

            $('body').css("overflow-y", "hidden");
            var video_overlay = '<div class="swp_video_overlay"><div class="swp_video_overlay_inner"><div class="swp_video_iframe_container"></div></div><i class="close_swp_video_overlay fas fa-times"></i></div>';
            $('body').append(video_overlay);

            var video_source = $(this).data("vsource");
            var video_id = $(this).data("vid");
            var video_frame = '';
            if ("youtube" == video_source) {
                video_frame = '<iframe class="at_video_frame" src="' + location.protocol + '//www.youtube.com/embed/' + video_id + '?autoplay=1&amp;showinfo=0&amp;rel=0&amp;byline=0&amp;title=0&amp;portrait=0"></iframe>';
            }
            else if ("vimeo" == video_source) {
                video_frame = '<iframe class="at_video_frame" src="' + location.protocol + '//player.vimeo.com/video/' + video_id + '?autoplay=1&amp;byline=0&amp;title=0&amp;portrait=0"></iframe>';
            }
            
            
            $('.swp_video_iframe_container').append(video_frame);

            $('.close_swp_video_overlay').click(function(){
                $('.swp_video_overlay').remove();
                $('body').css("overflow-y", "auto");
            });        
        });
    }

    var getGalleryResponsiveBricksOnRow = function($, default_number, container_outer_width, breakpoints) {
        if (undefined === breakpoints) {
            breakpoints = {1: 480, 2: 768 };
        }
        if (container_outer_width <= breakpoints[1] ) {
            return 2;
        }
        else if (container_outer_width <= breakpoints[2] ) {
            return 3;
        }
        else {
            return default_number;
        }
    }

    var getMasonryBricksOnRow = function($, default_number, container_outer_width, breakpoints) {
        if (undefined === breakpoints) {
            breakpoints = {1: 480, 2: 980, 3: 1680 };
        }
        if (container_outer_width <= breakpoints[1] ) {
            return 1;
        }
        else if (container_outer_width <= breakpoints[2] ) {
            return 2;
        }
        else if (container_outer_width <= breakpoints[3] ) {
            return 3;
        }
        else {
            return default_number;
        }
    }

    var toMinutes = function(seconds) {
        seconds = Math.floor(seconds);
        min_part = Math.floor(seconds/60);
        sec_part = seconds % 60;
        if (sec_part < 10) {
            sec_part = '0' + sec_part;
        }
        return min_part + ":" + sec_part;
    }

    var handleSlidePlayer = function($scope, player_selector) {
        $scope.find(player_selector).each(function() {

            var item_hover_color = $(this).data("entryhbgcolor");
            $(this).find('.swp_music_player_entry.wpb_smc_elt').each(function(){
                $(this).hover(
                    function() {
                        $(this).css("background-color", item_hover_color);
                    }, function() {
                        $(this).css("background-color", "transparent");
                    }
                );
            });

            var $player = $(this);
            var player_id = $player.attr("id");
            var $play_btn = $player.find('.fa-play.player_play');
            var $pause_btn = $player.find('.fa-pause');
            var $fwd_btn = $player.find('.fa-step-forward');
            var $bkw_btn = $player.find('.fa-step-backward');       
            var $first_song = $player.find('.swp_music_player_entry').first();
            var $last_song = $player.find('.swp_music_player_entry').last();
            var $playing_song_name = $player.find('.current_song_name');
            var $playing_album_name = $player.find('.current_album_name');
            var $time_slider = $player.find('.player_time_slider');
            var $song_duration = $player.find('.song_duration');
            var $song_current_progress = $player.find('.song_current_progress');
            var autoplay = $player.data('autoplay');
            var playmode = $player.data('playmode');
            var stop_on_playlist_end = $player.data('stopplaylistend');
            var repeatmode = $player.data("repeatmode");
            var shuffle_btn_on = false, repeat_btn_on = false;
            var $ps_elt = $player.find('.compact-playback-speed');
            var $ps_val = $ps_elt.find('.ps-val');
            var $ps_opts = $player.find('ul.compact-ps-opts');
            var other_mpfe = new Array();


            $('.swp_music_player').not('#' + player_id).each(function(){
                other_mpfe.push($(this).attr('id'));
            });

            $ps_val.click(function(){
                $ps_opts.toggle();
            })
            $('.compact-ps-opt').click(function(){
                var new_pstext = $(this).text();
                var new_psval = new_pstext.substring(0,new_pstext.length - 1)
                $ps_opts.toggle();
                $ps_val.text(new_pstext);
                $player.find('audio').each(function() {
                    $(this).get(0).playbackRate = new_psval;
                });
            })

            function handleCoverImg($crt_elt) {
                if(!$player.data('playerimg')) {
                    return;
                }

                if (!$crt_elt.data('trackimg')) {
                    /*set the album default img*/
                    $player.find('.music_player_left').removeAttr("style");
                    return;
                }

                /*song individual cover*/
                $player.find('.music_player_left').css('background-image', 'url(' + $crt_elt.data('trackimg') + ')');
            }

            function handleAlbumInfoForCompact($crt_elt) {
                if (!$player.hasClass('compact-player')) {
                    return;
                }

                $playing_album_name.text($crt_elt.find('.player_song_name').data('albumname'));
            }

            function stopOtherPlayers() {
                other_mpfe.forEach(function(mpfe_player_id){
                    var $crt_play = $('#' + mpfe_player_id).find('.swp_music_player_entry.now_playing');
                    if ($crt_play.length){
                        $crt_play.find('audio').get(0).pause();
                        $('#' + mpfe_player_id).find('.fa-play.player_play').removeClass("display_none");
                        $('#' + mpfe_player_id).find('.fa-pause').addClass("display_none");         
                    }
                });
            }

            $player.find('.swp_music_player_entry').each(function(){
                var $player_entry = $(this);
                var audio = new Audio($player_entry.data("mediafile"));
                audio.type= 'audio/mpeg';
                audio.preload = 'metadata';
                $(this).append(audio);



                audio.onloadedmetadata = function() {
                    $player_entry.find('.entry_duration').text(toMinutes(audio.duration));
                    if ($first_song.is($player_entry)) {
                        $song_duration.text(toMinutes(audio.duration));
                    }
                };

                audio.onended  = function() {
                    var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                    var $next_elt = get_next_player_elt($crt_elt);

                    $playing_song_name.text($next_elt.find('.player_song_name').text());
                    $song_duration.text(toMinutes($next_elt.find('audio').get(0).duration));
                    $crt_elt.removeClass('now_playing');
                    $next_elt.addClass('now_playing');

                    if (("yes" == stop_on_playlist_end) && (!$crt_elt.next().length)) {
                        $play_btn.removeClass("display_none");
                        $pause_btn.addClass("display_none");
                        
                        return;
                    }

                    $next_elt.find('audio').get(0).play();
                    stopOtherPlayers();
                    handleCoverImg($next_elt);
                    handleAlbumInfoForCompact($next_elt);
                    $play_btn.addClass("display_none");
                    $pause_btn.removeClass("display_none");
                };          

                audio.addEventListener("timeupdate", function() {
                    var currentTime = audio.currentTime;
                    var duration = audio.duration;
                    $time_slider.stop(true,true).css('width', (currentTime +.25)/duration*100+'%');
                    $song_current_progress.text(toMinutes(currentTime));
                });         
            });

            /*load the 1st song*/
            $first_song.addClass("now_playing");
            $playing_song_name.text($first_song.find('.player_song_name').text());
            handleAlbumInfoForCompact($first_song);

            $song_current_progress.text("0:00");
            if ("yes" == autoplay) {
                var fp_response = $first_song.find('audio').get(0).play();
                handleCoverImg($first_song);
                if (fp_response!== undefined) {
                    fp_response.then(_ => {
                        $play_btn.toggleClass("display_none");
                        $pause_btn.toggleClass("display_none");
                        stopOtherPlayers();
                    }).catch(error => {
                        $(document).click(function(e) {
                            if (!$first_song.hasClass("autoplay_loaded")) {
                                $first_song.find('audio').get(0).play();
                                $play_btn.toggleClass("display_none");
                                $pause_btn.toggleClass("display_none");
                                $first_song.addClass("autoplay_loaded");
                            }
                        });
                    });
                }
            }

            $play_btn.unbind().click(function() {
                stopOtherPlayers();
                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).play();
                stopOtherPlayers();
                handleCoverImg($crt_elt);
                handleAlbumInfoForCompact($crt_elt);
                $play_btn.addClass("display_none");
                $pause_btn.removeClass("display_none");
            });
            $pause_btn.unbind().click(function() {
                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).pause();
                $play_btn.removeClass("display_none");
                $pause_btn.addClass("display_none");
            });

            $fwd_btn.unbind().click(function() {
                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).pause();

                var $next_elt = get_next_player_elt($crt_elt);

                $playing_song_name.text($next_elt.find('.player_song_name').text());
                $next_elt.find('audio').get(0).play();
                stopOtherPlayers();
                handleCoverImg($next_elt);
                handleAlbumInfoForCompact($next_elt);
                $song_duration.text(toMinutes($next_elt.find('audio').get(0).duration));
                $crt_elt.removeClass('now_playing');
                $next_elt.addClass('now_playing');
                $play_btn.addClass("display_none");
                $pause_btn.removeClass("display_none");
            });

            $bkw_btn.unbind().click(function() {
                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).pause();
                var $prev_elt = $crt_elt.prev();
                if (!$prev_elt.length) {
                    $prev_elt = $last_song;
                }
                $playing_song_name.text($prev_elt.find('.player_song_name').text());
                $prev_elt.find('audio').get(0).play();
                stopOtherPlayers();
                handleCoverImg($prev_elt);
                handleAlbumInfoForCompact($prev_elt);
                $song_duration.text(toMinutes($prev_elt.find('audio').get(0).duration));
                $crt_elt.removeClass('now_playing');
                $prev_elt.addClass('now_playing');
                $play_btn.addClass("display_none");
                $pause_btn.removeClass("display_none");
            });

            $player.find('.player_entry_left').click(function(){
                var $next_elt = $(this).parent();
                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).pause();
                $crt_elt.removeClass('now_playing');

                $next_elt.addClass('now_playing');
                $next_elt.find('audio').get(0).play();
                stopOtherPlayers();
                handleCoverImg($next_elt);
                handleAlbumInfoForCompact($next_elt);
                $song_duration.text(toMinutes($(this).parent().find('audio').get(0).duration));
                $playing_song_name.text($(this).find('.player_song_name').text());

                $play_btn.addClass("display_none");
                $pause_btn.removeClass("display_none");         
            });

            $player.find('.player_time_slider_base').click(function(e){
                var $slider_elt = $(this);
                var click_pos = e.pageX - Math.floor($slider_elt.offset().left);
                var elt_width = $slider_elt.width();
                var percent_progress = Math.floor(click_pos/elt_width*100);
                $time_slider.width(percent_progress + "%");

                var $crt_elt = $player.find('.swp_music_player_entry.now_playing');
                $crt_elt.find('audio').get(0).currentTime = $crt_elt.find('audio').get(0).duration * (percent_progress/100);
            });

            var get_next_player_elt = function($crt_elt) {
                if ("repeat" == playmode) {
                    if (("current_song" == repeatmode) && repeat_btn_on) {
                        return $crt_elt;
                    }

                    var $next_elt = $crt_elt.next();
                    if (!$next_elt.length) {
                        $next_elt = $first_song;
                    }
                    return $next_elt;
                }
                /*shuffle*/
                var $playlist = $player.find('.swp_music_player_entry').not('.now_playing').toArray();
                return jQuery($playlist[Math.floor(Math.random() * $playlist.length)]);
            }

            $player.find('i.playback-shuffle').click(function(e){
                if(shuffle_btn_on) {
                    $player.attr('data-playmode', "repeat");
                    playmode = "repeat";
                    shuffle_btn_on = false;
                } else {
                    $player.attr('data-playmode', "shuffle");
                    playmode = "shuffle";
                    shuffle_btn_on = true;
                }
                $(this).toggleClass("is_active");
            });
            $player.find('i.playback-repeat').click(function(e){
                if (repeat_btn_on) {
                    if (shuffle_btn_on) {
                        $player.attr('data-playmode', "shuffle");
                        playmode = "shuffle";
                    }
                    repeat_btn_on = false;
                } else {
                    $player.attr('data-playmode', "repeat");
                    playmode = "repeat";
                    repeat_btn_on = true;
                }
                $(this).toggleClass("is_active");
            });

        });
    }

    var MPFESlideMusicPlayer = function($scope, $) {
        $scope.find('.mpfe-sr-helper').click(function(e){
            e.preventDefault();
        });

        handleSlidePlayer($scope, '.swp_music_player');
    }

    var MPArtistCreative = function($scope, $) {
        handleJsBgImage($scope, $, 0);
    }

	$(window).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/events-list.default",
            hanldeJsLinks
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/events-cards.default",
            MPEventsCards
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/event-countdown.default",
            handleCountdown
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-videos.default",
            handleVideosArchive
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-artists.default",
            handleJsBgImage
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-review-slider.default",
            MPReviewSlider
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-blog-posts.default",
            MPBlogPosts
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-mailchimp-subscribe.default",
            MPMCSubscribe
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-contact-form.default",
            MPContactForm
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-music-albums.default",
            MPMusicAlbums
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-music-albums-vinyl.default",
            MPMusicAlbumsVinyl
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-video-play-button.default",
            MPVideoPlayBtn 
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-gallery.default",
            runGallery
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/slide-music-player-free.default",
            MPFESlideMusicPlayer
        );
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/mp-artist-creative.default",
            MPArtistCreative
        );        
	});

    $(window).resize(function() {
        runGallery($('.elementor-widget-mp-gallery'), $);
    });

    /*unslider*/
    !function($){return $?($.Unslider=function(t,n){var e=this;return e._="unslider",e.defaults={autoplay:!1,delay:3e3,speed:750,easing:"swing",keys:{prev:37,next:39},nav:!0,arrows:{prev:'<a class="'+e._+'-arrow prev">Prev</a>',next:'<a class="'+e._+'-arrow next">Next</a>'},animation:"horizontal",selectors:{container:"ul:first",slides:"li"},animateHeight:!1,activeClass:e._+"-active",swipe:!0,swipeThreshold:.2},e.$context=t,e.options={},e.$parent=null,e.$container=null,e.$slides=null,e.$nav=null,e.$arrows=[],e.total=0,e.current=0,e.prefix=e._+"-",e.eventSuffix="."+e.prefix+~~(2e3*Math.random()),e.interval=null,e.init=function(t){return e.options=$.extend({},e.defaults,t),e.$container=e.$context.find(e.options.selectors.container).addClass(e.prefix+"wrap"),e.$slides=e.$container.children(e.options.selectors.slides),e.setup(),$.each(["nav","arrows","keys","infinite"],function(t,n){e.options[n]&&e["init"+$._ucfirst(n)]()}),jQuery.event.special.swipe&&e.options.swipe&&e.initSwipe(),e.options.autoplay&&e.start(),e.calculateSlides(),e.$context.trigger(e._+".ready"),e.animate(e.options.index||e.current,"init")},e.setup=function(){e.$context.addClass(e.prefix+e.options.animation).wrap('<div class="'+e._+'" />'),e.$parent=e.$context.parent("."+e._);var t=e.$context.css("position");"static"===t&&e.$context.css("position","relative"),e.$context.css("overflow","hidden")},e.calculateSlides=function(){if(e.total=e.$slides.length,"fade"!==e.options.animation){var t="width";"vertical"===e.options.animation&&(t="height"),e.$container.css(t,100*e.total+"%").addClass(e.prefix+"carousel"),e.$slides.css(t,100/e.total+"%")}},e.start=function(){return e.interval=setTimeout(function(){e.next()},e.options.delay),e},e.stop=function(){return clearTimeout(e.interval),e},e.initNav=function(){var t=$('<nav class="'+e.prefix+'nav"><ol /></nav>');e.$slides.each(function(n){var i=this.getAttribute("data-nav")||n+1;$.isFunction(e.options.nav)&&(i=e.options.nav.call(e.$slides.eq(n),n,i)),t.children("ol").append('<li data-slide="'+n+'">'+i+"</li>")}),e.$nav=t.insertAfter(e.$context),e.$nav.find("li").on("click"+e.eventSuffix,function(){var t=$(this).addClass(e.options.activeClass);t.siblings().removeClass(e.options.activeClass),e.animate(t.attr("data-slide"))})},e.initArrows=function(){e.options.arrows===!0&&(e.options.arrows=e.defaults.arrows),$.each(e.options.arrows,function(t,n){e.$arrows.push($(n).insertAfter(e.$context).on("click"+e.eventSuffix,e[t]))})},e.initKeys=function(){e.options.keys===!0&&(e.options.keys=e.defaults.keys),$(document).on("keyup"+e.eventSuffix,function(t){$.each(e.options.keys,function(n,i){t.which===i&&$.isFunction(e[n])&&e[n].call(e)})})},e.initSwipe=function(){var t=e.$slides.width();"fade"!==e.options.animation&&e.$container.on({movestart:function(t){return t.distX>t.distY&&t.distX<-t.distY||t.distX<t.distY&&t.distX>-t.distY?!!t.preventDefault():void e.$container.css("position","relative")},move:function(n){e.$container.css("left",-(100*e.current)+100*n.distX/t+"%")},moveend:function(n){Math.abs(n.distX)/t>e.options.swipeThreshold?e[n.distX<0?"next":"prev"]():e.$container.animate({left:-(100*e.current)+"%"},e.options.speed/2)}})},e.initInfinite=function(){var t=["first","last"];$.each(t,function(n,i){e.$slides.push.apply(e.$slides,e.$slides.filter(':not(".'+e._+'-clone")')[i]().clone().addClass(e._+"-clone")["insert"+(0===n?"After":"Before")](e.$slides[t[~~!n]]()))})},e.destroyArrows=function(){$.each(e.$arrows,function(t,n){n.remove()})},e.destroySwipe=function(){e.$container.off("movestart move moveend")},e.destroyKeys=function(){$(document).off("keyup"+e.eventSuffix)},e.setIndex=function(t){return 0>t&&(t=e.total-1),e.current=Math.min(Math.max(0,t),e.total-1),e.options.nav&&e.$nav.find('[data-slide="'+e.current+'"]')._active(e.options.activeClass),e.$slides.eq(e.current)._active(e.options.activeClass),e},e.animate=function(t,n){if("first"===t&&(t=0),"last"===t&&(t=e.total),isNaN(t))return e;e.options.autoplay&&e.stop().start(),e.setIndex(t),e.$context.trigger(e._+".change",[t,e.$slides.eq(t)]);var i="animate"+$._ucfirst(e.options.animation);return $.isFunction(e[i])&&e[i](e.current,n),e},e.next=function(){var t=e.current+1;return t>=e.total&&(t=0),e.animate(t,"next")},e.prev=function(){return e.animate(e.current-1,"prev")},e.animateHorizontal=function(t){var n="left";return"rtl"===e.$context.attr("dir")&&(n="right"),e.options.infinite&&e.$container.css("margin-"+n,"-100%"),e.slide(n,t)},e.animateVertical=function(t){return e.options.animateHeight=!0,e.options.infinite&&e.$container.css("margin-top",-e.$slides.outerHeight()),e.slide("top",t)},e.slide=function(t,n){if(e.options.animateHeight&&e._move(e.$context,{height:e.$slides.eq(n).outerHeight()},!1),e.options.infinite){var i;n===e.total-1&&(i=e.total-3,n=-1),n===e.total-2&&(i=0,n=e.total-2),"number"==typeof i&&(e.setIndex(i),e.$context.on(e._+".moved",function(){e.current===i&&e.$container.css(t,-(100*i)+"%").off(e._+".moved")}))}var o={};return o[t]=-(100*n)+"%",e._move(e.$container,o)},e.animateFade=function(t){var n=e.$slides.eq(t).addClass(e.options.activeClass);e._move(n.siblings().removeClass(e.options.activeClass),{opacity:0}),e._move(n,{opacity:1},!1)},e._move=function(t,n,i,o){return i!==!1&&(i=function(){e.$context.trigger(e._+".moved")}),t._move(n,o||e.options.speed,e.options.easing,i)},e.init(n)},$.fn._active=function(t){return this.addClass(t).siblings().removeClass(t)},$._ucfirst=function(t){return(t+"").toLowerCase().replace(/^./,function(t){return t.toUpperCase()})},$.fn._move=function(){return this.stop(!0,!0),$.fn[$.fn.velocity?"velocity":"animate"].apply(this,arguments)},void($.fn.unslider=function(t){return this.each(function(){var n=$(this);if("string"==typeof t&&n.data("unslider")){t=t.split(":");var e=n.data("unslider")[t[0]];if($.isFunction(e))return e.apply(n,t[1]?t[1].split(","):null)}return n.data("unslider",new $.Unslider(n,t))})})):console.warn("Unslider needs jQuery")}(window.jQuery);
    /*bricksLayout*/
    !function(t,e){"function"==typeof define&&define.amd?define("jquery-bridget/jquery-bridget",["jquery"],(function(i){return e(t,i)})):"object"==typeof module&&module.exports?module.exports=e(t,require("jquery")):t.jQueryBridget=e(t,t.jQuery)}(window,(function(t,e){"use strict";var i=Array.prototype.slice,n=t.console,o=void 0===n?function(){}:function(t){n.error(t)};function r(n,r,a){function h(t,e,i){var r,s="$()."+n+'("'+e+'")';return t.each((function(t,h){var u=a.data(h,n);if(u){var d=u[e];if(d&&"_"!=e.charAt(0)){var l=d.apply(u,i);r=void 0===r?l:r}else o(s+" is not a valid method")}else o(n+" not initialized. Cannot call methods, i.e. "+s)})),void 0!==r?r:t}function u(t,e){t.each((function(t,i){var o=a.data(i,n);o?(o.option(e),o._init()):(o=new r(i,e),a.data(i,n,o))}))}(a=a||e||t.jQuery)&&(r.prototype.option||(r.prototype.option=function(t){a.isPlainObject(t)&&(this.options=a.extend(!0,this.options,t))}),a.fn[n]=function(t){if("string"==typeof t){var e=i.call(arguments,1);return h(this,t,e)}return u(this,t),this},s(a))}function s(t){!t||t&&t.bridget||(t.bridget=r)}return s(e||t.jQuery),r})),function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}("undefined"!=typeof window?window:this,(function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},n=i[t]=i[t]||[];return-1==n.indexOf(e)&&n.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{};return(i[t]=i[t]||{})[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=i.indexOf(e);return-1!=n&&i.splice(n,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){i=i.slice(0),e=e||[];for(var n=this._onceEvents&&this._onceEvents[t],o=0;o<i.length;o++){var r=i[o];n&&n[r]&&(this.off(t,r),delete n[r]),r.apply(this,e)}return this}},e.allOff=function(){delete this._events,delete this._onceEvents},t})), function(t,e){"function"==typeof define&&define.amd?define("get-size/get-size",e):"object"==typeof module&&module.exports?module.exports=e():t.getSize=e()}(window,(function(){"use strict";function t(t){var e=parseFloat(t);return-1==t.indexOf("%")&&!isNaN(e)&&e}var e="undefined"==typeof console?function(){}:function(t){console.error(t)},i=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],n=i.length;function o(t){var i=getComputedStyle(t);return i||e("Style returned "+i+". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"),i}var r,s=!1;function a(e){if(function(){if(!s){s=!0;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(e);var n=o(e);r=200==Math.round(t(n.width)),a.isBoxSizeOuter=r,i.removeChild(e)}}(),"string"==typeof e&&(e=document.querySelector(e)),e&&"object"==typeof e&&e.nodeType){var h=o(e);if("none"==h.display)return function(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0;e<n;e++)t[i[e]]=0;return t}();var u={};u.width=e.offsetWidth,u.height=e.offsetHeight;for(var d=u.isBorderBox="border-box"==h.boxSizing,l=0;l<n;l++){var c=i[l],f=h[c],m=parseFloat(f);u[c]=isNaN(m)?0:m}var p=u.paddingLeft+u.paddingRight,g=u.paddingTop+u.paddingBottom,y=u.marginLeft+u.marginRight,v=u.marginTop+u.marginBottom,_=u.borderLeftWidth+u.borderRightWidth,z=u.borderTopWidth+u.borderBottomWidth,E=d&&r,b=t(h.width);!1!==b&&(u.width=b+(E?0:p+_));var x=t(h.height);return!1!==x&&(u.height=x+(E?0:g+z)),u.innerWidth=u.width-(p+_),u.innerHeight=u.height-(g+z),u.outerWidth=u.width+y,u.outerHeight=u.height+v,u}}return a})),function(t,e){"use strict";"function"==typeof define&&define.amd?define("desandro-matches-selector/matches-selector",e):"object"==typeof module&&module.exports?module.exports=e():t.matchesSelector=e()}(window,(function(){"use strict";var t=function(){var t=window.Element.prototype;if(t.matches)return"matches";if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0;i<e.length;i++){var n=e[i]+"MatchesSelector";if(t[n])return n}}();return function(e,i){return e[t](i)}})),function(t,e){"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["desandro-matches-selector/matches-selector"],(function(i){return e(t,i)})):"object"==typeof module&&module.exports?module.exports=e(t,require("desandro-matches-selector")):t.fizzyUIUtils=e(t,t.matchesSelector)}(window,(function(t,e){var i={extend:function(t,e){for(var i in e)t[i]=e[i];return t},modulo:function(t,e){return(t%e+e)%e}},n=Array.prototype.slice;i.makeArray=function(t){return Array.isArray(t)?t:null==t?[]:"object"==typeof t&&"number"==typeof t.length?n.call(t):[t]},i.removeFrom=function(t,e){var i=t.indexOf(e);-1!=i&&t.splice(i,1)},i.getParent=function(t,i){for(;t.parentNode&&t!=document.body;)if(t=t.parentNode,e(t,i))return t},i.getQueryElement=function(t){return"string"==typeof t?document.querySelector(t):t},i.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},i.filterFindElements=function(t,n){t=i.makeArray(t);var o=[];return t.forEach((function(t){if(HTMLElement,n){e(t,n)&&o.push(t);for(var i=t.querySelectorAll(n),r=0;r<i.length;r++)o.push(i[r])}else o.push(t)})),o},i.debounceMethod=function(t,e,i){i=i||100;var n=t.prototype[e],o=e+"Timeout";t.prototype[e]=function(){var t=this[o];clearTimeout(t);var e=arguments,r=this;this[o]=setTimeout((function(){n.apply(r,e),delete r[o]}),i)}},i.docReady=function(t){var e=document.readyState;"complete"==e||"interactive"==e?setTimeout(t):document.addEventListener("DOMContentLoaded",t)},i.toDashed=function(t){return t.replace(/(.)([A-Z])/g,(function(t,e,i){return e+"-"+i})).toLowerCase()};var o=t.console;return i.htmlInit=function(e,n){i.docReady((function(){var r=i.toDashed(n),s="data-"+r,a=document.querySelectorAll("["+s+"]"),h=document.querySelectorAll(".js-"+r),u=i.makeArray(a).concat(i.makeArray(h)),d=s+"-options",l=t.jQuery;u.forEach((function(t){var i,r=t.getAttribute(s)||t.getAttribute(d);try{i=r&&JSON.parse(r)}catch(e){return void(o&&o.error("Error parsing "+s+" on "+t.className+": "+e))}var a=new e(t,i);l&&l.data(t,n,a)}))}))},i})),function(t,e){"function"==typeof define&&define.amd?define("outlayer/item",["ev-emitter/ev-emitter","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("ev-emitter"),require("get-size")):(t.Outlayer={},t.Outlayer.Item=e(t.EvEmitter,t.getSize))}(window,(function(t,e){"use strict";var i=document.documentElement.style,n="string"==typeof i.transition?"transition":"WebkitTransition",o="string"==typeof i.transform?"transform":"WebkitTransform",r={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[n],s={transform:o,transition:n,transitionDuration:n+"Duration",transitionProperty:n+"Property",transitionDelay:n+"Delay"};function a(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var h=a.prototype=Object.create(t.prototype);h.constructor=a,h._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},h.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},h.getSize=function(){this.size=e(this.element)},h.css=function(t){var e=this.element.style;for(var i in t){e[s[i]||i]=t[i]}},h.getPosition=function(){var t=getComputedStyle(this.element),e=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),n=t[e?"left":"right"],o=t[i?"top":"bottom"],r=parseFloat(n),s=parseFloat(o),a=this.layout.size;-1!=n.indexOf("%")&&(r=r/100*a.width),-1!=o.indexOf("%")&&(s=s/100*a.height),r=isNaN(r)?0:r,s=isNaN(s)?0:s,r-=e?a.paddingLeft:a.paddingRight,s-=i?a.paddingTop:a.paddingBottom,this.position.x=r,this.position.y=s},h.layoutPosition=function(){var t=this.layout.size,e={},i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop"),o=i?"paddingLeft":"paddingRight",r=i?"left":"right",s=i?"right":"left",a=this.position.x+t[o];e[r]=this.getXValue(a),e[s]="";var h=n?"paddingTop":"paddingBottom",u=n?"top":"bottom",d=n?"bottom":"top",l=this.position.y+t[h];e[u]=this.getYValue(l),e[d]="",this.css(e),this.emitEvent("layout",[this])},h.getXValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!e?t/this.layout.size.width*100+"%":t+"px"},h.getYValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&e?t/this.layout.size.height*100+"%":t+"px"},h._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=t==this.position.x&&e==this.position.y;if(this.setPosition(t,e),!o||this.isTransitioning){var r=t-i,s=e-n,a={};a.transform=this.getTranslate(r,s),this.transition({to:a,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})}else this.layoutPosition()},h.getTranslate=function(t,e){return"translate3d("+(t=this.layout._getOption("originLeft")?t:-t)+"px, "+(e=this.layout._getOption("originTop")?e:-e)+"px, 0)"},h.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},h.moveTo=h._transitionTo,h.setPosition=function(t,e){this.position.x=parseFloat(t),this.position.y=parseFloat(e)},h._nonTransition=function(t){for(var e in this.css(t.to),t.isCleaning&&this._removeStyles(t.to),t.onTransitionEnd)t.onTransitionEnd[e].call(this)},h.transition=function(t){if(parseFloat(this.layout.options.transitionDuration)){var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);this.element.offsetHeight;null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0}else this._nonTransition(t)};var u="opacity,"+o.replace(/([A-Z])/g,(function(t){return"-"+t.toLowerCase()}));h.enableTransition=function(){if(!this.isTransitioning){var t=this.layout.options.transitionDuration;t="number"==typeof t?t+"ms":t,this.css({transitionProperty:u,transitionDuration:t,transitionDelay:this.staggerDelay||0}),this.element.addEventListener(r,this,!1)}},h.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},h.onotransitionend=function(t){this.ontransitionend(t)};var d={"-webkit-transform":"transform"};h.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,i=d[t.propertyName]||t.propertyName;if(delete e.ingProperties[i],function(t){for(var e in t)return!1;return!0}(e.ingProperties)&&this.disableTransition(),i in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[i]),i in e.onEnd)e.onEnd[i].call(this),delete e.onEnd[i];this.emitEvent("transitionEnd",[this])}},h.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(r,this,!1),this.isTransitioning=!1},h._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var l={transitionProperty:"",transitionDuration:"",transitionDelay:""};return h.removeTransitionStyles=function(){this.css(l)},h.stagger=function(t){t=isNaN(t)?0:t,this.staggerDelay=t+"ms"},h.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},h.remove=function(){n&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",(function(){this.removeElem()})),this.hide()):this.removeElem()},h.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options,e={};e[this.getHideRevealTransitionEndProperty("visibleStyle")]=this.onRevealTransitionEnd,this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0,onTransitionEnd:e})},h.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},h.getHideRevealTransitionEndProperty=function(t){var e=this.layout.options[t];if(e.opacity)return"opacity";for(var i in e)return i},h.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options,e={};e[this.getHideRevealTransitionEndProperty("hiddenStyle")]=this.onHideTransitionEnd,this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:e})},h.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},h.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},a})), 
    function(t,e){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["ev-emitter/ev-emitter","get-size/get-size","fizzy-ui-utils/utils","./item"],(function(i,n,o,r){return e(t,i,n,o,r)})):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):t.Outlayer=e(t,t.EvEmitter,t.getSize,t.fizzyUIUtils,t.Outlayer.Item)}(window,(function(t,e,i,n,o){"use strict";var r=t.console,s=t.jQuery,a=function(){},h=0,u={};function d(t,e){var i=n.getQueryElement(t);if(i){this.element=i,s&&(this.$element=s(this.element)),this.options=n.extend({},this.constructor.defaults),this.option(e);var o=++h;this.element.outlayerGUID=o,u[o]=this,this._create(),this._getOption("initLayout")&&this.layout()}else r&&r.error("Bad element for "+this.constructor.namespace+": "+(i||t))}d.namespace="outlayer",d.Item=o,d.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var l=d.prototype;function c(t){function e(){t.apply(this,arguments)}return e.prototype=Object.create(t.prototype),e.prototype.constructor=e,e}n.extend(l,e.prototype),l.option=function(t){n.extend(this.options,t)},l._getOption=function(t){var e=this.constructor.compatOptions[t];return e&&void 0!==this.options[e]?this.options[e]:this.options[t]},d.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},l._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),n.extend(this.element.style,this.options.containerStyle),this._getOption("resize")&&this.bindResize()},l.reloadItems=function(){this.items=this._itemize(this.element.children)},l._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,n=[],o=0;o<e.length;o++){var r=new i(e[o],this);n.push(r)}return n},l._filterFindItemElements=function(t){return n.filterFindElements(t,this.options.itemSelector)},l.getItemElements=function(){return this.items.map((function(t){return t.element}))},l.layout=function(){this._resetLayout(),this._manageStamps();var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},l._init=l.layout,l._resetLayout=function(){this.getSize()},l.getSize=function(){this.size=i(this.element)},l._getMeasurement=function(t,e){var n,o=this.options[t];o?("string"==typeof o?n=this.element.querySelector(o):o instanceof HTMLElement&&(n=o),this[t]=n?i(n)[e]:o):this[t]=0},l.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},l._getItemsForLayout=function(t){return t.filter((function(t){return!t.isIgnored}))},l._layoutItems=function(t,e){if(this._emitCompleteOnItems("layout",t),t&&t.length){var i=[];t.forEach((function(t){var n=this._getItemLayoutPosition(t);n.item=t,n.isInstant=e||t.isLayoutInstant,i.push(n)}),this),this._processLayoutQueue(i)}},l._getItemLayoutPosition=function(){return{x:0,y:0}},l._processLayoutQueue=function(t){this.updateStagger(),t.forEach((function(t,e){this._positionItem(t.item,t.x,t.y,t.isInstant,e)}),this)},l.updateStagger=function(){var t=this.options.stagger;if(null!=t)return this.stagger=function(t){if("number"==typeof t)return t;var e=t.match(/(^\d*\.?\d*)(\w*)/),i=e&&e[1],n=e&&e[2];if(!i.length)return 0;return(i=parseFloat(i))*(f[n]||1)}(t),this.stagger;this.stagger=0},l._positionItem=function(t,e,i,n,o){n?t.goTo(e,i):(t.stagger(o*this.stagger),t.moveTo(e,i))},l._postLayout=function(){this.resizeContainer()},l.resizeContainer=function(){if(this._getOption("resizeContainer")){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},l._getContainerSize=a,l._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},l._emitCompleteOnItems=function(t,e){var i=this;function n(){i.dispatchEvent(t+"Complete",null,[e])}var o=e.length;if(e&&o){var r=0;e.forEach((function(e){e.once(t,s)}))}else n();function s(){++r==o&&n()}},l.dispatchEvent=function(t,e,i){var n=e?[e].concat(i):i;if(this.emitEvent(t,n),s)if(this.$element=this.$element||s(this.element),e){var o=s.Event(e);o.type=t,this.$element.trigger(o,i)}else this.$element.trigger(t,i)},l.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},l.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},l.stamp=function(t){(t=this._find(t))&&(this.stamps=this.stamps.concat(t),t.forEach(this.ignore,this))},l.unstamp=function(t){(t=this._find(t))&&t.forEach((function(t){n.removeFrom(this.stamps,t),this.unignore(t)}),this)},l._find=function(t){if(t)return"string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n.makeArray(t)},l._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},l._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},l._manageStamp=a,l._getElementOffset=function(t){var e=t.getBoundingClientRect(),n=this._boundingRect,o=i(t);return{left:e.left-n.left-o.marginLeft,top:e.top-n.top-o.marginTop,right:n.right-e.right-o.marginRight,bottom:n.bottom-e.bottom-o.marginBottom}},l.handleEvent=n.handleEvent,l.bindResize=function(){t.addEventListener("resize",this),this.isResizeBound=!0},l.unbindResize=function(){t.removeEventListener("resize",this),this.isResizeBound=!1},l.onresize=function(){this.resize()},n.debounceMethod(d,"onresize",100),l.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},l.needsResizeLayout=function(){var t=i(this.element);return this.size&&t&&t.innerWidth!==this.size.innerWidth},l.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},l.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},l.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},l.reveal=function(t){if(this._emitCompleteOnItems("reveal",t),t&&t.length){var e=this.updateStagger();t.forEach((function(t,i){t.stagger(i*e),t.reveal()}))}},l.hide=function(t){if(this._emitCompleteOnItems("hide",t),t&&t.length){var e=this.updateStagger();t.forEach((function(t,i){t.stagger(i*e),t.hide()}))}},l.revealItemElements=function(t){var e=this.getItems(t);this.reveal(e)},l.hideItemElements=function(t){var e=this.getItems(t);this.hide(e)},l.getItem=function(t){for(var e=0;e<this.items.length;e++){var i=this.items[e];if(i.element==t)return i}},l.getItems=function(t){t=n.makeArray(t);var e=[];return t.forEach((function(t){var i=this.getItem(t);i&&e.push(i)}),this),e},l.remove=function(t){var e=this.getItems(t);this._emitCompleteOnItems("remove",e),e&&e.length&&e.forEach((function(t){t.remove(),n.removeFrom(this.items,t)}),this)},l.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="",this.items.forEach((function(t){t.destroy()})),this.unbindResize();var e=this.element.outlayerGUID;delete u[e],delete this.element.outlayerGUID,s&&s.removeData(this.element,this.constructor.namespace)},d.data=function(t){var e=(t=n.getQueryElement(t))&&t.outlayerGUID;return e&&u[e]},d.create=function(t,e){var i=c(d);return i.defaults=n.extend({},d.defaults),n.extend(i.defaults,e),i.compatOptions=n.extend({},d.compatOptions),i.namespace=t,i.data=d.data,i.Item=c(o),n.htmlInit(i,t),s&&s.bridget&&s.bridget(t,i),i};var f={ms:1,s:1e3};return d.Item=o,d})),function(t,e){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer"),require("get-size")):t.BricksLayout=e(t.Outlayer,t.getSize)}(window,(function(t,e){var i=t.create("bricksLayout");i.compatOptions.fitWidth="isFitWidth";var n=i.prototype;return n._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0,this.horizontalColIndex=0},n.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}var n=this.columnWidth+=this.gutter,o=this.containerWidth+this.gutter,r=o/n,s=n-o%n;r=Math[s&&s<1?"round":"floor"](r),this.cols=Math.max(r,1)},n.getContainerWidth=function(){var t=this._getOption("fitWidth")?this.element.parentNode:this.element,i=e(t);this.containerWidth=i&&i.innerWidth},n._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,i=Math[e&&e<1?"round":"ceil"](t.size.outerWidth/this.columnWidth);i=Math.min(i,this.cols);for(var n=this[this.options.horizontalOrder?"_getHorizontalColPosition":"_getTopColPosition"](i,t),o={x:this.columnWidth*n.col,y:n.y},r=n.y+t.size.outerHeight,s=i+n.col,a=n.col;a<s;a++)this.colYs[a]=r;return o},n._getTopColPosition=function(t){var e=this._getTopColGroup(t),i=Math.min.apply(Math,e);return{col:e.indexOf(i),y:i}},n._getTopColGroup=function(t){if(t<2)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;n<i;n++)e[n]=this._getColGroupY(n,t);return e},n._getColGroupY=function(t,e){if(e<2)return this.colYs[t];var i=this.colYs.slice(t,t+e);return Math.max.apply(Math,i)},n._getHorizontalColPosition=function(t,e){var i=this.horizontalColIndex%this.cols;i=t>1&&i+t>this.cols?0:i;var n=e.size.outerWidth&&e.size.outerHeight;return this.horizontalColIndex=n?i+t:this.horizontalColIndex,{col:i,y:this._getColGroupY(i,t)}},n._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this._getOption("originLeft")?n.left:n.right,r=o+i.outerWidth,s=Math.floor(o/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a-=r%this.columnWidth?0:1,a=Math.min(this.cols-1,a);for(var h=(this._getOption("originTop")?n.top:n.bottom)+i.outerHeight,u=s;u<=a;u++)this.colYs[u]=Math.max(h,this.colYs[u])},n._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},n._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},n.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},i}));
})(jQuery);