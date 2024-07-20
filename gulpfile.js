import { gulpConfig } from './gulp-config.js'
import gulp from 'gulp';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import autoprefixer from 'gulp-autoprefixer';
import removeSourcemaps from 'gulp-remove-sourcemaps';
import gulpif from 'gulp-if';
import purgecss from 'gulp-purgecss';
import cleancss from 'gulp-clean-css';
import browserSync from 'browser-sync';
const bs = browserSync.create();


const configDefault = {
    browserSync: {
        siteURL: 'http://localhost'
    },
    purgeCSS: {
        enabled: false,
        settings: {
            content: [
                './!(node_modules)/**/*.php',
                './assets/js/**/*.js'
            ],
            safelist: [
                // Bootstrap
                /^carousel-item.*/,
                /collapsing/,
                /show/,
            ],
            keyframes: true,
            variables: false,
        }
    },
    css: {
        vendor: {
            src: 'assets/scss/vendor.scss',
            dest: 'assets/dist/css',
        },
        style: {
            src: 'assets/scss/style.scss',
            dest: 'assets/dist/css',
        }
    },
    js: {
        vendor: {
            src: [
                'node_modules/bootstrap/dist/js/bootstrap.min.js',
            ],
            dest: 'assets/dist/js'
        },
        scripts: {
            src: [
                'assets/js/components/*.js',
                'assets/js/*.js'
            ],
            dest: 'assets/dist/js'
        }
    }
};

const config = { ...configDefault, ...gulpConfig };


gulp.task('vendor-js', () => gulp.src(config.js.vendor.src)
    .pipe(concat('vendor.js'))
    .pipe(removeSourcemaps())
    .pipe(gulp.dest(config.js.vendor.dest))
);


gulp.task('vendor-scss', () => gulp.src(config.css.vendor.src)
    .pipe(sass({
        quietDeps: true
    }))
    .pipe(gulpif(config.purgeCSS.enabled, purgecss(config.purgeCSS.settings)))
    .pipe(cleancss())
    .pipe(gulp.dest(config.css.vendor.dest)));


gulp.task('js', () => gulp.src(config.js.scripts.src)
    .pipe(uglify())
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest(config.js.scripts.dest)));


gulp.task('scss', () => gulp.src(config.css.style.src)
    .pipe(sass({
        outputStyle: 'compressed',
        quietDeps: true
    }))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(gulp.dest(config.css.style.dest)));


gulp.task('bs-init', function (done) {
    bs.init({
        open: false,
        injectChanges: true,
        proxy: config.browserSync.siteURL
    });
    done();
});


gulp.task('bs-reload', function (done) {
    bs.reload();
    done();
});


gulp.task('watch', () => {
    gulp.watch('./assets/js/**/*.js', { usePolling: true }, gulp.parallel('js'));
    gulp.watch('./assets/scss/**/*.scss', { usePolling: true }, gulp.parallel('scss'));
});


gulp.task('watch-bs', () => {
    gulp.watch('./assets/js/**/*.js', { usePolling: true }, gulp.series('js', 'bs-reload'));
    gulp.watch('./assets/scss/**/*.scss', { usePolling: true }, gulp.series('scss', 'bs-reload'));
});


gulp.task('build', gulp.parallel('vendor-js', 'vendor-scss', 'js', 'scss'));
gulp.task('default', gulp.parallel('watch'));
gulp.task('bs', gulp.parallel('bs-init', 'watch-bs'));
