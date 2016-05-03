var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'vendor/zurb/foundation',
  'vendor/fortawesome/font-awesome'
];

gulp.task('sass', function() {
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

gulp.task('fonts', function () {
  return gulp.src('vendor/fortawesome/font-awesome/fonts/fontawesome-webfont.*')
    .pipe(gulp.dest('web/assets/fonts'));
});

gulp.task('default', ['sass', 'fonts'], function() {
  gulp.watch(['src/assets/stylesheets/**/*.scss'], ['sass']);
});
