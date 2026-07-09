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
            spacing: {
                '0.5': 'var(--space-0-5)',
                '1': 'var(--space-1)',
                '1.5': 'var(--space-1-5)',
                '2': 'var(--space-2)',
                '3': 'var(--space-3)',
                '4': 'var(--space-4)',
                '6': 'var(--space-6)',
                '8': 'var(--space-8)',
            },
            fontFamily: {
                inter: ['Inter', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
        },
    },
    plugins: [],
};
