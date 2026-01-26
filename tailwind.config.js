module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.jsx',
    './resources/**/*.ts',
    './resources/**/*.tsx',

    './app/**/*.php',
    './livewire/**/*.php',

    './vendor/filament/**/*.blade.php',
    './vendor/**/*.php',
  ],

  safelist: [
    {
      pattern: /(bg|text|border|ring)-(red|green|blue|yellow|orange|amber|purple|pink|indigo|teal|cyan|lime|emerald|gray|slate|zinc|neutral|stone)-(50|100|200|300|400|500|600|700|800|900)/,
    },
    {
      pattern: /(bg|text|border|ring)-(success|warning|error|info)-(100|200|300|400|500|600|700)/,
    },
    {
      pattern: /(bg|text|border|ring)-(red|green|blue|yellow|orange|amber|purple|pink|indigo|teal|cyan|lime|emerald|gray|slate|zinc|neutral|stone)-(100|200|300|400|500|600|700)\/(10|20|30|40|50|60|70|80|90)/,
    },
  ],

  darkMode: 'class',

  theme: {
    extend: {
      colors: {
        t: {
          primary: 'hsl(var(--color-t-primary) / <alpha-value>)',
          secondary: 'hsl(var(--color-t-secondary) / <alpha-value>)',
          tertiary: 'hsl(var(--color-t-tertiary) / <alpha-value>)',
          quaternary: 'hsl(var(--color-t-quaternary) / <alpha-value>)',
          quinary: 'hsl(var(--color-t-quinary) / <alpha-value>)',
          senary: 'hsl(var(--color-t-senary) / <alpha-value>)',
        },
      },
    },
  },

  plugins: [],
};
