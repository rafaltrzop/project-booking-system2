var gulp = require('gulp');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'vendor/zurb/foundation'
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

gulp.task('default', ['sass'], function() {
  gulp.watch(['src/assets/stylesheets/**/*.scss'], ['sass']);
});
