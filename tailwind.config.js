/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/livewire/flux/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontSize: {
                'xs': '0.75rem',
                'sm': '0.875rem',
                'base': '1rem',
            },
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#fdf4f4',
                    100: '#fbeae9',
                    200: '#f2bfbc',
                    300: '#ea958f',
                    400: '#e26b62',
                    500: '#db4b40',
                    600: '#d52b1e',
                    700: '#b5251a',
                    800: '#951e15',
                    900: '#6b160f',
                },
            },
        },
    },
    plugins: [],
};
