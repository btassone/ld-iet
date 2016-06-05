// Gulpfile for javascript tasks and watchers
var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('styles', function(){
    gulp.src('./resources/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./resources/css/'));
});

gulp.task('default',function() {
    gulp.watch('./resources/scss/**/*.scss',function(){
        gulp.start('styles');
    });
});