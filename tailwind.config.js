import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-text': '#0F172A', // slate-900
                'brand-focus': '#4F46E5', // indigo-600 (primary focal)
                'brand-alt': '#2563EB', // blue-600 alternative
                'success': '#059669', // emerald-600
                'bg-50': '#F8FAFC',
                'bg-100': '#F1F5F9'
            },
            boxShadow: {
                'soft-lg': '0 8px 30px rgba(11, 86, 213, 0.06)',
            },
            transitionDuration: {
                200: '200ms'
            }
        },
    },

    plugins: [forms],
};
