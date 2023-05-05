"use strict";

import config from './config';
import path from 'path';
import { watch as gulpWatch, series, parallel } from 'gulp';
import scripts from './tasks/scripts';
import styles from './tasks/styles';
import images from './tasks/images';
import clean from './tasks/clean';
import rev from './tasks/rev';
import bundle from './tasks/bundle';

export { scripts };

export { styles };

export { clean };

export const assets = series(
    clean,
    parallel(scripts, styles, images)
);

export const build = series(
    clean,
    parallel(scripts, styles, images),
    rev,
    bundle
)

export { bundle }

export function watch () {
    assets();

    gulpWatch([
        path.posix.join(config.paths.src.css, '/**/*.scss'),
        path.posix.join(config.paths.components, '/**/*.{scss,css}')
    ],
    styles);

    gulpWatch([
        path.posix.join(config.paths.src.js, '/**/*.js'),
        path.posix.join(config.paths.components, '/**/*.js')
    ],
    scripts);

    gulpWatch(config.paths.src.images, images);
}

export default build;