/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.{html,php}",
        "./templates/*.{html, php}",
        "./**/*.{js,ts,jsx,tsx,php}",
        "./**/*.{html,php}",    
        "./admin/*.{html,php}",
    ],
    theme: {
        extend: {
            colors: {
                "light-gray": "#28292b",
                'lighter-gray': '#777777',
            },
        },
    },
    plugins: [],
};
