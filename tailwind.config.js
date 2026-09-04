import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'sqr-bg':          '#f0f8d3',
                'sqr-green':       '#2d4a22',
                'sqr-orange':      '#e67e22',
                'sqr-light-green': '#a3c585',
                'sqr-dark':        '#1c3115',
            },
            fontFamily: {
                'sans':       ['Poppins', 'Inter', ...defaultTheme.fontFamily.sans],
                'montserrat': ['Montserrat', 'sans-serif'],
                'poppins':    ['Poppins', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
