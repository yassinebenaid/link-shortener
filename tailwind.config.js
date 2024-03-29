const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    darkMode: "class",
    theme: {
        container: {
            center: true,
        },
        extend: {
            colors: {
                dark: {
                    DEFAULT: "#264653",
                },
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ["active"],
        },
    },
    content: ["resources/js/**/*.vue", "resources/js/**/*.ts"],
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
