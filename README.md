Headway Gallery To Gutenberg Gallery Converter
=========================

A simple plugin to convert Headway Galleries to a Gutenberg gallery


## Designed Use Case:

This plugin is designed for converting WordPress sites from the Headway theme to any other more modern WP theme. While converting away from Headway, you are left with a bunch of content/page elements that might not work without Headway, like galleries in this case. This plugin is used to turn a whole WordPress page into a gallery using the data from a Headway gallery. To elaborate, it takes all of the images assigned to headway gallery in the database and pushed them into the current page as a basic Gallery block. 
When it does this, it assumes that no other content should exist on the page other than the gallery. 

## Use the plugin with caution!

Warning: This plugin replaced the entire contents of any WordPress page with a selected Headway gallery. 

### How does it work?

The plugin creates a custom meta box on all pages that allows you to see a list of all Headway galleries in the current WP database.
Every Headway gallery in the list is a link. When the link is clicked on, it alters the current page's content and refreshes the page, leaving you with nothing in the page content but the new Gutenberg gallery block containing all of the images that were in the selected Headway gallery.

It is more than likely that you will need to do a block recovery on the resulting gallery block to get block syntax to auto-correct itself. Once this is done, the admin should update the page. 

That's it!

## Pro Tip
Once you are done using this plugin, it might be preferable to do a few things:
+ Find all rows in the wp_posts table that have a post type of hwr_gallery and delete them just to keep your posts table clean (unless you are trying to keep these just in case you need to use this plugin in the future for whatever reason)
+ Delete all rows in the wp_postmeta table associated with the post IDs of the removed posts from the previous tip. Again, keeping the database clean (this functionality might be added to this plugin at a later date).
+ Remove this plugin when you are done using it, it doesn't need to be installed to retain the new galleries that are created while using it