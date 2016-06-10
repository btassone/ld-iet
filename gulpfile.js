// Gulpfile for javascript tasks and watchers
var gulp = require('gulp');
var sass = require('gulp-sass');
var typescript = require('gulp-tsc');
var jasmine = require('gulp-jasmine');
var runSequence = require('run-sequence');

gulp.task('styles', function(){
    gulp.src('./resources/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./resources/css/'));
});

gulp.task('typescript', function(){
    gulp.src('./resources/typescript/**/*.ts')
        .pipe(typescript({
            target: 'ES5'
        }))
        .pipe(gulp.dest('./resources/js/dev'));
});

gulp.task('typescript-build', function(){
    gulp.src('./resources/typescript/**/*.ts')
        .pipe(typescript({
            target: 'ES5',
            out: 'Main1.js'
        }))
        .pipe(gulp.dest('./resources/js'));
});

gulp.task('jasmine', function(){
    gulp.src('./resources/js/tests/**/*Test.js')
        .pipe(jasmine());
});

// Default Dev Watchers
gulp.task('default',function() {
    gulp.watch('./resources/scss/**/*.scss',function(){
        gulp.start('styles');
    });

    gulp.watch('./resources/typescript/**/*.ts', function(){
        gulp.start('typescript');
    });
});

// Build for plugin (Import only this Main.js file
gulp.task('build', function() {
    runSequence('styles', 'typescript-build');
});

// Run Tests
gulp.task('test', function(){
    runSequence('typescript', 'jasmine');
});