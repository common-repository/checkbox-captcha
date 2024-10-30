=== Plugin Name ===
Plugin Name: Checkbox Captcha
Description: This small plugin adds a checked checkbox to the comment form, disabling the submit button. It is less intrussive than an actual captcha and better protects against spam.
Version: 1.0
Stable tag: 1.0
Author: Andrei Sangeorzan
Author URI: http://huzze.net/
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Captcha made right!

== Description ==

This is a tiny and simple plugin that helps fight spam on your site. All it does is add a checkbox in the comment form. When checked, the submit button is disabled. It's less intrusive than a text based captcha.

I strongly recommend using it with Akismet. Nothing replaces that, really. 
But Akismet can still create a bit of database usage, when confronted with a lot of spam. This plugin intends to help Akismet by giving it less to do.
The main idea is not mine. I found a similar feature in <a href="http://contactform7.com/" target="_blank">Contact Form 7</a>, so a bit of credit goes there.

During testing this plugin seemed to work better than text-based captchas. For reference without any captcha I had around 1000 spam comments per hour, with reCAPTCHA around 200, but with this method there are only about 2-3 spam comments per hour.

== Installation ==

Just install and activate. Configure if necessary.

== Screenshots ==

1. The settings page
2. This is how the plugin looks

== Changelog ==

= 1.0 =
- Bumping version number, since no bugs or problems were discovered during testing. TBD: use vanilla JS instead of jQuery for the actual code.

= 0.6 =
- Resolved a small problem with the settings submit button. The old button had a bug where it would delete the two fields, elaving them blank. Weird, right?
- Using jQuery.noConflict to avoid messing stuff up.

= 0.5.2.1 =
- Tiny aesthetic changes for the settings page.

= 0.5.2 =
- Added confirmation message upon saving the settings

= 0.5.1 =
- another try at making the plugin properly load jquery.

= 0.5 =
- Resolved a few bugs with instalation and activation.
- jQuery, needed for the plugin to work, should now be included by the plugin, if not included by wordpress previously.

= 0.1-beta =
- initial release