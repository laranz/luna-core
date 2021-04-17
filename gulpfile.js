/**
 * Gulp file for development.
 *
 * @package Luna_Core
 */

// Load Gulp...of course.
const { src, dest, task, watch, series, parallel } = require( 'gulp' );

// Assign the proxy URL for browserSync.
let proxy = 'https://www.learn.test/wp-admin/admin.php?page=luna_settings';

// Assign a files folder to watch for browserSync.
let filestowatch = './assets/';

// CSS related plugins.
let sass         = require( 'gulp-sass' );
let autoprefixer = require( 'gulp-autoprefixer' );

// JS related plugins.
let uglify     = require( 'gulp-uglify' );
let babelify   = require( 'babelify' );
let browserify = require( 'browserify' );
let source     = require( 'vinyl-source-stream' );
let buffer     = require( 'vinyl-buffer' );
let stripDebug = require( 'gulp-strip-debug' );

// Utility plugins.
let rename     = require( 'gulp-rename' );
let sourcemaps = require( 'gulp-sourcemaps' );
let notify     = require( 'gulp-notify' );
let plumber    = require( 'gulp-plumber' );
let options    = require( 'gulp-options' );
let gulpif     = require( 'gulp-if' );
let log        = require( 'fancy-log' );

// Browsers related plugins.
let browserSync = require( 'browser-sync' ).create();

// Project related variables.
let styleSRC = './src/scss/style.scss';
let styleURL = './assets/css/';
let mapURL   = './';

let jsSRC   = './src/js/';
let jsFront = 'script.js';
let jsFiles = [ jsFront ];
let jsURL   = './assets/js/';

let imgSRC = './src/images/**/*';
let imgURL = './assets/images/';

let fontsSRC = './src/fonts/**/*';
let fontsURL = './assets/fonts/';

let htmlSRC = './src/**/*.html';
let htmlURL = './assets/';

let styleWatch = './src/scss/**/*.scss';
let jsWatch    = './src/js/**/*.js';
let imgWatch   = './src/images/**/*.*';
let fontsWatch = './src/fonts/**/*.*';
let htmlWatch  = './src/**/*.html';
let phpWatch   = "./**/*.php";

// Tasks.
function browser_sync() {
	browserSync.init(
		{
			proxy: proxy,
			files: filestowatch,
			port: 1710,
			online: true
		}
	);
}

function reload(done) {
	browserSync.reload();
	done();
}

function css(done) {
	src( [ styleSRC ] )
	.pipe( sourcemaps.init() )
	.pipe(
		sass(
			{
				errLogToConsole: true,
				outputStyle: 'expanded'
			}
		)
	)
	.on( 'error', console.error.bind( console ) )
	.pipe( autoprefixer() )
	// .pipe( rename( { suffix: '.min' } ) )
	.pipe( sourcemaps.write( mapURL ) )
	.pipe( dest( styleURL ) )
	.pipe( browserSync.stream() );
	log( "CSS finished.!" );
	done();
}

function js(done) {
	jsFiles.map(
		function( entry ) {
			log.info( entry );
			return browserify(
				{
					entries: [jsSRC + entry]
				}
			)
			.transform( babelify, { presets: [ '@babel/preset-env' ] } )
			.bundle()
			.pipe( source( entry ) )
			// .pipe(
			// rename(
			// {
			// extname: '.min.js'
			// }
			// )
			// )
			.pipe( buffer() )
			.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
			.pipe( sourcemaps.init( { loadMaps: true } ) )
			.pipe( uglify() )
			.pipe( sourcemaps.write( '.' ) )
			.pipe( dest( jsURL ) )
			.pipe( browserSync.stream() );
		}
	);
	done();
}

function triggerPlumber( src_file, dest_file ) {
	return src( src_file )
		.pipe( plumber() )
		.pipe( dest( dest_file ) );
}

function images() {
	return triggerPlumber( imgSRC, imgURL );
}

function fonts() {
	return triggerPlumber( fontsSRC, fontsURL );
}

function html() {
	return triggerPlumber( htmlSRC, htmlURL );
}

function watch_files() {
	watch( styleWatch, series( css, reload ) );
	watch( jsWatch, series( js, reload ) );
	watch( imgWatch, series( images, reload ) );
	watch( fontsWatch, series( fonts, reload ) );
	watch( htmlWatch, series( html, reload ) );
	watch( phpWatch, series( reload ) );
	// src( jsURL + 'main.min.js', { allowEmpty: true } )
	// .pipe( notify( { message: 'Gulp is Watching, Happy Coding!' } ) );
	log( "Gulp is Watching, Happy Coding!" );
}

task( "css", css );
task( "js", js );
task( "images", images );
task( "fonts", fonts );
task( "html", html );
task( "default", parallel( css, js, images, fonts, html ) );
task( "watch", parallel( browser_sync, "default", watch_files ) );
