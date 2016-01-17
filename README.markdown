# About `wordpress-plugin-skeleton`

This repository contains a simple, opinionated scaffold for new WordPress plugins. It is basically what `wp scaffold plugin <my_wp_plugin>` generates when using [WP-CLI](http://wp-cli.org/), but with my own embellishments added afterwards. Notably, these include:

* Object-oriented plugin code with working activation, deactivation, initialization, and uninstallation routines.
* Extra bundled helper plugins (like [WP Screen Help Loader](https://wordpress.org/plugins/wp-screen-help-loader/)) ready to be used out-of-the-box.
* Thoroughly commented [phpDocumentor](http://phpdoc.org/) docblocks and developer tool files like `phpdoc.dist.xml`, `.gitignore`, and `.travis.yml` files (for [Travis-CI](https://travis-ci.org/) integration).
* Customized `Plugin_UnitTestCase` class (which `extends WP_UnitTestCase`).

Basically, you should be able to `cp -R wordpress-plugin-skeleton wp-content/plugins/YOUR_NEW_PLUGIN` and have more than just a "Hello world" example already working.

If this proves useful enough I may write a code generator for some of these things, but for now a `cp` works fine for me.

# My_WP_Plugin

A readme file intended for developers. You can use [Markdown](https://daringfireball.net/projects/markdown/) here.

**See the [screenshots](https://wordpress.org/plugins/My_WP_Plugin/screenshots/) for an example walkthrough of how My_WP_Plugin works.**
