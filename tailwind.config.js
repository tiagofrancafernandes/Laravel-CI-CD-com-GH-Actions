const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

module.exports = {
    // prefix: 'tw-',
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/frontend/**/*.vue',
        './resources/prontostack/pronto-ui/**/*.vue',
        './node_modules/flowbite/**/*.js',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        ...['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
                primary: colors.violet,
                accent: colors.fuchsia,
                success: colors.green,
                info: colors.blue,
                warning: colors.amber,
                danger: colors.red,
                default: colors.slate
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans]
            }
        },
    },
}
