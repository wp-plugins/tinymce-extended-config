=== Plugin Name ===
Contributors: clarkewd
Donate link: http://willshouse.com/about/
Tags: tinymce, wysiwyg, attributes, tiny mce, config, theme_advanced_blockformats
Requires at least: 2.7.1
Tested up to: 2.9
Stable tag: 0.1.0

Allows one to configure some of the advanced settings of the TinyMCE editor, like the block formats. (theme_advanced_blockformats)

== Description ==

It is hard to customize the advanced options of the tinyMCE editor in wordpress. The javascript files
contained in the tinyMCE directory are only loaded if compression is not set. Also, editing
these files and then upgrading wordpress has the possibility to remove all of your customizations.

This plugin will allow you to edit the advanced cofiguration options that TinyMCE defines. 

**\*\* NOTE: Make sure after you add elements or attributes you do a *hard refresh (ctrl + F5)* of 
your browser on a _TinyMCE screen *(editing or creating a page/post)* so that the TinyMCE cache 
will be refreshed! You will not see your changes until you do this!**

== Installation ==

1. Upload the `tinymce-extended-config/` directory and its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **Manage -> TinyMCE Extended Config** and add some elements and attributes.

== Frequently Asked Questions ==

= I changed the config but it is not showing up  =

Most likely, you need to do a **hard refresh** of your browser (ctrl + F5). Your JavaScript cache needs to be
refreshed.