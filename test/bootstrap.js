var Uniter = require("../index");
var env = Uniter.getEnvironment();

// Register I/O
env.getStdout().on("data", function(str){
    console.log(str);
});
env.getStderr().on("data", function(str){
    console.error(str);
});

// Expose a tiny function...
env.expose(function(){
    console.log("Hello in JS.");
}, "say_hello");
