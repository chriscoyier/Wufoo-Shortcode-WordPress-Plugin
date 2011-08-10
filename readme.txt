=== Plugin Name ===

Contributors: Chris Coyier
Plugin Name: Wufoo Shortcode
Plugin URI: http://wufoo.com
Tags: wufoo, form, shortcode
Author URI: http://wufoo.com
Author: Chris Coyier
Requires at least: 2.6
Tested up to: 3.2.1
Stable tag: 1.1
Version: 1.1

Allows the use of a special short code [wufoo] for embedding Wufoo forms.

== Description ==

Allows the use of a special short code [wufoo] for embedding Wufoo forms. It's best to grab the shortcode from the Wufoo Code Manager (coming soon!).

**Usage:** `[wufoo username="chriscoyier" formhash="x7w3w3" autoresize="true" height="458" header="show" ssl="true"]`

But again, it's best to grab the code directly from the Wufoo [Code Manager](http://wufoo.com/docs/code-manager/) (coming soon).

== Installation ==

For old school manual installation people: copy the folder "wufoo_shortcode" into the /wp-content/plugins/ folder. Then go to the Plugins area of the Admin and activate.

== Screenshots ==

http://cl.ly/97Pz

== Changelog ==

1.0 - Initial release.

1.1 - SSL param isn't included in snippet if not passed. Gratis and Ad Hoc Wufoo users don't use that param, as SSL is not offered.

== Frequently Asked Questions ==

**What is Wufoo?**

[Wufoo](http://wufoo.com) is a web app that helps anybody build amazing online forms. It's great for busy people who need to collect data or payments quickly, but don't want to deal with programming or servers. 

**Why is this useful?**

Shortcodes are clean! You can already copy and paste JavaScript or iframe code to embed a Wufoo form onto a WordPress page, but you need to make sure to be in the "HTML" tab of the writing area. If a user is in the "Visual" (default) tab, the embed code will not work. Short codes will work either way.

We also hope that this is the first step to WordPress.com integration (wink, wink).