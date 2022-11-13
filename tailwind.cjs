const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
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
            colors: {
                'custom-main-100': '#99c8bf',
                'custom-main-200': '#80bab0',
                'custom-main-300': '#66aca0',
                'custom-main-400': '#4d9e90',
                'custom-main-500': '#339180',
                'custom-main-600': '#1a8370',
                'custom-main-700': '#007560', // official color, other are tunes
                'custom-main-800': '#006956',
                'custom-main-900': '#005e4d'
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
