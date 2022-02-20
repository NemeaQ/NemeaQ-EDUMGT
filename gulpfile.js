/*
 * MIT License
 *
 * Copyright (c) 2022 NemeaQ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const php = require('gulp-connect-php');
const postcss = require('gulp-postcss');
var uglify = require('gulp-uglify');
var pipeline = require('readable-stream').pipeline;

require('dotenv').config({
    path: '.env'
});

const FAVICON_DATA_FILE = 'faviconData.json';
const PORT = 8080;

const SRC = {
    js: 'src/scripts/',
    css: 'src/styles/',
    fonts: 'src/fonts/',
    images: 'src/images/',
    favicon: 'src/favicon/favicon.svg',
};

const BUILD = {
    js: 'dist/js',
    css: 'dist',
    fonts: 'dist/fonts',
    images: 'dist/images',
    media: 'dist/media',
    favicon: 'src/images/favicons',
};

function browser_sync(cb) {
    php.server({
        port: PORT, keepalive: true, base: './'
    }, () => {
        browserSync.init({
            proxy: '127.0.0.1:' + PORT
        });
    });
    cb();
}

function fonts() {
    return gulp.src(`${SRC.fonts}**/*`)
        .pipe(gulp.dest(`${BUILD.fonts}`));
}

function images() {
    return gulp.src(`${SRC.images}**/*`)
        .pipe(gulp.dest(`${BUILD.images}`));
}

function scripts(cb) {
    return pipeline(
        gulp.src(`${SRC.js}*.js`),
        uglify(),
        gulp.dest('dist')
    );
}

function styles() {
    return gulp.src(`${SRC.css}{styles,print}.css`)
        .pipe(postcss([
            require('postcss-import'),
            require('postcss-color-hex-alpha'),
            require('autoprefixer'),
            require('postcss-csso'),
        ]))
        .pipe(gulp.dest(`${BUILD.css}`));
}

const build = gulp.parallel(fonts, images, scripts, styles);

// Build
exports.build = build;
exports.default = gulp.parallel(browser_sync, build);
