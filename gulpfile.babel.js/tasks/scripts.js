import { src, dest } from 'gulp';
import path from 'path';
import config from '../config';
import webpack from 'webpack-stream';
import named from 'vinyl-named';

export function scripts () {
    return src([
            path.join(config.paths.src.js, '/*.js'),
            path.join(config.paths.components, '/**/*.js')
        ])
        .pipe(named())
        .pipe(webpack({
            mode: config.mode,
            output: {
                filename: '[name].js'
              },
            externals: {
                jquery: 'jQuery',
            },
        }))
        .pipe(dest(config.paths.dest.js));
}

export default scripts;