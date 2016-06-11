# Sample Child Theme for OJS 3

A demonstration theme showing how to create a child theme for the default theme in OJS 3.

## What is a child theme?

A child theme is a theme that extends an existing theme by adding or modifying the styles, scripts or templates loaded by that theme. A child theme is the best way to make small modifications to an existing theme, without editing that theme's files.

This allows you to take advantage of updates to the parent theme, keep your custom code separate, and minimize conflicts when upgrading the software.

## Getting familiar with the theme API

OJS 3 provides a simplified theme API. All themes reside in the `/plugins/themes/` directory and require three files.

- The `index.php` loads the theme's PHP class file and instantiates it. [View the example](index.php)
- The `version.xml` file defines basic information about the theme. [View the example](version.xml)
- The theme's PHP class file should reflect the name of the plugin (eg - DefaultChildThemePlugin.inc.php). This is where the good stuff happens. [View the example](DefaultChildThemePlugin.inc.php)

The theme's PHP class file is where the theme will load styles and scripts,
define it's name and description, and do whatever else is desired.

Let's walk through an example. In the snippet below, we load OJS's `ThemePlugin` class and then define our
own class, `DefaultThemePlugin` which extends that class.

```
import('lib.pkp.classes.plugins.ThemePlugin');
class DefaultThemePlugin extends ThemePlugin {
```

Next, we define the `init()` method. This method allows us to register styles
and scripts. It is only ever called when the theme is _active_.

```
public function init() {
	// We'll do stuff here soon...
}
```

In the example below, we have added a [LESS](http://lesscss.org) stylesheet and a JavaScript file.

```
public function init() {
	$this->addStyle('default', 'styles/index.less');
	$this->addScript('default', 'js/main.js');
}
```

The first argument passes a unique reference name. It can be whatever you'd like but it should remain unique to your theme.

The second argument tells it where to look to find these files. These paths are relative to your theme directory. So if your theme is in `/plugins/themes/my-custom-theme/`, you'd put the LESS file at `/plugins/themes/my-custom-theme/styles/index.less`.

The theming API will automatically load these styles and scripts on the frontend of the site for you.

Finally, we pass a name and description for the theme. And this is all there is to a basic theme.

```
public function getDisplayName() {
	return 'An Example Theme';
}

public function getDescription() {
	return 'This is a theme to be used for examples when describing the theme API.';
}
```

## Creating a child theme

A child theme will extend an existing theme. It can add new scripts and styles,
modify the parent theme's scripts and styles, and override template files in the
parent theme.

A child theme requires the same foundation as a regular theme. That means you'll need an [index.php](index.php) and [version.xml](version.xml) file, as well as a [class for your child theme](DefaultChildThemePlugin.inc.php).

You'll want to write a custom `init()` method. Let's look at an example.

In the example below, you'll notice we're not adding any scripts or styles. Instead we call `setParent()` and pass it the name of our parent theme's plugin. The API will automatically load the parent theme and any of it's styles.

```
public function init() {
	$this->setParent('defaultthemeplugin');
	$this->modifyStyle('default', array('addLess' => array('styles/colors.less')));
}
```

The next thing we do is call `modifyStyle()`. This allows us to modify the arguments of any style that's already been registered, by passing an array of key/value parameters.

If you remember from before, our parent theme loaded the `default` style. We're passing an `addLess` parameter which tells the API to add an extra LESS file before compiling the CSS.

In this sample child theme, we add a small LESS file with custom color variables. These new variable definitions will override those set in the parent theme.

Take a look at the [full example](DefaultChildThemePlugin.inc.php).

## Examples

### Add a CSS file

```
public function init() {
	$this->addStyle('my-custom-style', 'styles/stylesheet.css');
}
```

### Add a LESS file
[LESS](http://lesscss.org) supports variables, nesting, mix-ins and more useful tools for writing CSS code. OJS 3 will automatically compile LESS files and output CSS. And child themes can extend LESS files so that it's easy to change fonts, colors, spacing and more.

```
public function init() {
	$this->addStyle('my-custom-style', 'styles/index.less');
}
```

### Add a JavaScript file
JavaScript files will automatically be loaded at the bottom of the document for best performance.

```
public function init() {
	$this->addScript('my-javascript', 'js/main.js');
}
```

### Load a custom font
By default, all paths are relative to the theme directory. But you can pass a
`baseUrl` parameter to override this. This is useful for loading external assets
like a custom font.

```
public function init() {
	$this->addStyle(
		'my-custom-font',
		'//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic',
		array('baseUrl' => '')
	);
}
```

### Modify an existing style
A stylesheet that's already been registered can be modified. This example adds
an additional LESS file to parse before compiling the CSS, allowing variables to
be overridden and more styles to be added.

```
public function init() {
	$this->modifyStyle('default', array('addLess' => array('styles/colors.less')));
}
```

### Load a custom font and override existing font definitions

```
public function init() {

	// Add the custom font
	$this->addStyle(
		'my-custom-font',
		'//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic',
		array('baseUrl' => '')
	);

	// Modify an existing style with a LESS file that overrides the font styles
	$this->modifyStyle('default', array('addLess' => array('styles/my-custom-font.less')));
}
```
