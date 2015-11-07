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

// print?
// FIXME(Bug): This causes...an error.
/*
RangeError: Maximum call stack size exceeded
    at String.match (native)
    at module.exports (/Users/Ingwie/Work/uniter-node/node_modules/microdash/src/getType.js:15:37)
    at Object.module.exports [as isString] (/Users/Ingwie/Work/uniter-node/node_modules/microdash/src/isString.js:15:12)
    at ValueFactory._.extend.createFromNative (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/ValueFactory.js:81:19)
    at ValueFactory._.extend.coerce (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/ValueFactory.js:52:25)
    at /Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/Value/Array.js:54:39
    at Object.module.exports [as each] (/Users/Ingwie/Work/uniter-node/node_modules/microdash/src/each.js:25:26)
    at new ArrayValue (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/Value/Array.js:40:11)
    at ValueFactory._.extend.createArray (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/ValueFactory.js:57:20)
    at ValueFactory._.extend.createFromNative (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/ValueFactory.js:94:32)
    at ValueFactory._.extend.coerce (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/ValueFactory.js:52:25)
    at PropertyReference._.extend.getValue (/Users/Ingwie/Work/uniter-node/node_modules/phpcore/src/Reference/Property.js:60:35)
    at /Users/Ingwie/Work/uniter-node/node_modules/phpruntime/src/builtin/functions/variableHandling.js:87:42
    at Object.module.exports [as each] (/Users/Ingwie/Work/uniter-node/node_modules/microdash/src/each.js:25:26)
    at dump (/Users/Ingwie/Work/uniter-node/node_modules/phpruntime/src/builtin/functions/variableHandling.js:80:23)
    at /Users/Ingwie/Work/uniter-node/node_modules/phpruntime/src/builtin/functions/variableHandling.js:86:29
*/
#var_dump($module);

// Try to require! In fact, we can require ourselves.
$util = $require("../");
var_dump($util);

// Or...
$bar = $require("./bar.php");
var_dump($bar);

// But also...
#$baz = require_once "./baz.php";

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
