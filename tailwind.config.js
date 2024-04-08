module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#6d2281',
                secondary: '#291238',
            },
            fontFamily: {
                sans: ["'Merriweather'", 'sans-serif'],
                serif: ["'Merriweather'", 'serif'],
            },
            backgroundImage: {
                'rabbisacks': "url('/profile.jpg')"
            }
        },
    },
    plugins: [],
};
