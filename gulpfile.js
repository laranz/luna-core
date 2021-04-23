/**
 * Gulp file for development.
 *
 * @package Luna_Core
 */

// Load Gulp...of course.
const { src, dest, task, watch, series, parallel } = require( 'gulp' );

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
let sourcemaps = require( 'gulp-sourcemaps' );
let plumber    = require( 'gulp-plumber' );
let options    = require( 'gulp-options' );
let gulpif     = require( 'gulp-if' );
let log        = require( 'fancy-log' );

// Browsers related plugins.
let browserSync = require( 'browser-sync' ).create();

// Path Variables.
const paths = {
	"proxy":{
		"url": "https://www.learn.site/wp-admin/admin.php?page=luna_settings"
	},
	"styles": {
		"src": ["./src/scss/**/*.scss"],
		"dest": "./assets/css/"
	},
	"scripts": {
		"files": ["script.js"],
		"src": ["./src/js/"],
		"dest": "./assets/js/",
	},
	"images": {
		"src": "./src/images/**/*",
		"dest": "./assets/images/"
	},
	"php": {
		"src": "./**/*.php"
	},
	"sourceMapURL": {
		"dest": "./"
	},
	"fonts": {
		"src": "./src/fonts/**/*",
		"dest": "./assets/fonts/"
	},
};

// Browser-sync Task for auto refresh.
function browser_sync() {
	browserSync.init(
		{
			proxy: paths.proxy.url,
			files: './assets/',
			online: false
		}
	);
}

function reload(done) {
	browserSync.reload();
	done();
}

function css(done) {
	src( paths.styles.src )
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
	.pipe( sourcemaps.write( '.' ) )
	.pipe( dest( paths.styles.dest ) )
	.pipe( browserSync.stream() );
	done();
}

function js(done) {
	paths.scripts.files.map(
		function( entry ) {
			return browserify(
				{
					entries: [paths.scripts.src + entry]
				}
			)
			.transform( babelify, { presets: [ '@babel/preset-env' ] } )
			.bundle()
			.pipe( source( entry ) )
			.pipe( buffer() )
			.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
			.pipe( sourcemaps.init( { loadMaps: true } ) )
			.pipe( uglify() )
			.pipe( sourcemaps.write( '.' ) )
			.pipe( dest( paths.scripts.dest ) )
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
	return triggerPlumber( paths.images.src, paths.images.dest );
}

function fonts() {
	return triggerPlumber( paths.fonts.src, paths.fonts.dest );
}

function watch_files() {
	watch( paths.styles.src, series( css, reload ) );
	watch( paths.scripts.src, series( js, reload ) );
	watch( paths.images.src, series( images, reload ) );
	watch( paths.fonts.src, series( fonts, reload ) );
	watch( paths.php.src, series( reload ) );
	log.info( "I am watching for you, Happy Coding!" );
}

task( "css", css );
task( "js", js );
task( "images", images );
task( "fonts", fonts );
// Create CSS, JS, images  & fonts for production.
task( "create", parallel( css, js, images, fonts ) );
// Create, watch and auto-refresh files for dev.
task( "default", parallel( browser_sync, "create", watch_files ) );
