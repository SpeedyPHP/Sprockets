# PHP Sprocket

PHP Sprocket is a port of Sprockets - the ruby library for Javascript dependency management and concatenation. 
For syntax instructions visit http://getsprockets.org/installation_and_usage.

This fork is a rewrite of the the original PHPSprockets by Stuart Loxton.
 
Major differences between the original port and this fork are:

* The main class file has been renamed to "Sprocket"
* Commands are now classes. It is easy to extend Sprocket with new commands.
* Instead of YML this fork uses INI files for providing constants.
* Easy to extend due more abstraction, setters and a array based option interface
* Seperate render stage (with autoRender option to mimic the original render-on-construct).
* Also works with other files, like CSS and whatever you want to concat.. (see demo)
* Selective minification for JS and CSS out of the box. Just add "minify" (see demo files)
* Fully documented sourcecode

### Installation

# I would start with checking the demo. It contains the basics 
# Copy/Modify the .htaccess and sprocketize.php to your webroot.
# Modify the 'lib/sprocket.php' require-path to your needs.

### Changes to the original sprockets.

PHP Sprockets currently acts as a transparent proxy as default and caches results. 
Because of this you do not have to initialize any classes in your app and sprocket stays separate.

For constants you can use either @<%=@ or @<?=@ this is to make the syntax closer to PHPs but still 
keep compatibility with original sprocket files.

**NEW:** This fork of sprockets tends to be quiet different. Although it is generally the same, the feature 
to parse any text file is new. I think that's a good addition and a very obvious one too.  So sprockets 
now can deal with CSS if you like.

**NEW:** Powered by CSSmin and JSmin you can now minify your sourcecode while you require it in your 
sprocket files. All it takes is to add a "minify" to the end of the require statement. 
Example: @//= require "application" minify@ and the application.js (or .css) is minified


### Interface

```php
$sprocket = new Sprocket($filePath, array(    
	'contentType' => 'application/x-javascript',
	'baseUri' => '/my/site/',
	'baseFolder' => '/js',
	'assetFolder' => '..',
	'debugMode' => false,
	'autoRender' => false
));
```

If @debugMode@ is enabled then resulting files aren't cached. If @autoRender@ is enabled the file will
be echoed upon construct. If @contentType@ is false instead of a string the content-type is not sent.

If you disabled autoRender (default) then you need to call the @render()@ after creating the instance.
If you pass @true@ to the render method, @render()@ will not echo the javascript and return it as string instead.

You can also ignore the second constructor parameter and use setters. Setters always return the object itself 
so you can chain the commands: @$sprocket->setDebugMode(true)->setAutoRender(false)->render()@ and so on..

### Creating new commands

To create new commands like "require" and "provide" all you need to do is to create a new class in
the "commands" folder under "lib". For example, we want to create a "flag" command that somehow
modifies the output, like Stuart proposed. 

To add this we need to create a class called "SprocketCommandFlag" which extends "SprocketCommand".
Any command class needs to define a @exec()@ method. This method receives two parameters which we
can use to do stuff. SprocketCommand also has the Sprocket Object as property by design, so we can
use the current instance to get more info about the current job.
 
```php
// flag.php
namespace \Speedy\Sprocket\Commands;


use \Speedy\Sprocket\Command;

class Flag extends Command {
    function exec($param, $context) {
        // do something
    }
}
```

This is all there is to it. We can now perform @//= flag "something"@ in our source files and the
exec-method is called. In the event that we want to replace the sprocket command (//= ...) with a 
return value from the exec method (formatter, maybe..), the return value needs to be a string.

The exec method doesn't need to return anything. You can just use it to modify the sprocket object
if you want to.


### Credits

All thanks to Stuart for porting sprockets! I just modified it a bit. :)
Special Thanks to Sam Stephenson for the original idea.

Big up to Joe Scylla for CSSmin and Ryan Grove for JSmin. Their code 
power the new and fancy "minify" option.

### Maintainer

Kjell Bublitz - m3nt0r.de (at) gmail.com
