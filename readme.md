Plugin code replacement in a string for Laravel
===============================================

# Problem
Your user needs to inject a chunk of code into a basic string using their CMS functionality. You want them to be able to set a Google map or text from a database but you don't want them to be able to run code.

# Solution
Set up their code and allow them to reference it in their text string.

Installing
==========

Add the dependency to your project:

```bash
composer require DNABeast/tusk:dev-master
```

After updating composer, add the ServiceProvider to the providers array in config/app.php

### Laravel 5.2:

```
DNABeast\Tusk\TuskServiceProvider::class,
```

Add the directory Plugin/lib to your App directory to contain your plugin files.

Usage
=====

In your blade file put your string inside the tusk directive.

```
@tusk('Your string [[- map -]]. Rest of String')
```
This writes a file in App\Plugins called map.php. If this file already exists nothing happens.

If your map.php file was this
```
<?php echo '<iframe>Map</iframe>'; ?>
```

The blade file would replace [[- map -]] and output
```
Your string <iframe>Map</iframe>. Rest of String
```

## Use Case
Your user can update their contact page with basic text but you don't want to allow iframes. You can still allow them to enter [[- googlemap -]] to inject the google map html required to embed a map.

You have code that can spit out a list of links from the database. You also have basic pages on the site that allow the user to update their content and they can include the list code without having access to the actual code by simply entering [[- linklist -]].

## Potential pitfall
You plugin file can be all html but if it has php you need to echo the result. If you return it nothing will display.
ie.
```
<?php
	$x = 34+65;
	return $x; // <- This wont work. You must echo it.
	?>
```