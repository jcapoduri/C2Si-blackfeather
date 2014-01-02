// Demo configuration file
module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'js/<%= pkg.name %>.js',
                dest: 'bin/js/<%= pkg.name %>.min.js'
            }
        },
        requirejs: {
            compile: {
                options: {
                    baseUrl: "js",
                    mainConfigFile: "js/config.js",
                    out: "bin/js/backfeather.js",
                    name: "app/application",
                    optimize: 'uglify',
                    normalizeDirDefines: 'all'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-requirejs');

     // Default task(s).
    grunt.registerTask('default', ['uglify']);
    //
    grunt.registerTask('compile', ['requirejs']);
};