"use strict";

import { src, dest } from 'gulp';
import path from 'path';
import config from '../config'
import flatten from 'gulp-flatten';
import gulpSass from 'gulp-sass';
import compiler from 'sass';
import postcss from 'gulp-postcss';
import postcssPresetEnv from 'postcss-preset-env';
import cssnano from 'cssnano';


const sass = gulpSass(compiler);

const postcssPlugins = [
    postcssPresetEnv({
        browsers: 'last 2 versions',
        autoprefixer: false
    }),
    cssnano({
        preset: [
            "advanced",
            {
                reduceIdents: {
                    keyframes: false
                },
				zindex: false,
            }
        ],
    })
]

export function styles() {
    return src(path.join(config.paths.components, '/**/*.{css,scss}'))
        .pipe(flatten())
        .pipe(src([
            path.join(config.paths.src.css, '/*.scss'),
            path.join(config.paths.src.css, '/flex/*.scss'),
        ], { base: config.paths.src.css }))
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss(postcssPlugins))
        .pipe(dest(config.paths.dest.css)
    );
}

export default styles;