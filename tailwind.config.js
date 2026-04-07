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
            fontFamily: {
                sans: ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    500: '#6366f1',
                    600: '#4f46e5', // Indigo
                    700: '#4338ca',
                    800: '#3730a3',
                },
                accent: {
                    50: '#f5f3ff',
                    100: '#ede9fe',
                    500: '#8b5cf6', 
                    600: '#7c3aed', // Violet
                    700: '#6d28d9',
                }
            }
        },
    },

    plugins: [forms],
};
