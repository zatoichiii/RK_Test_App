const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');

async function getAutoprefixer() {
    const autoprefixer = await import('gulp-autoprefixer');
    return autoprefixer.default;
}

async function compileSCSS() {
    console.log('Compiling SCSS...');
    const autoprefixer = await getAutoprefixer();
    return src('src/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cleanCSS())
        .pipe(dest('dist'))
        .on('end', () => console.log('SCSS compiled.'));
}

function watchFiles() {
    console.log('Watching files...');
    watch('src/scss/**/*.scss', compileSCSS);
}

exports.default = series(compileSCSS, watchFiles);
