import preset from './vendor/tallstackui/tallstackui/tailwind.preset.js';
import forms from '@tailwindcss/forms';

export default {
  darkMode: false,
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './app/Livewire/**/*.php',
    './vendor/tallstackui/**/*.blade.php', // needed for TSUI components
  ],
  theme: {
    extend: {

    },
  },
  plugins: [forms],
  presets: [preset],
};
