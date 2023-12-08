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
                secondary: '#2b1138',
            },
            fontFamily: {
                sans: ["'PT Sans'", 'sans-serif'],
                serif: ["'PT Serif'", 'serif'],
            },
            backgroundImage: {
                'rabbisacks': "url('/profile.jpg')"
            }
        },
    },
    plugins: [],
};
