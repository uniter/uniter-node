# It's time to unite: Uniter-Node!

Require Uniter PHP in NodeJS.

It's absolutely simple, really! Here is a basic example:

```javascript
var uniter = require("uniter-node");

// Register
uniter();

// Now, just require these like any other PHP file!
var exp = require("./myModule.php");
```

`myModule.php`
```php
<?php
$exports->a_number = 20;
$exports->a_string = "Hello, world";
$exports->a_function = function() {
    return 42;
};
```

And that's it!

## API
The Uniter-Node API is very simple and easy to use. Basically, once you require the module, it creates local-globals. That is, a runtime for your PHP code to run in, and an environment you can manage.

By default, STDIN is not used, STDOUT and STDERR are piped to `process.stdin` and `process.stderr` respectively.

- `.getEnvironment()`: Obtain an instance of a Uniter Environment.
- `.getOptions()`: Get current options.
- `.setOptions(opt)`: Use this to set the options.
- `.getParser()`: Get the parser instance.

Calling the module itself, as shown in the example, will register the `.php` extension with require. If you want to support other extensions too, do it like so:

```javascript
require.extensions[".phpt"] = require.extensions[".php"];
```

## Note
This is a proof of concept. It DOES work, but I am still working on this. There is still some stuff to do, like enabling actual `require()` calls to work as they should. See the `test/` folder to see a little demo.

To run the demo:

    $ cd test
    $ node run.js

You should see some action in your terminal now.
