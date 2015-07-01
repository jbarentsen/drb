module.exports = function (grunt) {
    'use strict';

    grunt.file.defaultEncoding = 'utf8';

    // Project configuration.
    grunt.initConfig({
        // Paths variables
        paths: {
            // Development where put LESS files, etc
            assets: {
                css: './public/less/'
            },
            // Production where Grunt output the files      
            css: './public/css/'
        },
        less: {
            development: {
                options: {
                    compress: false //NOT minifying the result
                },
                files: {
                    "<%= paths.css %>bootstrap.css": "<%= paths.assets.css %>bootstrap.less"
                }
            },
            production: {
                options: {
                    compress: true //minifying the result
                },
                files: {
                    //compiling frontend.less into frontend.min.css
                    "<%= paths.css %>bootstrap.min.css": "<%= paths.assets.css %>bootstrap.less"
                }
            }
        },
        watch: {
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');

    // Task definition
    grunt.registerTask('default', ['watch']);
};
