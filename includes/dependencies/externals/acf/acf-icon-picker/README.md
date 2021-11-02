ACF { fontIconPicker
==============

Adds a Fonts Icons Picker field type for the [Advanced Custom Fields](http://wordpress.org/extend/plugins/advanced-custom-fields/) WordPress plugin. Go to the [official plugin page](http://codeb.it/fonticonpicker/#acf) for custom configuration and example of use.

### Compatibility

This add-on will work with:

* version 4 and 5 (thx to [WilkoManger](https://github.com/WilkoManger)) of ACF

* Firefox (edge), Safari (edge), Chrome (edge), IE8+.

### Installation

This add-on can be treated as a WP plugin, a composer package or a theme include.

**Install as WP Plugin**

1. Copy the whole content of the repository in a new `acf-fonticonpicker` folder within your `wp-content/plugins` folder
2. Activate the plugin via the Plugins admin page

**Install with Composer**

If your project is already setup to use composer use the command below to install the plugin.

```bash
$ composer require "micc83/acf-fonticonpicker:dev-master"
```

Or add the below to your `composer.json` and update (using `composer update`). Note `composer/installers` package is required to install the plugin to the correct location.

```json
{
    "require": {
        "composer/installers": "*",
        "micc83/acf-fonticonpicker": "dev-master"
    }
}
```

**Include within theme**

1.	Copy the whole content of this repository into an `acf-fonticonpicker` folder within your theme folder (can use sub folders).
2.	Edit your `functions.php` file and add the code below:

```php
include_once('acf-fonticonpicker/acf-fonticonpicker.php');
```
## Credits

jQuery fontIconPicker has been made by [me](http://codeb.it). You can contact me at micc83@gmail.com or [twitter](https://twitter.com/Micc1983) for any issue or feauture request.

I really have to thank miniMAC for the idea, Zeno Rocha for jQuery plugin boilerplate, Dave Gandy for the beautiful set of icons, WilkoManger for adding support for ACF5 and Elliot Condon for the amazing work done on Advanced Custom Field.
