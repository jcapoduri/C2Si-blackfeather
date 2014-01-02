// Demo configuration file
module.exports = function(grunt) {
    // load tasks
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');

    //config each task
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
                    out: "bin/js/blackfeather.js",
                    include: ['app/application', 'main.js'],
                    //optimize: 'uglify',
                    normalizeDirDefines: 'all'
                }
            }
        },
        cssmin: {
          compile: {
            files: {
              'bin/styles/style.css': ['styles/normalize.css', 'styles/bootstrap.css', 'styles/bootstrap-theme.css', 'styles/bootstrap-responsive.css', 'styles/yeti.bootstrap.css', 'styles/styles.css']
            }
          }
        },
        copy: {
          compile: {
            files: [
              {expand: true, src: ['assets/**'], dest: 'bin/'},
              {expand: true, src: ['fonts/**'], dest: 'bin/'},
              {expand: true, cwd: 'server/', src: ['**'], dest: 'bin/'},
              {expand: true, src: ['index.php'], dest: 'bin/'},
              {expand: true, src: ['.htaccess'], dest: 'bin/'},
              {expand: true, cwd: 'js/vendors/requirejs', src: ['require.js'], dest: 'bin/js'},
            ]
          }
        },
        clean: ['bin/']
    });


     // Registering grunt tasks
    grunt.registerTask('default', ['uglify']);

    grunt.registerTask('compile', ['clean', 'requirejs', 'cssmin', 'copy']);
};