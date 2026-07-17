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
            colors: {
                sgih: {
                    deepblue: '#0A3A8A',
                    royalblue: '#1565D8',
                    cyan: '#18D4CF',
                    light: '#F7FAFD',
                }
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(10, 58, 138, 0.05)',
                'soft-lg': '0 10px 30px -5px rgba(10, 58, 138, 0.08)',
                'glow': '0 0 15px rgba(24, 212, 207, 0.3)',
            }
        },
    },

    plugins: [forms],
};
