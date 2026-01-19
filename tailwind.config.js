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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '1.5rem',
                    lg: '2rem',
                },
            },
            colors: {
                brand: {
                    50: '#eef5ff',
                    100: '#d9e8ff',
                    200: '#b4d0ff',
                    300: '#86b2ff',
                    400: '#4f88ff',
                    500: '#2a63f1',
                    600: '#1c4ad7',
                    700: '#1739aa',
                    800: '#153486',
                    900: '#122c6a',
                },
            },
            boxShadow: {
                card: '0 12px 30px -12px rgba(15, 23, 42, 0.25)',
            },
            borderRadius: {
                xl: '1rem',
            },
        },
    },

    plugins: [forms],
};
