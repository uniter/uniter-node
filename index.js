var php2ast = require("phptoast"),
    php2js  = require("phptojs"),
    phprt   = require("phpruntime/sync"),
    beauty  = require("beautifier").js_beautify,
    path = require("path"),
    fs = require("fs");

// This environment is used throughout the global scope.
var $environment = phprt.createEnvironment();
var $parser = php2ast.create();
var $options = {};

// Set up defaults...
var $stdout = $environment.getStdout();
var $stderr = $environment.getStderr();

// # I/O for console. STDIN is unused by default.
$stdout.on("data",function(str){ process.stdout.write(str); });
$stderr.on("data",function(str){ process.stderr.write(str); });

// include/_once|require/_once() support...
$environment.options = {
    include: function(requiredFile, p, sourceFile) {
        var requireable;
        if(path.isAbsolute(requiredFile)) {
            requireable = requiredFile;
        } else {
            var sourceDir = path.dirname(sourceFile);
            requireable = path.join(sourceDir, requiredFile);
        }
        var src = fs.readFileSync(requireable, "utf8");
        var bareSource = compile(src, true);
        var bareWrapper = new Function('return ' + bareSource + ';');
        var wrapper = phprt.compile(bareWrapper);
        p.resolve(wrapper);
    }
}

// Simple wrapper function.
function compile(source, bare) {
    bare = bare || false;
    var jsSource = php2js.transpile(
        $parser.parse(source),
        { sync: true, bare: bare }
    );
    return jsSource;
}

function makeModule(wrapper, file) {
    file = JSON.stringify(file);
    var thisModule = JSON.stringify(__filename);
    return beauty([
        // Pull ourselves in.
        "var uniter = require("+thisModule+")",
        "var _ = require('microdash');",
        // Generate/compile the engine and create a context
        "var generator = "+wrapper,
        "var opts = _.extend({path: "+file+"}, uniter.getOptions());",
        "var context = generator(opts, uniter.getEnvironment());",
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
        var source = fs.readFileSync(filename, 'utf8');
        var moduleCode = makeModule(compile(source), filename);

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
