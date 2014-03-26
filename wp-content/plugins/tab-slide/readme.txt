=== TAB SLIDE ===
Contributors: zoranc
Donate link: https://blockchain.info/address/1HX5e9WPgi3RhsziV6Ja1a5b5AuUXYmSE4
Tags: tab, sliding, popup, pop out, page, form, ad, slide out, widget, login, post, hide away, widget area
Author URI: http://zoranc.co/
Plugin URI: http://wordpress.org/extend/plugins/tab-slide/
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 2.0.0
License: GPLv2

== Description ==

This WP plugin is ideal for wordpress users who would like to present additional content without cluttering up or leaving the page. TAB SLIDE can contain a widget area, forms, rss feeds, logins, sign-ups, videos, pictures, posts, menu options, comments, popup ads and etc.  The TAB SLIDE settings page appears in the Dashboard where you can set all your tab slide options such as page source, size, positioning, autohide, opacity and much more. Over 25,100+ sites have checked out TAB SLIDE.

== Installation ==

The easiest way to install this plugin is to go to Dashboard->Plugins->Add New and search for Tab Slide. On the far left side of the search results, click Install.

If the automatic process above fails, follow these simple steps to do a manual install:

1. Extract the contents of the zip file into your `wp-content/plugins` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Tab Slide settings page for further fine-tuning!

== Frequently Asked Questions ==
= Where are the Tab Slide Settings? =

Dashboard->Settings->Tab Slide

= How do I get multiple Tabs? =

The multiple tabs feature is available in Tab Slide Pro. You can visit [Tab Slide Pro](http://store.zoranc.co/downloads/tab-slide-pro/) for more info.

= How do I edit the templates? =

Ideally you should not edit the templates directly as they will be overwritten on plugin updates. Instead, you can

A. Copy/paste the template you wish to edit to your child theme folder. Set the template inside the Tab Slide Settings
to "Custom" and set the "window url" to point to the duplicate inside the child theme folder and edit away.

*OR*

B. Hook into one of many Tab Slide Specific filters and actions to modify the tab slide content as well as behavior. In particular, check out these template related actions:

1. `tab_slide_iframe_template`
2. `tab_slide_picture_template`
3. `tab_slide_post_template`
4. `tab_slide_subscribe_template`
5. `tab_slide_video_template`
6. `tab_slide_widget_template`
7. `tab_slide_wplogin_template`

= How do I edit the css? =

Switch over to "CSS Only" mode on the Tab Slide Settings Page.

= I completely messed up the CSS in "CSS Only" Mode. How do I reset everything without reinstalling? =

Delete all the CSS inside the "CSS Only" textarea and click Save. When the page refreshes the css will be generated from ALL the settings that are selected when not in "CSS Only" mode.

= How do I use a custom, on page button to trigger the tabslide? =

1. Add a `make_it_slide` class to any element that you want to trigger the slide action. Or you can simply use this link anywhere on your page:

`<a href="javascript:void(0)" class="make_it_slide">My custom TABSLIDE trigger</a>`

and to disable the regular tabslide tab:
2. Go to tab slide advanced settings screen and use the Tab Image
3. On the general settings screen switch over to CSS only mode and add

`display:none!important;` to `.open_action`

to make it look like:

`.open_action {
        display:none!important;`
        
NOTE: Steps 2-3 will be omitted in the near future and you will simply be able to choose "Custom Trigger" instead of "Tab Image" or "Tab Text" on the advanced settings screen!

= Tab Slide doesn't work in IE? =

For the time being it does support IE9+.

= What are the Tab Slide specific available filters and actions? =
* Filters:
1. `tab_slide_show_instance`
2. `tab_slide_url`
3. `tab_slide_include_container_html`
      
* Actions:
1. `tab_slide_check_instance`
2. `tab_slide_load_html_container_template`
3. `tab_slide_shortcode`
4. `tab_slide_front_end_scripts`
5. `tab_slide_loaded`
6. `save_tab_slide_settings`
    
* Template dependent actions
    
1. `tab_slide_iframe_template`
2. `tab_slide_picture_template`
3. `tab_slide_post_template`
4. `tab_slide_subscribe_template`
5. `tab_slide_video_template`
6. `tab_slide_widget_template`
7. `tab_slide_wplogin_template`

= Tab Slide doesn't do X, Y, and Z. That makes me sad. =
For support questions, feedback and ideas, please use the [Tab Slide forum](http://wordpress.org/tags/tab-slide).

== Changelog ==
= 2.0.0 =
**IMPORTANT NOTE:** *BACKUP* all your customized templates, custom css and buttons before upgrading!

* MAJOR Revision
* Completely revised the way the plugin core works
* Major improvments to performance
* CSS is saved to the database now, so no need to worry anymore about tab slide plugin updates overwriting your changes from this version on.
* bugfix: compatibility with WordPress SEO
* IE 9+ support
* New filters:
1. `tab_slide_show_instance`
2. `tab_slide_url`
3. `tab_slide_include_container_html`
      
* New actions:
1. `tab_slide_check_instance`
2. `tab_slide_load_html_container_template`
3. `tab_slide_shortcode`
4. `tab_slide_front_end_scripts`
5. `tab_slide_loaded`
6. `save_tab_slide_settings`
    
* **Template dependent actions**
    
1. `tab_slide_iframe_template`
2. `tab_slide_picture_template`
3. `tab_slide_post_template`
4. `tab_slide_subscribe_template`
5. `tab_slide_video_template`
6. `tab_slide_widget_template`
7. `tab_slide_wplogin_template`
  


= 1.52 =
= 1.51 =
= 1.50 =
= 1.4 =
* Shortcode implementation
* CSS Only Mode
* Credentials (Show only to logged in/out or all users)
* Color picker
* Border settings 
* MAJOR js code cleanup
* and more
IMPORTANT NOTE: BACKUP all your customized templates and buttons before upgrading!
= 1.32 =
* Append content via php(include) vs jQuery(load)
* Disable on template pages (ie lightbox iframe.php)
* Major template clean-up
* Minor code clean-up

= 1.31 =
* IE fixed
* Template fixes
* Fullscreen issues resolved

= 1.3 =
* Position to the left or right 
* Improved the default design 
* Rename the OPEN and CLOSE titles 
* Show on all pages, exclude or include 
* Full screen or regular mode 
* Segregated the settings page into General, Advanced and About(FAQ) sections 
* Resolved the custom permalinks bug
* Subscribe to Blog template added
* Post template fix

= 1.2 =
* Improved template managment 
* Added ready to use templates for a widget area, video, picture 
* Animation speed control 
* Disable Countdown Timer 
* Exclude Posts

= 1.1 =
* Template Fix

== Upgrade Notice ==
=2.0.0=
IMPORTANT NOTE: BACKUP all your customized templates, custom css and buttons before upgrading!

== Screenshots ==
1. Front End View of tab slide in "Tab Image Mode" 
2. Admin General and Advanced settings views
