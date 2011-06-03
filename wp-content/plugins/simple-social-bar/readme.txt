=== Simple Social Bar ===
Contributors: kynatro, dtelepathy
Donate link: http://www.dtelepathy.com/
Tags: dtelepathy, sharebar, social widget, sidebar, facebook, twitter, sharethis, simple, social bar
Requires at least: 3.0
Tested up to: 3.1.2
Stable tag: trunk

A simple, easy to use, easy to configure social share bar that follows you down the page for sharing your posts.

== Description ==

A simple, easy to use, easy to configure social bar that will allow a user to add social share links to their WordPress website. This plugin came from the idea implemented with the popular Share Bar plugin (http://wordpress.org/extend/plugins/sharebar/), but offers many improvements:

* Completely new, easier to understand code base making it easier for possible community contribution and personal customization
* No additional database tables, but instead utilizes a private custom post type for social link buttons
* Better control over where the bar appears allowing for per-post type filtering
* Less obtrusive implementation for better caching and minification plugin compatibility as well as control over when the plugin is loaded
* Simpler administrative interface with drag and drop ordering capabilities

Works in IE7+, Firefox 2+, Chrome 2+, Safari 3+ and Opera 9+; vertical following does not work in IE6. Utilizes jQuery for JavaScript processing, although it is setup to work properly with other libraries, your experience may vary. Requires PHP 5.2+.

This plugin is free to use and is not actively supported by the author, but will be monitored for serious bugs that may need correcting.

== Installation ==

The plugin is simple to install:

1. Download `simplesocialbar.zip`
1. Unzip
1. Upload `simplesocialbar` directory to your `/wp-content/plugins` directory
1. Go to the plugin management page and enable the plugin

== Screenshots ==

1. Easy to use administration panel. Just paste in the code for your buttons, choose which variation (big or small) to show for the horizontal or vertical Social Share Bar and order them via drag and drop. Choose which post types to display on so your social share bar appears only where you want it.
2. Display your social sharing links above your post content.
3. The vertical Social Share Bar appears as you scroll past the horizontal Social Share Bar and smoothly follows you down the page.

== Changelog ==

= 1.0.1 =
* Added a fix for Facebook IFRAME code snippet deployment to automatically specify the URL of the page being viewed (simulating the functionality of the XFBML deployment)

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
Bug fix: fixed problem with Facebook script deployment that was preventing proper URL liking functionality. 
