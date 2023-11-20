module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#662483',
            },
            fontFamily: {
                sans: ["'PT Sans'", 'sans-serif'],
                serif: ["'PT Serif'", 'serif'],
            },
            backgroundImage: theme => ({
                'rabbisacks': "url('/profile.png')"
            })
        },
    },
    plugins: [],
};
