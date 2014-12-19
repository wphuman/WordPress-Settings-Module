# WordPress Settings Module

WordPress Settings Module is a standardized, organized, object-oriented foundation for building extendable WordPress Plugins.

## Features
* The Module is based on the [Settings API](http://codex.wordpress.org/Settings_API), [Options API](http://codex.wordpress.org/Options_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](http://make.wordpress.org/core/handbook/inline-documentation-standards/php-documentation-standards/).
* A set of hooks come out of the box. So that your plugin can be extended by other add-ons. See [hook list](#hook-list).
* A static class for retrieving saved settings. See [get options](#get-options).
* (TODO) All classes, functions, and variables are documented so that you know what you need to be changed.



## Installation
This is an example of using WordPress Settings Module on a **fresh** [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/)

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


## Add a tab
WordPress Settings Module comes with 2 tabs. Open `trunk/admin/class-plugin-name-admin.php`. Modify the `$tabs` array to add extra tabs.

```php
public function get_options_tabs() {

	$tabs 					= array();
	$tabs['default_tab']  	= __( 'Default Tab', $this->plugin_name );
	$tabs['second_tab']  	= __( 'Second Tab', $this->plugin_name );
	$tabs['marry_me']  		= __( 'Marry Me', $this->plugin_name );

	return apply_filters( $this->snake_cased_plugin_name . '_settings_tabs', $tabs );
}
```

## Add settings to a tab
Open `trunk/admin/settings/class-plugin-name-settings.php`. Let's add 3 new settings to the `$settings` array.

```php
private function set_registered_settings() {

	$settings = array(

		// ... lots of lines of examples

	'second_tab' => apply_filters( $this->snake_cased_plugin_name . '_settings_second_tab',
		array(
			'extend_me' => array(
				'id' => 'extend_me',
				'name' => 'Extend me',
				'desc' => __( 'You can extend me via hooks and filters.', $this->plugin_name ),
				'type' => 'text'
				)
			)
		),
	'marry_me' => apply_filters( $this->snake_cased_plugin_name . '_settings_marry_me',
		array(
			'your_name' => array(
				'id' => 'your_name',
				'name' => __( "What's your name?", $this->plugin_name ),
				'desc' => __( 'I cant help falling in love with you', $this->plugin_name ),
				'type' => 'text'
				),
			'question' => array(
				'id' => 'question',
				'name' => __( 'Will you marry me?', $this->plugin_name ),
				'desc' => __( 'Take my hand, take my whole life, too', $this->plugin_name ),
				'options' => array(
					'yes' => __( 'Yes, i do!', $this->plugin_name  ),
					'maybe' => __( 'Maybe', $this->plugin_name  ),
					'no'  => __( 'F**k off', $this->plugin_name  )
					),
				'type' => 'radio'
				),
			'wedding_vow' => array(
				'id' => 'wedding_vow',
				'name' => __( 'Wedding vow', $this->plugin_name ),
				'desc' => __( "Don't make me cry, baby", $this->plugin_name ),
				'type' => 'rich_editor'
				)
			)
		)
	);

	return $settings;
}
```

Here is the resulting screenshot.
![marry me settings](https://raw.githubusercontent.com/wphuman/WordPress-Settings-Module/master/screenshot-marry-me.png)

## Get Options
You can rertive saved settings by `Plugin_Option::get_option( $key, $default )`

```php
Plugin_Option::get_option( 'your_name' );
Plugin_Option::get_option( 'question' );
Plugin_Option::get_option( 'wedding_vow' );
```

## Hook List
For add-ons to extend the settings page:
* `plugin_name_settings_tabs`
* `plugin_name_settings_<tab_slug>`

During settings saving:
* `plugin_name_settings_sanitize_<tab>`
* `plugin_name_settings_sanitize_<type>`
* `plugin_name_settings_sanitize`
* `plugin_name_settings_on_change_<key>`

## Is it a must to use WordPress Settings Module with WordPress Plugin Boilerplate?
No.

[Tom McFarlin](http://tommcfarlin.com)'s [WordPress Plugin Boilerplate](https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/) is a great skeleton to build WordPress plugins. Strongly recommanded. However, it is not required for WordPress Settings Module.


## Credits
The WordPress Settings Module was started in December 2014 by [Tang Rufus](http://tangrufus.com/) from [WP Human](https://wphuman.com/).

Inspired by Pippin Williamson's [How I Built the Easy Digital Downloads Settings System](https://pippinsplugins.com/how-i-built-settings-system-easy-digital-downloads/).

## Documentation, Tutorials, FAQs, and More

Not yet completed. If you’re interested, please [let me know](https://wphuman.com/contact/) and we’ll see what we can do.

