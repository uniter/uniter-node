var Uniter = require("../index");

// Register Uniter
Uniter();

// Bootstrap it
require("./bootstrap.js");

// Expose a var...
var someStuff = {tag: "awesome"};
Uniter.getEnvironment().expose(someStuff, "someStuff");

// Run PHP
var rt = require("./foo.php");

// PHP can export to module.exports. :3
console.log("PHP exported:",rt);

// This actually doesnt do a thing.
console.log("PHP returned:",rt.__php_return__);

// Let's use the PHP function we have.
rt.derper();

// And, even modify JS vars.
console.log("Now, someStuff =",someStuff);
