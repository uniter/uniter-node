var Uniter = require("../index");
var env = Uniter.getEnvironment();

// Expose a tiny function...
env.expose(function(){
    console.log("Hello in JS.");
}, "say_hello");
