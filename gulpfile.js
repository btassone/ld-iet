// Gulpfile for javascript tasks and watchers
var gulp = require('gulp');
var sass = require('gulp-sass');
var ts = require('gulp-typescript');
var tslint = require('gulp-tslint');

gulp.task('styles', function(){
    gulp.src('./resources/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./resources/css/'));
});

gulp.task('typescript', function(){
    gulp.src('./resources/typescript/**/*.ts')
        .pipe(ts({
            noImplicitAny: true,
            out: 'main.js',
            target: 'ES5',
            experimentalDecorators: true
        }))
        .pipe(gulp.dest('./resources/js'));
});

gulp.task('default',function() {
    gulp.watch('./resources/scss/**/*.scss',function(){
        gulp.start('styles');
    });

    gulp.watch('./resources/typescript/**/*.ts', function(){
        gulp.start('typescript');
    });
});