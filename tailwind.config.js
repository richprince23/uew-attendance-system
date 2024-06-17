/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
  theme: {
    extend: {
        backgroundImage: {
            'auth_bg': "url('/images/auth_bg.jpg')"
        }
    },
  },
  plugins: [],
}

