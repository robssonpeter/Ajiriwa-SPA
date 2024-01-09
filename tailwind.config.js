const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
module.exports = {
    mode: 'jit',
    purge: [
        "./node_modules/flowbite/**/*.js", 
        './node_modules/tw-elements/dist/js/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            green: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
        }
    },
    /* corePlugins: {
        gray: colors.neutral,
    }, */
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('flowbite/plugin'), require('tw-elements/dist/plugin')],
    content: [
        "./node_modules/flowbite/**/*.js", './node_modules/tw-elements/dist/js/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ]
};
