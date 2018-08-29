var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var pkg = require('./package.json');
var sass = require('gulp-sass');

// Copy third party libraries from /node_modules into /vendor
gulp.task('copy', function() {

  // jQuery
  gulp.src([
      './node_modules/jquery/dist/*',
      '!./node_modules/jquery/dist/core.js',
    ])
    .pipe(gulp.dest('../public/js/jquery'))

    // Bootstrap JS
    gulp.src([
        './node_modules/bootstrap/dist/js/*'
    ])
        .pipe(gulp.dest('../public/js/bootstrap'))

    // Theme JS
    gulp.src([
        './js/*'
    ])
        .pipe(gulp.dest('../public/js/modern-business'))

    // Font-awesome
    gulp.src([
        './node_modules/font-awesome/fonts/*'
    ])
        .pipe(gulp.dest('../public/fonts'))
})


// Compile modern-business
gulp.task('compile-theme', function () {
    return gulp.src(
        './scss/*.scss'
    )
        .pipe(sass.sync({
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(gulp.dest('../public/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

// Default task
gulp.task('default', ['copy', 'compile-theme']);

// Configure the browserSync task
gulp.task('browserSync', function() {
  browserSync.init({
    server: {
      baseDir: "./"
    }
  });
});

// Dev task
gulp.task('dev', ['browserSync'], function() {
  gulp.watch('./scss/*.scss', browserSync.reload);
  gulp.watch('./js/*.js', browserSync.reload);
  gulp.watch('../templates/*.twig', browserSync.reload);
});
