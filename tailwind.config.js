module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/js/**/*.{js,jsx,ts,tsx}',
        './resources/js/components/**/*.{js,jsx,ts,tsx}',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                t: {
                    primary: 'hsl(var(--color-t-primary) / <alpha-value>)',
                    secondary: 'hsl(var(--color-t-secondary) / <alpha-value>)',
                    tertiary: 'hsl(var(--color-t-tertiary) / <alpha-value>)',
                    quaternary:
                        'hsl(var(--color-t-quaternary) / <alpha-value>)',
                    quinary: 'hsl(var(--color-t-quinary) / <alpha-value>)',
                    senary: 'hsl(var(--color-t-senary) / <alpha-value>)',
                },
            },
        },
    },
    plugins: [],
};
