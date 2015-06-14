# WordPress Settings Module

WordPress Settings Module is a standardized, organized, object-oriented foundation for building extendable WordPress Plugins.

## Features
* The Module is based on the [Settings API](http://codex.wordpress.org/Settings_API), [Options API](http://codex.wordpress.org/Options_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](http://make.wordpress.org/core/handbook/inline-documentation-standards/php-documentation-standards/).
* A set of hooks come out of the box. So that your plugin can be extended by other add-ons. See [hooks & filters list](#hook--filter-list).
* A static class for retrieving saved settings. See [get options](#get-options).
* (TODO) All classes, functions, and variables are documented so that you know what you need to be changed.


## Installation
Check out this [blog post](https://wphuman.com/announcing-wordpress-settings-module/) for a more detailed installation guide.

Here is an short example of using WordPress Settings Module on a **fresh** [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/)

1. Clone the [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/) repo. And, follow its [installation instructions](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/blob/master/README.md#installation) but leave `Plugin_Name` unchanged.
`git clone https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate.git`

2. Clone the WordPress Settings Module repo
`git clone https://github.com/wphuman/WordPress-Settings-Module.git`

3. Copy these files into the thier counterparts in `/trunk/`:
  * `WordPress-Settings-Module/admin/partials/*`
  * `WordPress-Settings-Module/admin/settings/*`
  * `WordPress-Settings-Module/admin/class-plugin-name-admin.php`
  * `WordPress-Settings-Module/includes/class-plugin-name-option.php`
  * `WordPress-Settings-Module/includes/class-plugin-name.php`

  **Important**: Be careful when you replacing existing files. Review what is new from the WordPress Settings Module since it is *not* only intended for WordPress Plugin Boilerplate.

4. Here is a screenshot of the file structure. Arrows indicate files from WordPress Settings Module.
![file structure](https://raw.githubusercontent.com/wphuman/WordPress-Settings-Module/master/screenshot-file-structure.png)

5. Open the new options page for a full list of *settings* avaiable.
![settings list](https://raw.githubusercontent.com/wphuman/WordPress-Settings-Module/master/screenshot-settings-list.png)


## Changing Plugin Names
Besides changing the file names, these lines must be changed:
* `admin/settings/class-plugin-name-settings-definition.php`

  `$plugin_name = 'plugin-name'`

* `includes/class-plugin-name-option.php`

  `$plugin_options = get_option( 'plugin_name_settings', array() );`

## Get Options
You can rertive saved settings by `Plugin_Option::get_option( $field_key, $default )`


## Hook & Filter List
For add-ons to extend the settings page:
* `plugin_name_settings_tabs`
* `plugin_name_settings_<tab_slug>`

During settings saving:
* Filter: `plugin_name_settings_sanitize_<tab_slug>`
* Filter: `plugin_name_settings_sanitize_<type>`
* Filter: `plugin_name_settings_sanitize`
* Action: `plugin_name_settings_on_change_<tab_slug>`
* Action: `plugin_name_settings_on_change_<field_key>`
   * Eg: `$this->loader->add_action( 'plugin_name_settings_on_change_my_tab_name', $plugin_admin, 'my_tab_name_settings_save', 10, 2 );`

## Limitation
* `tab_slug` cannot be the same as `field_key`

## Is it a must to use WordPress Settings Module with WordPress Plugin Boilerplate?
No.

[Tom McFarlin](http://tommcfarlin.com)'s [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/) is a great skeleton to build WordPress plugins. Strongly recommanded. However, it is not required for WordPress Settings Module.


## Credits
The WordPress Settings Module was started in December 2014 by [Tang Rufus](http://tangrufus.com/) from [WP Human](https://wphuman.com/).

Inspired by Pippin Williamson's [How I Built the Easy Digital Downloads Settings System](https://pippinsplugins.com/how-i-built-settings-system-easy-digital-downloads/).

## Documentation, Tutorials, FAQs, and More

Not yet completed. If you’re interested, please [let me know](https://wphuman.com/contact/) and we’ll see what we can do.
