"use strict";

import {src, dest} from 'gulp';
import config from '../config';

export function bundle() {
    return src([
		'**/*',
		'!node_modules{,/**}',
		'!vendor{,/**}',
		'!src{,/**}',
		'!.babelrc',
		'!.gitignore',
		'!package.json',
		'!package-lock.json',
		'!composer.json',
		'!composer.lock',
		'!untitled.php',
        '!gulpfile*',
		'!sandbox.php',
		'!sandbox.scss',
		'!*.html',
    ])
    .pipe(dest(config.paths.bundle));
}

export default bundle;