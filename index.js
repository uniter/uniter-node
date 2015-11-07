var php2ast = require("phptoast"),
    php2js  = require("phptojs"),
    phprt   = require("phpruntime/sync"),
    beauty  = require("beautifier").js_beautify;

// This environment is used throughout the global scope.
var $environment = phprt.createEnvironment();
var $parser = php2ast.create();
var $options = {};

// Set up defaults...
var $stdout = $environment.getStdout();
var $stderr = $environment.getStderr();

$stdout.on("data",function(str){ process.stdout.write(str); });
$stderr.on("data",function(str){ process.stderr.write(str); });

function makeModule(src) {
    return beauty([
        // Pull ourselves in.
        "var uniter = require('"+__filename+"')",
        // Generate/compile the engine and create a context
        "var generator = "+src,
        "var context = generator(uniter.getOptions(), uniter.getEnvironment());",
        // Expose the JS stuff...
        "context.expose(module, 'module');",
        "context.expose(exports, 'exports');",
        // I want to ACTUALLY expose require...
        "context.expose(require, 'require');",
        // Return.
        "var rt = context.execute();"
    ].join("\n"));
}

module.exports = function UniterPHP() {
    // Register!
    require.extensions[".php"] = function(module, filename) {
        var realSource = require("fs").readFileSync(filename, 'utf8');
        var newSource = php2js.transpile(
            $parser.parse(realSource),
            { sync: true }
        );
        var moduleCode = makeModule(newSource);

        // Evaluate.
        module._compile(moduleCode, filename);
    }
}

module.exports.getEnvironment = function() {
    return $environment;
}

module.exports.getParser = function() {
    return $parser;
}

module.exports.getOptions = function() {
    return $options;
}

module.exports.setOptions = function(opt) {
    $options = opt;
}
