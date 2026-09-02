import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                "resources/css/app.css",

                // Main Application
                "resources/js/app.js",

                // Homepage
                "resources/js/home/admin.js",
                "resources/js/home/user.js",

                // Authentication
                "resources/js/auth/login.js",
                "resources/js/auth/captcha.js",

                // Skripsi
                "resources/js/skripsi/skripsi.js",
                "resources/js/skripsi/pdf-viewer.js",

                // Praktik Industri
                "resources/js/praktik-industri/pdf-viewer.js",
            ],

            refresh: true,
        }),

        tailwindcss(),
    ],

    server: {
        hmr: {
            host: "localhost",
        },
    },
});