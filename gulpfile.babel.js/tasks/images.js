"use strict";

import { src, dest, lastRun } from 'gulp';
import path from 'path';
import config from '../config';
import imagemin from 'gulp-imagemin';

export function images () {
    return src(
            [path.join(config.paths.src.images, '/**/*')],
            { base: config.paths.src.images, since: lastRun(images) }
        )
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.mozjpeg({quality: 75, progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: false},
                    {cleanupIDs: false}
                ]
            })
        ])
        .pipe(dest(config.paths.dest.images))
    );
}

export default images;