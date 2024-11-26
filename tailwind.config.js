/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php", // Matches all PHP files in the root directory
    "./assets/**/*.css" // Matches all CSS files inside the assets folder
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

