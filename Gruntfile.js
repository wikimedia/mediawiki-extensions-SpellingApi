/* eslint-env node */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );

	grunt.initConfig( {
		jsonlint: {
			all: [
				'*.json',
				'**/*.json',
				'!node_modules/**'
			]
		},
		banana: {
			all: 'i18n/'
		}
	} );

	grunt.registerTask( 'test', [ 'jsonlint', 'banana' ] );
	grunt.registerTask( 'default', 'test' );
};
