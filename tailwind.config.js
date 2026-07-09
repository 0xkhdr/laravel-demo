/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./resources/views/**/*.blade.php'],
    theme: {
        extend: {
            colors: {
                ink: 'var(--bg)',
                surface: 'var(--surface)',
                accent: 'var(--accent)',
            },
        },
    },
    plugins: [],
};
