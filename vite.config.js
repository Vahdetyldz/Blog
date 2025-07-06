import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/createArticle.jsx',
                'resources/js/adminDashboard.jsx',
                'resources/js/main.jsx',
                'resources/js/myBlogs.jsx',
                'resources/js/login.jsx',
                'resources/js/register.jsx',
                'resources/js/createArticleUser.jsx',
                'resources/js/edit.jsx',
                'resources/js/content.jsx',
                'resources/js/categoryPanel.jsx',
                'resources/js/allBlogs.jsx',
                'resources/js/users.jsx',
                'resources/js/comments.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
});
