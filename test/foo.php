<?php

// Talk...
echo "Hello in UniterPHP\n";
$say_hello();

// Do something to JS.
$someStuff->tag = "very awesome";

// Export a value.
$module->exports->meaningOfLife = 42;

// Yes, even functions.
$module->exports->derper = function() {
    echo "I can be called from JS!\n";
};

// print? Sure.
var_dump($module);

// Try to require! In fact, we can require ourselves.
$util = $require("../");
var_dump($util);

// Or...
$bar = $require("./bar.php");
var_dump($bar);

// But also...
// FIXME(Bug): Can not assign return to value.
/* TypeError: value.getForAssignment is not a function
    at Variable._.extend.setValue (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/Variable.js:132:40)
    at /Users/Ingwie/Work/uniter-node/test/foo.php:46:30
    at Engine._.extend.execute (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/Engine.js:379:20)
    at Object.<anonymous> (/Users/Ingwie/Work/uniter-node/test/foo.php:64:18)
    at Module._compile (module.js:425:26)
    at Object.UniterPHP.require.extensions..php (/Users/Ingwie/Work/uniter-node/index.js:77:16)
    at Module.load (module.js:356:32)
    at Function.Module._load (module.js:311:12)
    at Module.require (module.js:366:17)
    at require (module.js:385:17)
*/
#$bar = require_once("./baz.php");

// Hey, namespaces?
namespace UniterNode\Test {
    // FIXME(Bug): This should print the namespace. But it doesn't.
    #echo "I am in: ".__NAMESPACE__;
}

// Classes work too.
class Bard {
    static function story() {
        echo "Foo used to go to Baz' bar.\n";
    }
}
Bard::story();

// Returning does _nothing_ - for now.
return "returned flatly.";
