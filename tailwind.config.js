/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/*.{html,js,php}", "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
],
}

