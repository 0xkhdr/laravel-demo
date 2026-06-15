/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        display: ['"Space Mono"', '"JetBrains Mono"', 'monospace'],
        body: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'monospace'],
      },
      colors: {
        nothing: {
          black: '#000000',
          white: '#FFFFFF',
          red: '#FF3B30',
          gray: {
            50: '#F5F5F5',
            100: '#EEEEEE',
            200: '#DDDDDD',
            300: '#CCCCCC',
            400: '#999999',
            500: '#666666',
            600: '#444444',
            700: '#333333',
            800: '#222222',
            900: '#111111',
          }
        }
      },
      spacing: {
        '18': '4.5rem',
        '22': '5.5rem',
        '30': '7.5rem',
      },
      letterSpacing: {
        'nothing': '0.05em',
        'nothing-wide': '0.1em',
        'nothing-wider': '0.15em',
      },
      transitionTimingFunction: {
        'nothing': 'cubic-bezier(0.25, 0.1, 0.25, 1)',
      },
    },
  },
  plugins: [],
}
