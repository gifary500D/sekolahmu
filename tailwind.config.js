/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Warna custom untuk sekolah
        primary: '#1E40AF',      // Biru gelap
        secondary: '#0EA5E9',    // Biru cerah
        accent: '#F59E0B',       // Oranye
        success: '#10B981',      // Hijau
        danger: '#EF4444',       // Merah
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}