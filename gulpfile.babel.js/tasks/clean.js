"use strict";

import del from 'del';
import config from '../config';

export function clean () {
    return del(config.paths.dest.base)
        .then(del(config.paths.bundle));
}

export default clean;