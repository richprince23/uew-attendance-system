/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
  theme: {
    extend: {
        screens:{
            'tb': '640px',
            'md': '992px'
          },
        backgroundImage: {
            'auth_bg': "url('/images/auth_bg.jpg')"
        }
    },
  },
  plugins: [],
}

