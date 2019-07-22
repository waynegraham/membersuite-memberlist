module.exports = function(grunt) {

	'use strict';
	var banner = '/**\n * <%= pkg.homepage %>\n * Copyright (c) <%= grunt.template.today("yyyy") %>\n * This file is generated automatically. Do not edit.\n */\n';
	// Project configuration
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		addtextdomain: {
			options: {
				textdomain: 'membersuite-memberlist',
			},
			target: {
				files: {
					src: ['*.php', '**/*.php', '!node_modules/**', '!php-tests/**', '!bin/**']
				}
			}
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					mainFile: 'membersuite-memberlist.php',
					potFilename: 'membersuite-memberlist.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true
					},
					type: 'wp-plugin',
					updateTimestamp: true
				}
			}
		},

		sass: { // Task
			dist: { // Target
				options: { // Target options
					// style: 'expanded',
					// sourcemap: 'none'
				},
				files: [{ // Dictionary of files
					expand: true,
					cwd: '_scss',
					src: ['*.scss'],
					dest: 'public/css/',
					ext: '.css'
				}]
			}
		},

		postcss: { // Begin Post CSS Plugin
			options: {
				map: false,
				processors: [
					require('autoprefixer')({
						// browsers: ['last 2 versions'],
						browserlist: [
							"last 2 versions",
							"> 1%",
							"maintained node versions",
							"not dead"
						]
					})
				]
			},
			dist: {
				src: 'public/css/main.css'
			}
		},

		cssmin: { // Begin CSS Minify Plugin
			target: {
				files: [{
					expand: true,
					cwd: 'public/css',
					src: ['*.css', '!*.min.css'],
					dest: 'public/css',
					ext: '.min.css'
				}]
			}
		},

		uglify: { // Begin JS Uglify Plugin
			build: {
				files: [{
					expand: true,
					cwd: 'src/',
					src: ['*.js', '!*.min.js'],
					dest: 'public/js/',
					ext: '.min.js'
				}]
			}
			// build: {
			// 	src: ['src/*.js'],
			// 	dest: 'public/js/'
			// }
		},

		watch: { // Compile everything into one task with Watch Plugin
			css: {
				files: '**/*.scss',
				tasks: ['sass', 'postcss', 'cssmin']
			},
			js: {
				files: 'src/**/*.js',
				tasks: ['uglify']
			}
		}
	});

	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('i18n', ['addtextdomain', 'makepot']);
	grunt.registerTask('readme', ['wp_readme_to_markdown']);
	grunt.registerTask('scss', ['sass']);

	grunt.registerTask('default', ['watch']);

	grunt.util.linefeed = '\n';

};