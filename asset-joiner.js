/**
 * @author : Herlangga Sefani <https://github.com/gaibz>
 */

'use strict';

const Lotek = require("lotek");

const config = {
    groups : [
        {
            // specify group name, for identifier
            name : "Development",
            // if true, then it will print out file location information inside output file
            debug_mode : true,
            // configuration for JS File
            js : {
                files : [
                 
                ],
                output : "./public/dist/vendors.js",
                // if true then content of file will be inside a javascript closure function. ()()
                use_closure_per_file : false,
                // if true then content of all file will be inside javascript closure function
                use_closure_all : false,
                // compress output into minified version
                minify : true,
                // @see : <https://www.npmjs.com/package/terser#compress-options>
                minify_options : {
                    format : {
                        beautify: true
                    }
                }
            },
            // Configuration for CSS Files
            css : {
                files : [
                    "./public/assets/soft-ui/css/nucleo-icons.css",
                    "./public/assets/soft-ui/css/nucleo-svg.css",
                    "./public/assets/soft-ui/css/soft-ui-dashboard.css"
                ],
                output : "./public/dist/soft-ui.css",
                // For Css This is important, as inside of css files may contain url() linked to another directory
                url_replaces : [
                    {
                        find : "public/",
                        replacement : "../"
                    },
                    // ... more
                ],
                // Replace Log Output Filepath
                replace_log_output : "./log/css_replacer_log.txt",
                // compress output into minified version
                minify : false,
                // @see https://github.com/jakubpawlowicz/clean-css#constructor-options
                minify_options: {
                    format: 'beautify'
                }
            },
        },
        {
            // specify group name, for identifier
            name : "Soft",
            // if true, then it will print out file location information inside output file
            debug_mode : true,
            // configuration for JS File
            js : {
                files : [
                    "./public/assets/soft-ui/js/core/popper.min.js",
                    "./public/assets/soft-ui/js/core/bootstrap.min.js",
                    "./public/assets/soft-ui/js/plugins/perfect-scrollbar.min.js",
                    "./public/assets/soft-ui/js/plugins/smooth-scrollbar.min.js",
                    "./public/assets/soft-ui/js/plugins/chartjs.min.js",
                    "./public/assets/soft-ui/js/soft-ui-dashboard.js",
                ],
                output : "./public/dist/soft-ui.js",
                // if true then content of file will be inside a javascript closure function. ()()
                use_closure_per_file : false,
                // if true then content of all file will be inside javascript closure function
                use_closure_all : false,
                // compress output into minified version
                // minify : true,
                // @see : <https://www.npmjs.com/package/terser#compress-options>
                // minify_options : {
                //     format : {
                //         beautify: true
                //     }
                // }
            },
        }
    ]
}

new Lotek(config).compile().then(() => {
    console.log("Done.");
});