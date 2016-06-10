"use strict";

var fs = require("fs");

function __require( file ) {
    var dir = process.cwd().concat("/resources/js/js/");
    var contents = fs.readFileSync(
        dir.concat(file),
        "utf-8"
    );

    return contents;
}

module.exports = __require;