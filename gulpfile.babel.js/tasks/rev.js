"use strict";

import { src, dest } from 'gulp';
import path from 'path';
import config from '../config'
import rev from 'gulp-rev';
import del from 'gulp-rev-delete-original';

export function assetRev() {
    return src(
            [
                path.join(config.paths.dest.css, '**/*.css'),
                path.join(config.paths.dest.js, '**/*.js')
            ],
            { base: config.paths.dest.base }
        )
        .pipe(rev())
        .pipe(del())
        .pipe(dest(config.paths.dest.base))
        .pipe(rev.manifest())
        .pipe(dest('./'))
    ;
}

export default assetRev;