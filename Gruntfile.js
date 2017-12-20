module.exports = function(grunt) {

    grunt.initConfig({
		pkg     : grunt.file.readJSON( 'package.json' ),
        replace: {
            core: {
                src: [ 'cf-paypal-pro.php' ],
                overwrite: true,
                replacements: [{
                    from: /Version:\s*(.*)/,
                    to: "Version: <%= pkg.version %>"
                }, {
                    from: /define\(\s*'CF_PAYPAL_PRO_VER',\s*'(.*)'\s*\);/,
                    to: "define( 'CF_PAYPAL_PRO_VER', '<%= pkg.version %>' );"
                }]
            },
            version_reamdme_txt: {
                src: [ 'readme.txt' ],
                overwrite: true,
                replacements: [{
                    from: /Stable tag: (.*)/,
                    to: "Stable tag: <%= pkg.version %>"
                }]

            }
        },
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
    grunt.loadNpmTasks('grunt-text-replace');
	grunt.registerTask('default', ['replace','compress']);

};