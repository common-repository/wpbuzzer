=== WPBuzzer ===
Contributors: Hameedullah Khan
Donate link: http://hameedullah.com/
Tags: sharing, buzz
Requires at least: 2.7
Tested up to: 2.9
Stable tag: 0.9.1


== Description ==

Adds a button to allow share on Google Buzz.

Requirement:
You should have Google Reader in your Buzz connected sites.


== Installation ==

1. Unzip WPBuzzer-0.9.1.zip
2. Upload `WPBuzzer` directory to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the settings using "WPBuzzer" under Settings panel.

== Frequently Asked Questions ==

= From Where you got the Buzz images? =

I have used the images from Mashable.

= Why does it use Google Reader to publish items to Buzz =

Google haven't opened the Buzz API yet, so this plugin makes use of Google Reader Share option.

= How can I manually put the button in my template? =
Use wpbuzzer()

You can also specify css, size and show count options while using manual button, if you will not specify any arguments to wpbuzzer function
then it will use settings configured in plugin settings page. see example below:

Examples:
1. To show big button on the right with counter.
wpbuzzer("float:right;", "big", 1)

2. To show small button on the left with counter.
wpbuzzer("float:left;", "small", 1)

2. To show small button on the left without counter.
wpbuzzer("float:left;", "small", 0)

== Contact ==
You can contact me using contact form at: http://hameedullah.com/contact
Or tweet me at: hameedullah

== Changelog ==

= 0.9.1 =
fixed thumbnail support

= 0.9 =
updated to plugin to use official Google Share button

= 0.8.1 =
added srcTitle to reader share url

= 0.8 =
fixed bug in manual mode

= 0.7 =
fixed feed static button image
replaced file_get_contents with curl

= 0.6 =
fixed getting short url from bit.ly if the post is not published
changed plugin directory and filename name to lowercase

= 0.5 =
fixed to store counts from cache into $count - Reported by Randal from vizworld.com

= 0.4 =
fixed image not displaying if the blog was under subdirectory
added count support using bitly
added popup support
fixed readme.txt

= 0.3 =
added target="_blank" to anchor tag, now it always opens new window

= 0.2 =
fixed the image path issue

= 0.1 =
This is the first version of the plugin.


