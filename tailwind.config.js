export default {
    content: ['./resources/**/*.blade.php', './resources/**/*.js'],
    theme: {
        extend: {
            colors: {
                ink: '#000000',
                paper: '#ffffff',
                muted: '#777777',
            },
            letterSpacing: {
                nothing: '0.05em',
                wider: '0.15em',
            },
            transitionTimingFunction: {
                nothing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            },
        },
    },
    plugins: [],
};
