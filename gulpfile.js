var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

var sassPaths = [
  'vendor/zurb/foundation',
  'vendor/fortawesome/font-awesome'
];

gulp.task('compile:sass', function() {
  return gulp.src('src/assets/stylesheets/main.scss')
    .pipe($.sass({
      includePaths: sassPaths
    })
    .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('web/assets/stylesheets'));
});

gulp.task('copy:fonts', function () {
  return gulp.src('vendor/fortawesome/font-awesome/fonts/fontawesome-webfont.*')
    .pipe(gulp.dest('web/assets/fonts'));
});

gulp.task('copy:js', function () {
  return gulp.src([
    'node_modules/jquery/dist/jquery.min.js',
    'vendor/zurb/foundation/dist/foundation.min.js',
    'src/assets/javascripts/**/*.js'
  ]).pipe(gulp.dest('web/assets/javascripts'));
});

gulp.task('default', ['compile:sass', 'copy:fonts', 'copy:js'], function() {
  gulp.watch(['src/assets/stylesheets/**/*.scss'], ['compile:sass']);
  gulp.watch(['src/assets/javascripts/**/*.js'], ['copy:js']);
});
