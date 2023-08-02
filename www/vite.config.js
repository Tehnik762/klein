import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        //minify: false, // Отключение сжатия кода
        //terserOptions: {
        //  compress: false, // Отключение обфускации кода
        //},
        //rollupOptions: {
      
          //  external: [
              // другие внешние модули
            //  'spotlight',
            //],
          //},
    },
});
