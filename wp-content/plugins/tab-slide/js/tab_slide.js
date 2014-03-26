"use strict";
var  slide_params;
if (!Object.create) {
  Object.create = (function(){
	var fun;
	function F(){}
	return function(o){
	  if (arguments.length !== 1) {
		throw new Error('This Object.create implementation only accepts one parameter.');
	  }
	  F.prototype = o;
	  fun = new F();
	  return fun;
	};
  }());
}
var tabSlideTemplate = {
	/*
	 * Initialize the instance
	 */
	init : function () {
		var tabSlide, settings, toggleParams, calc_width;
		tabSlide = this;
		this.settings = {};
		this.settings = this.instance_options;
		settings = this.settings;
		this.setOptions();
		slide_params = {};
		toggleParams = {};
		toggleParams['margin-' + settings.tab_position] = '0px';
		this.drawShelf();
		this.initResize();
		if (settings.show_on_load == true && settings.showing == true) {
			jQuery(settings.toggleEl).css(toggleParams);
			if (settings.enable_timer == true) {
				setTimeout(function () { // Autoclose
					if (settings.fullscreen) {
						jQuery(settings.toggleEl).css(settings.tab_position, -(parseInt(settings.tab_width, 10) + parseInt(settings.border_size, 10)) + 'px');
					}
					tabSlide.makeItSlide();
					settings.showing = false;
				}, settings.timer * 1000);
			} else if (settings.tab_type == 1) {
				tabSlide.regenerateTab("closed");
			}
		} else if (settings.tab_type == 1) { //Image based tab in closed position
			tabSlide.regenerateTab("opened");
		} else { //text based tab in closed position
		  calc_width = -(parseInt(settings.width, 10) + parseInt(settings.border_size, 10));
			jQuery(settings.shelfEl).css( settings.tab_slide_position , calc_width + 'px' );
			tabSlide.regenerateTab("opened");
		}
	},
	/*
	 * Set the instance options
	 */
	setOptions : function () {
		var settings;
		settings = this.settings;
		settings.shelfId = 'tab_slide';
		settings.shelfEl = '#' + settings.shelfId;
		settings.shelfClass = 'tab_slide  tab_slide_wrapper';
		settings.showing = settings.show_on_load;
		settings.toggleId = 'tab_toggle';
		settings.toggleEl = '#' + settings.toggleId;
		settings.toggleBgId = 'tab_toggle_bg';
		settings.customEl = '.make_it_slide';
		settings.animation_ease = 'swing';
		settings.animation_speed = settings.animation_speed * 1000;
		settings.fullscreen = settings.open_width == "100" && settings.window_unit == '%' ? true : false;
		settings.border_size = isNaN(settings.border_size) ? parseInt(0, 10) : settings.border_size;
		settings.border_size = settings.borders != 1 ? parseInt(0, 10) : settings.border_size;
		settings.width = settings.window_unit == '%' ? settings.open_width / 100 * jQuery(window).width() : settings.open_width;
		settings.tab_position = settings.tab_slide_position == 'right' ? 'left' : 'right'; // Tab_position is the opening direction
	},
	/*
	 * Draw the shelf elements
	 */
	drawShelf : function () {
		var shelf, settings, contentEl, includeEl, classReset,titleWrapDiv, open_v, close_v, $j, height;
		settings = this.settings;
		contentEl = "#tab_slide_content";
		includeEl = "#tab_slide_include";
		classReset = settings.shelfClass;
		if (settings.show_on_load) {
			classReset =  classReset + ' reset_' + settings.tab_slide_position;
		} 
		if (settings.tab_type ==  1) { // Tab is custom image
			shelf = "<div id='" + settings.shelfId + "' class='" + classReset +  "'>"
				+ "<div id='" + settings.toggleId + "'><div id='tab_toggle_bg' style='top:0px'></div></div></div>";
		} else {
			shelf = '<div id="' + settings.shelfId + '" class="' + classReset + '">' +
				"<div id='" + settings.toggleId + "'></div></div>";
		}
		jQuery('body').prepend(shelf);
		height = settings.open_height =="auto" ?  settings.open_height : settings.open_height + settings.window_unit;
		jQuery(settings.shelfEl).css({
			'height': height,
			'top': settings.open_top + '%',
			'width': settings.open_width + settings.window_unit
		}).append("<div id='tab_slide_content'></div>");

		jQuery(includeEl).css('display', 'block');
		jQuery(includeEl).appendTo(contentEl);

		jQuery(contentEl).append("<div id='tab_slide_background' class='tab_slide_corners_" + settings.tab_position + "'></div>");
		if (settings.tab_type != 1) {// Tab is text based
			jQuery(settings.toggleEl).addClass('tab_text_bg');
			// Generate the tab slide title
			if (jQuery.browser.msie) { //IE workaround - Generate spans around each letter
				open_v = '';
				for ($j = 0; $j < settings.tab_title_open.length; $j++) {
					if ((settings.tab_title_open[$j])) {
						open_v += "<span class='newline'>" + settings.tab_title_open[$j] + "</span>";
					}
				}
				close_v = '';
				for ($j = 0; $j < settings.tab_title_close.length; $j++) {
					if ((settings.tab_title_close[$j])) {
						close_v += "<span class='newline'>" + settings.tab_title_close[$j] + "</span>";
					}
				}
				if (settings.show_on_load) {
					titleWrapDiv = "<div id='tab_title_wrap' class='tab_title open_letter_reset'>" + close_v + "</div>";
				} else {
					titleWrapDiv =  "<div id='tab_title_wrap' class='tab_title close_letter_reset'>" + open_v + "</div>";
				}
			} else {
				// Generate the tab slide title in other browsers
				if (settings.show_on_load) {
					titleWrapDiv =  "<div id='tab_title_wrap' class='close_letter_reset'><span class='tab_title'>" + settings.tab_title_close + "</span></div>";
				} else {
					titleWrapDiv =  "<div id='tab_title_wrap' class='open_letter_reset'><span class='tab_title'>" + settings.tab_title_open + "</span></div>";
				}
			}
			jQuery(settings.toggleEl).append(titleWrapDiv);
			jQuery(settings.toggleEl).addClass('tab_text_' + settings.tab_position);
		}
	},//end drawShelf()
	/*
	 * Initial window resize
	 */
	initResize : function () {
		var tabSlide = this;
		// Resize now and bind for future
		tabSlide.resize();
		jQuery(window).resize(function () {
			tabSlide.resize();
		});
	},
	/*
	 * Future window resize
	 */
	resize : function () {
		var settings, $tS, calc_width;
		settings = this.settings;
		// Runs at start and each time the window is rezied
		$tS = jQuery(settings.shelfEl);
		if (!settings.showing) {
		  calc_width = -(parseInt(settings.width, 10) + parseInt(settings.border_size, 10));
			$tS.css(settings.tab_slide_position, calc_width + 'px');
		} else {
			$tS.css(settings.tab_slide_position, 0);
		}
	},
	/*
	 * Open/close event handler
	 */
	makeItSlide : function () {
		var tabSlide, settings, toggleBgEl, $tS, slide_params, toggleParams, calc_width;
		tabSlide = this;
		settings = this.settings;
		toggleBgEl = '#' + settings.toggleBgId;
		$tS = jQuery(settings.shelfEl);
		slide_params = [];
		toggleParams = [];
		if (settings.showing == true) {
			if (settings.fullscreen) {
				jQuery(settings.toggleEl).css(settings.tab_position, -(parseInt(settings.tab_width, 10) + parseInt(settings.border_size, 10)) + 'px');
			}
			calc_width = -(parseInt(settings.width, 10) + parseInt(settings.border_size, 10));
			slide_params[settings.tab_slide_position] = calc_width + 'px';
			$tS.animate(slide_params, settings.animation_speed, settings.animation_ease, this.regenerateTab.apply(tabSlide, ["opened"]));
			settings.showing = false;
		} else {
			if (settings.fullscreen) {
				jQuery(settings.toggleEl).css(settings.tab_position, '0px');
			}
			jQuery(toggleBgEl).fadeOut(100, function () {
				slide_params[settings.tab_slide_position] = '0px';
				$tS.animate(slide_params, settings.animation_speed, settings.animation_ease);
				//toggleParams['opacity'] = settings.opacity / 100;
				jQuery(settings.toggleEl).css(toggleParams);
				tabSlide.regenerateTab.apply(tabSlide, ["closed"]);
			});
			if (jQuery('#tab_title_wrap').length) {
				slide_params[settings.tab_slide_position] = '0px';
				$tS.animate(slide_params, settings.animationSpeed, settings.animationEase);
				tabSlide.regenerateTab.apply(tabSlide, ["closed"]);
			}
			settings.showing = true;
		}
	}, // END: makeItSlide
	/*
	 * Register the open/close events for this instance
	 */
	registerEvents : function () {
		var tabSlide, settings;
		settings = this.settings;
		tabSlide = this;
		jQuery(settings.toggleEl).click(function () {
			var move = tabSlide.makeItSlide;
			move.apply(tabSlide, null);
		});
		if (jQuery(settings.customEl).length != 0) {
			jQuery(settings.customEl).click(function(){
			var move = tabSlide.makeItSlide;
			move.apply(tabSlide, null);
		});
		} 
	},
	/*
	 * Redraw the open/close tabs after opening/closing and set the current state of the slide
	 * NOTE: three types of tabs image, text and IE workaround for text based tab
	 */
	regenerateTab: function (currentState) {
		var settings, classToggle, tab_title, toggleParams, tab_title_ie, select, j, margin_reset;
		settings = this.settings;
		toggleParams = [];
		function spanify(title) { // Generate spans around each letter
			tab_title_ie = '';
			for (j = 0; j < title.length; j++) {
				if ((title[j])) {
					tab_title_ie += "<span class='newline'>" + title[j] + "</span>";
				}
			}
			return tab_title_ie;
		}
		switch (currentState) {
		case "opened": // Tab is opened, Closing Parameters
			classToggle = "<div id='tab_toggle_bg' class='open_action reset_" + settings.tab_slide_position + "'>";
			tab_title = settings.tab_title_open;
			tab_title_ie = spanify(settings.tab_title_open);  // Spans make letters vertical for the almighty IE - older versions
			margin_reset = 'open_letter_reset';
			break;
		case "autohide": // Tab is opened, Closing Parameters; initial DOM structure reset
			classToggle = "<div id='tab_toggle_bg' class='open_action reset_" + settings.tab_slide_position + "'></div>";
			tab_title = settings.tab_title_open;
			tab_title_ie = spanify(settings.tab_title_open);
			margin_reset = 'open_letter_reset';
			break;
		case "closed": // Tab is closed; Opening Parameters
			classToggle = "<div id='tab_toggle_bg' class='closed_action reset_" + settings.tab_position + " float_" + settings.tab_position + "' ></div>";
			tab_title = settings.tab_title_close;
			tab_title_ie = spanify(settings.tab_title_close);
			margin_reset = 'close_letter_reset' ;
			break;
		}
		// Toggle state via class replacement
		if (settings.tab_type ==  1) { // Tab is custom image
			jQuery('.open_action' ).addClass(".reset_" + settings.tab_position);
			jQuery('#tab_toggle_bg' ).replaceWith(classToggle);
			jQuery('#tab_toggle_bg' ).css(settings.tab_slide_position, 0).hide().fadeIn();
			//if (settings.tab_position == 'right') { jQuery('.closed_action' ).css('float', settings.tab_position); }
			jQuery('.closed_action' ).css('float', settings.tab_position);
		} else if (jQuery.browser.msie) { // IE Tab title with spans
			jQuery('#tab_title_wrap' ).replaceWith("<div id='tab_title_wrap'><span class='tab_title'></span></div>");
			jQuery('#tab_title_wrap'  + ' span').replaceWith("<span class='tab_title'>" + tab_title_ie + '</span>');
			jQuery('#tab_title_wrap' ).toggleClass().toggleClass(margin_reset);
			//(jQuery('#tab_toggle').outerHeight(true) - jQuery('#tab_title_wrap').outerHeight(true)) / 2 + 'px');
		} else {// CSS rotated letters
			jQuery('#tab_title_wrap'  + ' span').replaceWith("<span class='tab_title'>" + tab_title + '</span>');
			jQuery('#tab_title_wrap' ).toggleClass().toggleClass(margin_reset);
			if (currentState != "closed") { jQuery('#tab_title_wrap' ).css("'margin-" + settings.tab_position + "'", (jQuery('#tab_toggle' ).outerHeight(true) - jQuery('.tab_title' ).outerHeight(true)) / 2 + 'px'); }
		}

		if (currentState != "closed") {
			//toggleParams['opacity'] = 1;
			jQuery(settings.toggleEl).css(toggleParams);
		}
		// Damn that text cursor
		if (!jQuery.browser.msie) {
			select = window.getSelection();
			select.removeAllRanges();
		}
	}
};
function getTabSlide(proto, props) {
  var o, p;
  o = Object.create(proto);
  for (p in props){
	if (props.hasOwnProperty(p)) {
	  o[p] = props[p];
	}
  }
  return o;
}
jQuery(document).ready(function() {
	var json_str, allOptions, tabSlide;
	json_str = j_options.j_options.replace(/&quot;/g, '"');
	allOptions = jQuery.parseJSON(json_str);
	tabSlide = getTabSlide(tabSlideTemplate, {'instance_options':allOptions});
  	tabSlide.init();
	tabSlide.registerEvents();
});
