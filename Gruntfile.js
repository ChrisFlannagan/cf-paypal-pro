module.exports = function(grunt) {

    grunt.initConfig({
		pkg     : grunt.file.readJSON( 'package.json' ),
		compress: {
            main: {
                options: {
					mode: 'zip',
					archive: 'releases/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
                files: [
                    {src: ['cf-paypal-pro.php'], dest: 'cf-paypal-pro/', filter: 'isFile'},
                    {src: ['readme.txt'], dest: 'cf-paypal-pro/', filter: 'isFile'},
                    {src: ['assets/**'], dest: 'cf-paypal-pro/'},
                    {src: ['includes/**'], dest: 'cf-paypal-pro/'},
                    {src: ['languages/**'], dest: 'cf-paypal-pro/'},
                    {src: ['src/**'], dest: 'cf-paypal-pro/'},
                    {src: ['vendor/**'], dest: 'cf-paypal-pro/'}
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.registerTask('default', ['compress']);

};