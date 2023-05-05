import dotenv from 'dotenv';

dotenv.config();

export const config = {
    mode: process.env.THEME_ENV || 'production',
    env: {
        dev: {
            url: process.env.DEV_URL
        }
    },
    paths: {
        components: './components',
        src: {
            base: './assets',
            css: './assets/sass',
            js: './assets/js',
            images: './assets/images'
        },
        dest: {
            base: './dist',
            css: './dist/css',
            js: './dist/js',
            images: './dist/images'
        },
        bundle: './bundled'
    }
}

export default config;