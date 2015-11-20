<?php

// Syntax: Array
// https://github.com/asmblah/uniter/issues/22
#$arr = ["foo", "bar"];

// Syntax: fast-new
class Bard {
    public function story() {
        echo "Foo goes to Baz' bar.\n";
    }
}
(new Bard)->story();

// Common constants
// https://github.com/asmblah/uniter/issues/23
namespace UniterPHP\Test {
    class ConstantTests {
        static function run() {
            echo "Namespace: ".__NAMESPACE__."\n";
            echo "Class: ".__CLASS__."\n";
            echo "Function: ".__FUNCTION__."\n";
            echo "File: ".__FILE__."\n";
            echo "Dir: ".__DIR__."\n";
            echo "Line: ".__LINE__."\n";
            $hasEol = (PHP_EOL == "\n");
            echo "PHP_EOL: [".($hasEol ? "Yes":"No")."]\n";
        }
    }
    ConstantTests::run();
}

// Common functions
$funcs = array(
    "is_callable", "is_number", "is_null",
    "file_exists",
    "class_exists"
);
foreach($funcs as $func) {
    echo "$func => ".(function_exists($func) ? "Yes" : "No")."\n";
}
