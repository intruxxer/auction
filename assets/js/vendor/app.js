var nav_id = 0;
var default_path;
var preloader;

var map_coordinate = new google.maps.LatLng(-6.2500221, 106.808722);
var map_style = [{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}];

var slick_option = {
	dots: false,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-long-arrow-left"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="fa fa-long-arrow-right"></i></button>',
	infinite: false };

var add_default_path = function(url) {
	default_path = url;
}
		
$(function()
{
		// variables
		var default_pathname;
		var navigation_is_open = false;
		var image_manifest;
		
		var _window_third = function() {
			return $(window).width() / 3;
		}
		
		var _window_half = function() {
			return $(window).width() / 2;
		}
		
		// functions
		var _initialize_gmap = function(_element) {
		    var options = {
		        center: map_coordinate,
		        zoom: 15,
		        scrollwheel: false,
				navigationControl: false,
				mapTypeControl: false,
				scaleControl: false,
				draggable: false,
		        mapTypeId: google.maps.MapTypeId.ROADMAP,
		        styles: map_style };
		
		    var map = new google.maps.Map(document.getElementById(_element),  options);
		}
		
		
		var _set_main_navigation = function(_pathname) {
			$('#main-navigation').find('li').removeClass('active');
			
			$('#main-navigation').find('li').each(function()
			{
					if ($(this).find('a').attr('data-page') == _pathname) {
						$(this).addClass('active');
					}
				});
		}
		
		
		var _set_image_manifest = function(_data) {
			var media_query = Foundation.MediaQuery.current;
			var manifest = new Array;
			
			$(_data).find('*').each(function() {
					if ($(this).attr('data-interchange')) {
						//console.log($(this).attr('data-interchange'));
						var text = $(this).attr('data-interchange');
						var new_txt = text.substring(1, text.length);
						var txt = new_txt.substring(0, new_txt.length - 1);
						
						var arr = new Array;
						arr = txt.split("], [");
						
						for(var i = 0; i < arr.length; i++) {
							var a = new Array;
							a = arr[i].split(", ");
							
							if (a[1] == media_query) {
								manifest.push(a[0]);
							}
						}
					}
					
					if ($(this).attr('src')) {
						manifest.push($(this).attr('src'));
					}
				});
				
			return manifest;
		}
		
		
		var _load_content = function(_load_type, _url, _direction) {
			console.log(_direction);
			
			$.ajax({
					url: _url,
					dataType: "html"
					
				}).done(function(d)
				{
						var data = $(d).filter('#content');
						
						if(_load_type == "start") {
							//_prep_start_website(_load_type, data, _direction);
							_prep_start(data);
								
						} else if(_load_type == "page") {
							_prep_animate_to_page(_load_type, data, _direction)
							
						} else if (_load_type == "work") {
							_prep_append_work(_load_type, data);
						}
					});
		}
		
		
		var _load_image = function(_options) {
			if (image_manifest.length > 0) {
				var item = image_manifest.shift();
				console.log(item);
			
				preloader.loadFile(item);
				//console.log(_options.load_type);
				
			} else {
				preloader.close();
				console.log(_options.load_type + "/" + _options.direction);
					
				if (_options.load_type == "start") {
					_append_start(_options.content, 'transition-duration-750');
					
				} else if (_options.load_type == "page") {
					//setTimeout(_animate_to_page, 50, 'transition-duration-750', _options.direction);
					_append_page(_options.content, 'transition-duration-750', _options.direction);
					
				} else if (_options.load_type == "work") {
					_append_work(_options.content)
				}
			}
		}
		
		var _load_image_complete = function(event, data) {
			_load_image(data);
		}
		
		
		var _prep_start = function(_data) {
			image_manifest = new Array;
    		image_manifest = _set_image_manifest(_data);
    		//console.log(image_manifest);
    		
    		var options = { load_type: "start", content: _data };
    		
    		if (image_manifest.length > 0) {
	    		preloader = new createjs.LoadQueue(true);
		    	preloader.on('complete', _load_image_complete, null, false, options);
		    	
	    		_load_image(options);
	    		
    		} else {
	    		_append_start(_data, 'transition-duration-750');
    		}
		}
		
		var _append_start = function(_content, _animate_class) {
			$('#current-layer').append($(_content).html());
			
			$('#current-layer').find('[data-interchange]').each(function() {
	    			new Foundation.Interchange($(this));
    			});
    			
    		setTimeout(_start, 50, _animate_class);
		}
		
		var _start = function(_animate_class) {
			$('#current-layer').css('opacity', 1).css('transform', "translateY(0)").addClass(_animate_class);
			
			$('#toggle-main-navigation').css('transform', "translateX(0)").addClass(_animate_class);
			
			$('#current-layer').one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
					$(this).unbind("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend");
					
					$('body').removeClass('start-website');
					
					$(this).removeClass().removeAttr('style');
					
					$('#logo').find('p').addClass('finish');
					
					$('#logo').find('p').one("webkitAnimationEnd oanimationend MSAnimationEnd animationend", function() {
						$(this).removeClass('animate finish').unbind("webkitAnimationEnd oanimationend MSAnimationEnd animationend");
					});
				});
		}
		
		
		var _prep_animate_to_page = function(_load_type, _data, _direction) {
			image_manifest = new Array;
			image_manifest = _set_image_manifest(_data);
			console.log(image_manifest);
			
			var options = { load_type: _load_type, content: _data, direction: _direction };
			
			if (image_manifest.length > 0) {
				preloader = new createjs.LoadQueue(true);
				preloader.on('complete', _load_image_complete, null, false, options);
			
				_load_image(options);
				
			} else {
				_append_page(_data, 'transition-duration-750', _direction);
			}
					
			/*var current_item = $('#current-layer').html();
			//console.log(_direction);
			
			$('#back-layer').css('transform', "translate(0, 0)").css('top', offset).append(current_item);
			
			if (_direction == "forward") {
				$('#front-layer').css('transform', "translate(" + window_width + "px, 0)").append($(_content).html());
				
			} else if (_direction == "back") {
				$('#front-layer').css('transform', "translate(" + -window_width + "px, 0)").append($(_content).html());
			}
			
			$('#front-layer').find('[data-interchange]').each(function()
    		{
	    			new Foundation.Interchange($(this));
    			});
    			
			setTimeout(function() {
					$('#back-layer').css('z-index', 6);
					$('#front-layer').css('z-index', 7);
					
					$('#current-layer').empty();
					
					image_manifest = new Array;
					image_manifest = _set_image_manifest($('#front-layer'));
					//console.log(image_manifest);
					
					var options = { load_type: _load_type, offset:offset.top, direction: _direction };
					
					if (image_manifest.length > 0) {
						preloader = new createjs.LoadQueue(true);
						preloader.on('complete', _load_image_complete, null, false, options);
					
						_load_image(options);
						
					} else {
						setTimeout(_animate_to_page, 50, 'transition-duration-750', _direction);
					}
					
				}, 100);*/
		}
		
		var _append_page = function(_content, _animate_class, _direction) {
			var offset = $('#current-layer').offset().top - document.body.scrollTop;
			var window_width = $(window).width();
			
			var current_item = $('#current-layer').html();
			
			$('#back-layer').css('transform', "translate(0, 0)").css('top', offset).append(current_item);
			
			if (_direction == "forward") {
				$('#front-layer').css('transform', "translate(" + window_width + "px, 0)").append($(_content).html());
				
			} else if (_direction == "back") {
				$('#front-layer').css('transform', "translate(" + -window_width + "px, 0)").append($(_content).html());
			}
			
			$('#front-layer').find('[data-interchange]').each(function()
    		{
	    			new Foundation.Interchange($(this));
    			});
    		
    		setTimeout(_animate_to_page, 50, _animate_class, _direction);
		}
		
		var _animate_to_page = function(_animate_class, _direction) {
			var window_width = $(window).width();
			
			$('#back-layer').css('z-index', 6);
			$('#front-layer').css('z-index', 7);
			
			$('#current-layer').empty();
			
			if (_direction == "forward") {
				$('#back-layer').css('transform', "translate(" + -window_width  + "px, 0)").addClass(_animate_class);
				
			} else if (_direction == "back") {
				$('#back-layer').css('transform', "translate(" + window_width  + "px, 0)").addClass(_animate_class);
			}
			
			$('#front-layer').css('transform', "translate(0, 0)").addClass(_animate_class);
			
			$('#front-layer').one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
					var current = $('#front-layer').html();
					
					$('#front-layer').unbind("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend");
					
					$('#current-layer').append(current);
					
					setTimeout(function() {
							$('#back-layer').empty().removeClass(_animate_class).css('transform', "translate(0, 0)").css('top', 0).css('z-index', 2);
							
							$('#middle-layer').empty().removeClass(_animate_class).css('transform', "translate(0, 0)").css('z-index', 3).css('left', window_width / 3);
							$('#front-layer').empty().removeClass(_animate_class).css('transform', "translate(0, 0)").css('z-index', 4);
							
						}, 10);
					
					$('#logo').find('p').addClass('finish');
					
					$('#logo').find('p').one("webkitAnimationEnd oanimationend MSAnimationEnd animationend", function() {
							$(this).removeClass('animate finish').unbind("webkitAnimationEnd oanimationend MSAnimationEnd animationend");
						});
				});
		}
		
		
		var _prep_animate_to_work = function(_load_type, _url, _item, _item_pos, _animate_class) {
			var offset = $('#current-layer').offset().top - document.body.scrollTop;
			offset = offset + _item_pos;
			
			$('#back-layer').append(_item).css('top', offset).css('z-index', 6);
			
			var section = $('#back-layer').find('section');
			
			setTimeout(_animate_to_work, 50, _load_type, _url, section, offset, _animate_class);
		}
		
		var _animate_to_work = function(_load_type, _url, _section, _offset, _animate_class) {
			$(_section).css('height', "100vh").css('transform', "translateY(" + -_offset + "px)").addClass(_animate_class);
			
			$(_section).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
					$(_section).unbind();
					
					$('#current-layer').empty();
					
					_load_content(_load_type, _url, "forward");
				});
		}
		
		var _prep_append_work = function(_load_type, _data) {
			image_manifest = new Array;
			image_manifest = _set_image_manifest(_data);
			console.log(image_manifest);
				
			if (image_manifest.length > 0) {
				var options = { load_type: _load_type, content: _data };
				
				preloader = new createjs.LoadQueue(true);
				preloader.on('complete', _load_image_complete, null, false, options);
			
				_load_image(options);	
			}
		}
		
		var _append_work = function(_content) {
			document.body.scrollTop = document.documentElement.scrollTop = 0;
			
			$('#current-layer').html($(_content).html());
			
			$('#current-layer').find('[data-interchange]').each(function()
    		{
	    			var rule = $(this).attr('data-interchange');
	    			new Foundation.Interchange($(this));
    			});
    			
    		if ($('.carousel').length > 0) {
				$('.carousel').slick(slick_option);
			}
    			
    		$('#logo').find('p').addClass('finish');
					
			$('#logo').find('p').one("webkitAnimationEnd oanimationend MSAnimationEnd animationend", function() {
					$(this).removeClass('animate finish').unbind("webkitAnimationEnd oanimationend MSAnimationEnd animationend");
				});
    		
    		setTimeout(function() {
	    			$('#back-layer').empty().css('top', 0).css('z-index', 2);
			
					$('#current-layer').find('#scroll-down').addClass('on');
					
	    		}, 10);
		}
		
		
		//events
		$(document).on('ready', function() {
				$(document).foundation();
				
				var window_height = $(window).height();
				var window_width = $(window).width();
				
				var parse_href = document.createElement('a');
				parse_href.href = window.location.href;
				
				var pathname = parse_href.href.substring(default_path.length, parse_href.href.length);
				
				if (pathname == "") { pathname = "home"; }
				
				var pathname_array = pathname.split("/");
				//console.log(pathname_array);
				
				var url = default_path + "ajax/" + pathname;
				
				_set_main_navigation(pathname_array[0]);
				
				history.scrollRestoration = "manual";
				history.replaceState({ path:parse_href.href, uid:nav_id }, null, parse_href.href);
				
				$('#logo').find('p').addClass('animate');
				
				_load_content("start", url, "forward");
			});
			
			
		$(document).on('click', '.load-page', function(e) {
				e.preventDefault();
				
				var page = $(this).attr('data-page');
				var load_type = $(this).attr('data-load-type');
				var parse_href = document.createElement('a');
				parse_href.href = $(this).attr('href');
				//console.log("go to page");
				var url = default_path + "ajax/" + page;
				
				_set_main_navigation(page);
				
				if ($('#toggle-main-navigation').hasClass('is-open')) { navigation_is_open = true; }
				
				nav_id++;
				
				history.pushState({ path:parse_href.href, uid:nav_id }, null, parse_href.href);
				
				//$('#logo').find('p').addClass('animate');
				
				if (navigation_is_open) {
					$('#container').css('margin-left', 0);
					
					$('#container').one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
							if (load_type == "page") {
								$('#container').unbind("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend");
								
								$('#logo').find('p').addClass('animate');
								
								$('#toggle-main-navigation').removeClass('is-open');
								
								$('#back-button-layer').css('height', 0);
								
								navigation_is_open = false;
								
								if (load_type == "page") {
									_load_content(load_type, url, "forward");
								}
							}
						});
						
				} else {
					$('#logo').find('p').addClass('animate');
					
					if (load_type == "page") {
						_load_content(load_type, url, "forward");
						
					} else if (load_type == "work") {
						var current_item = $(this).parent().clone();
						var current_item_pos = $(this).parent().position().top;
						
						_prep_animate_to_work(load_type, url, current_item, current_item_pos, 'transition-duration-750');
					}
				}
			});
		
		
		$(document).on('click', '#toggle-main-navigation', function(e) {
				var third = _window_third();
				//console.log(navigation_is_open);
				
				if ($(this).hasClass('is-open')) {
					$('#back-button-layer').css('height', 0);
					
					$('#container').css('margin-left', 0);
					
					$(this).removeClass('is-open');
					
					navigation_is_open = false;
					
				} else {
					$('#back-button-layer').css('height', "100%");
					
					$('#container').css('margin-left', third);
					
					$(this).addClass('is-open');
					
					navigation_is_open = true;
				}
			});
			
			
		$(document).on('click', '[rel="back-button"]', function(e) {
				if ($('#toggle-main-navigation').hasClass('is-open')) {
					$(this).css('height', 0);
					
					$('#container').css('margin-left', 0);
					
					$('#toggle-main-navigation').removeClass('is-open');
					
					navigation_is_open = false;
				}
			});
			
		
		window.addEventListener('popstate', function(e) {
				var direction;
				
				parse_href = document.createElement('a');
				parse_href.href = e.state.path;
				
				pathname = parse_href.href.substring(default_path.length, parse_href.href.length);
				
				if (pathname == "") { pathname = "home"; }
				
				var pathname_array = pathname.split("/");
				//console.log(pathname_array[0]);
				
				var url = default_path + "ajax/" + pathname;
				
				_set_main_navigation(pathname_array[0]);
				
				if (nav_id > e.state.uid) {
					direction = "back";
					
				} else {
					direction = "forward";
				}
				
				console.log(direction);
				
				nav_id = e.state.uid;
				
				history.replaceState({ path:parse_href.href, uid:nav_id }, null, parse_href.href);
				
				if (navigation_is_open) {
					$('#container').css('margin-left', 0);
					
					$('#container').one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
							$('#container').unbind("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend");
							
							$('#logo').find('p').addClass('animate');
							
							$('#back-button-layer').css('height', 0);
							
							$('#toggle-main-navigation').removeClass('is-open');
							
							navigation_is_open = false;
							
							_load_content("page", url, direction);
						});
						
				} else {
					$('#logo').find('p').addClass('animate');
					
					_load_content("page", url, direction);
				}
				//_load("page", navigation_is_open, url, direction);
			});
	});