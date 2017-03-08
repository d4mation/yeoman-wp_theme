"use strict";
var Generator = require( 'yeoman-generator' );
var ejs = require( 'ejs' );
var extend = require('deep-extend');

module.exports = class extends Generator {

	// The name `constructor` is important here
	constructor( args, opts ) {

		// Calling the super constructor is important so our generator is correctly set up
		super( args, opts );

	}

	prompting() {

		// Prompt for data from the User
		return this.prompt( [ 
			{
				type: 'input',
				name: 'pkgName',
				message: 'Package Name?',
				default: this.appname.replace( ' ', '_' ), // Default to current folder name
			},
			{
				type: 'input',
				name: 'themeName',
				message: 'Theme Name?',
				default: this.appname, // Default to current folder name
			},
			{
				type: 'input',
				name: 'themeDescription',
				message: 'Theme Description?',
				default: this.contextRoot, // Defaults to theme directory path
			},
			{
				type: 'input',
				name: 'themeURI',
				message: 'Theme URI? (Optional)',
				default: '',
			},
			{
				type: 'input',
				name: 'parentTheme',
				message: 'Parent Theme Directory? (Optional)',
				default: '',
			},
			{
				type: 'input',
				name: 'author',
				message: 'Theme Author? (Optional)',
				default: '',
			},
			{
				type: 'input',
				name: 'authorURI',
				message: 'Theme Author URI? (Optional)',
				default: '',
			},
			{
				type: 'input',
				name: 'contributors',
				message: 'Theme Contributors? (Optional)',
				default: '',
			},
			{
				type: 'input',
				name: 'minimumWP',
				message: 'Minimum WordPress version? (Optional)',
				default: '4.4',
			},
			{
				type: 'input',
				name: 'gitHubURL',
				message: 'GitHub URL? (Optional)',
				default: '',
			}
		] ).then( ( answers ) => {

			this.props = answers;

			for ( var key in this.props ) {
				if ( this.props[key].trim )
					this.props[ key ] = this.props[ key ].trim(); 
			}

			// Ensure there's no dumb input
			this.props.pkgName = this.props.pkgName.replace( ' ', '_' );

			// Used for the Text Domain and File Names
			this.props.textDomain = this.props.pkgName.toLowerCase().replace( /_/g, '-' ).replace( /\s/g, '-' ).trim();

			// Used for Filter Names/Function Prefixes
			this.props.pkgNameLowerCase = this.props.pkgName.toLowerCase().trim();

			// The JavaScript Object used in Localized Scripts
			this.props.javaScriptObject = this.props.pkgName.charAt( 0 ).toLowerCase() + this.props.pkgName.slice( 1 ).replace( /[\W|_]/g, '' );

			if ( this.props.themeURI == '' && 
				this.props.gitHubURL !== '' ) {
				this.props.themeURI = this.props.gitHubURL; // Allow Theme URL to fallback to GitHub URL
			}

		} );

	}

	writing() {

		this.fs.copy(
			this.templatePath( './.gitignore' ),
			this.destinationPath( './.gitignore' ), {

			}
		);

		this.fs.copy(
			this.templatePath( './gulpfile.js' ),
			this.destinationPath( './gulpfile.js' ), {

			}
		);

		this.fs.copy(
			this.templatePath( './gulp/**/*.*' ),
			this.destinationPath( './gulp/' ), {

			}
		);

		this.fs.copyTpl(
			this.templatePath( './gruntfile.js' ),
			this.destinationPath( './gruntfile.js' ), {
				textDomain: this.props.textDomain,
			}
		);

		this.fs.copyTpl(
			this.templatePath( './functions.php' ),
			this.destinationPath( './functions.php' ), {
				pkgName: this.props.pkgName,
				themeName: this.props.themeName,
				textDomain: this.props.textDomain,
				parentTheme: this.props.parentTheme,
				minimumWP: this.props.minimumWP,
				javaScriptObject: this.props.javaScriptObject,
				pkgNameLowerCase: this.props.pkgNameLowerCase,
			}
		);
		
		this.fs.copyTpl(
			this.templatePath( './core/theme-support.php' ),
			this.destinationPath( './core/theme-support.php' ), {
				pkgName: this.props.pkgName,
			}
		);
		
		this.fs.copyTpl(
			this.templatePath( './build/sass/main.scss' ),
			this.destinationPath( './build/sass/main.scss' ), {
				themeName: this.props.themeName,
				themeURI: this.props.themeURI,
				themeDescription: this.props.themeDescription,
				textDomain: this.props.textDomain,
				parentTheme: this.props.parentTheme,
				author: this.props.author,
				authorURI: this.props.authorURI,
				contributors: this.props.contributors,
			}
		);

		this.fs.copyTpl(
			this.templatePath( './package.json' ),
			this.destinationPath( './package.json' ), {
				pkgName: this.props.pkgName,
			}
		);

		this.fs.copyTpl(
			this.templatePath( './bower.json' ),
			this.destinationPath( './bower.json' ), {
				pkgName: this.props.pkgName,
			}
		);

		// If gitHubURL is provided, add to our JSON files, re-run EJS, and overwrite the file in the queue
		if ( this.props.gitHubURL !== '' ) {

			this.fs.extendJSON(
				this.destinationPath( './package.json' ),
				{
					"repository": {
						"type": "git",
						"url": "<%- gitHubURL -%>.git"
					},
					"bugs": {
						"url": "<%- gitHubURL -%>/issues"
					}
				},
				null,
				'\t'
			);

			var packageJson = ejs.render(
				this.fs.read( this.destinationPath( './package.json' ) ),
				{
					gitHubURL: this.props.gitHubURL,
				},
				extend( 
					{
						filename: this.destinationPath( './package.json' ),
					},
					{}
				)
			);

			this.fs.write( this.destinationPath( './package.json' ), packageJson );

			this.fs.extendJSON(
				this.destinationPath( './bower.json' ),
				{
					"repository": {
						"type": "git",
						"url": "<%- gitHubURL -%>.git"
					}
				},
				null,
				'\t'
			);

			var bowerJson = ejs.render(
				this.fs.read( this.destinationPath( './bower.json' ) ),
				{
					gitHubURL: this.props.gitHubURL,
				},
				extend( 
					{
						filename: this.destinationPath( './bower.json' ),
					},
					{}
				)
			);

			this.fs.write( this.destinationPath( './bower.json' ), bowerJson );

		}

	}
	
	done() {
		
		console.log( 'Done!' );
		console.log( 'Run `npm install` and `gulp` in order to build the `style.css` file!' );
		
	}

};