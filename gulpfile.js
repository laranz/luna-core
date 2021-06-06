/**
 * Gulp file for development.
 *
 * @package
 */

// Load Gulp...of course.
const { src, dest, task, watch, series, parallel } = require( 'gulp' );

// CSS related plugins.
const sass = require( 'gulp-sass' );
const autoprefixer = require( 'gulp-autoprefixer' );

// JS related plugins.
const uglify = require( 'gulp-uglify' );
const babelify = require( 'babelify' );
const browserify = require( 'browserify' );
const source = require( 'vinyl-source-stream' );
const buffer = require( 'vinyl-buffer' );
const stripDebug = require( 'gulp-strip-debug' );

// Utility plugins.
const sourcemaps = require( 'gulp-sourcemaps' );
const plumber = require( 'gulp-plumber' );
const options = require( 'gulp-options' );
const gulpif = require( 'gulp-if' );
const log = require( 'fancy-log' );

//Stylelint
const gulpStylelint = require( 'gulp-stylelint' );
const eslint = require( 'gulp-eslint' );

// Browsers related plugins.
const browserSync = require( 'browser-sync' ).create();

// Path Variables.
const paths = {
	proxy: {
		url: 'https://www.learn.site/wp-admin/admin.php?page=luna_settings',
	},
	styles: {
		src: [ './src/scss/**/*.scss' ],
		dest: './assets/css/',
	},
	scripts: {
		files: [ 'script.js' ],
		src: [ './src/js/' ],
		dest: './assets/js/',
	},
	images: {
		src: './src/images/**/*',
		dest: './assets/images/',
	},
	php: {
		src: './**/*.php',
	},
	sourceMapURL: {
		dest: './',
	},
	fonts: {
		src: './src/fonts/**/*',
		dest: './assets/fonts/',
	},
};

// Browser-sync Task for auto refresh.
function browserSyncInit() {
	browserSync.init( {
		proxy: paths.proxy.url,
		files: './assets/',
		online: false,
	} );
}

function reload( done ) {
	browserSync.reload();
	done();
}

function css( done ) {
	src( paths.styles.src )
		.pipe( sourcemaps.init() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'expanded',
			} )
		)
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulpStylelint( { fix: true, failAfterError: false } ) )
		.pipe( dest( paths.styles.dest ) )
		.pipe( browserSync.stream() );
	done();
}

// function lintscss( done ) {
// 	src( paths.styles.src )
// 		.pipe(
// 			gulpStylelint( {
// 				fix: true,
// 				failAfterError: false,
// 			} )
// 		)
// 		.pipe( dest( './src/scss' ) );
// 	done();
// }
//
// function lintjs( done ) {
// 	src( [ './src/js/**.js' ] )
// 		.pipe( eslint( { fix: true } ) )
// 		.pipe( eslint.format() )
// 		.pipe( eslint.failAfterError() )
// 		.pipe( dest( './src/js' ) );
// 	done();
// }
// task( 'lintscss', lintscss );
// task( 'lintjs', lintjs );

function js( done ) {
	paths.scripts.files.map( function ( entry ) {
		return browserify( {
			entries: [ paths.scripts.src + entry ],
		} )
			.transform( babelify, { presets: [ '@wordpress/default' ] } )
			.bundle()
			.pipe( source( entry ) )
			.pipe( buffer() )
			.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
			.pipe( sourcemaps.init( { loadMaps: true } ) )
			.pipe( uglify() )
			.pipe( sourcemaps.write( '.' ) )
			.pipe( dest( paths.scripts.dest ) )
			.pipe( browserSync.stream() );
	} );
	done();
}

function triggerPlumber( srcFile, destFile ) {
	return src( srcFile ).pipe( plumber() ).pipe( dest( destFile ) );
}

function images() {
	return triggerPlumber( paths.images.src, paths.images.dest );
}

function fonts() {
	return triggerPlumber( paths.fonts.src, paths.fonts.dest );
}

function watchFiles() {
	watch( paths.styles.src, series( css, reload ) );
	watch( paths.scripts.src, series( js, reload ) );
	watch( paths.images.src, series( images, reload ) );
	watch( paths.fonts.src, series( fonts, reload ) );
	watch( paths.php.src, series( reload ) );
	log.info( 'I am watching for you, Happy Coding!' );
}

task( 'css', css );
task( 'js', js );
task( 'images', images );
task( 'fonts', fonts );
// Create CSS, JS, images  & fonts for production.
task( 'create', parallel( css, js, images, fonts ) );
// Create, watch and auto-refresh files for dev.
task( 'default', parallel( browserSyncInit, 'create', watchFiles ) );
