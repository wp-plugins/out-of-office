Contributors: La_ruso
Donate link: http://codemarker.co.uk/codemarker/out-of-office/
Tags: online, status, business, reachable, basic
Requires at least: 2.7.1
Tested up to: 4.1
Stable tag: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Out-of-Office is our rudimentary online/offline indicator with bells and whistles. 

== Description ==

Out-of-Office is our rudimentary online/offline indicator with bells and whistles.

With this plugin/widget you can:

    set your status online,
    state a title
    state a description
    show the indicator
    and show a post message.

Out-of-Office is a plugin/widget that can be displayed in the WIDGET section.
Bloggers and content-makers can insert it in posts and pages using shortcode.
Programmers can use our hook to insert it into pages and themes.


== Installation ==

1. Download plugin
2. Activate plugin

3. a. for use as a widget, go to Appearance>widgets screen and add your OOO widget to the desired part of your theme
   
   b. for shortcode in posts and pages, place [out_of_office] where desired
   
   c. for hooks, place the following in your php code
	<?php
	if(function_exists('out_of_office'))
	{
		do_action('out_of_office');
	}
	?>

FOr more information, please go to www.codemarker.co.uk/

Widget
shortcode
Hooks


== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* basic functinality but will be working on adding more functionaly.
