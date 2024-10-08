import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
               
              
                'resources/css/style.css',
                'resources/css/admin-style.css',
                'resources/css/admin-style.css',
                'resources/css/dashboard.css',
                'resources/css/welcome.css',
                'resources/css/user.css',
                'resources/css/footer.css',
                'resources/css/pending-news.css',
                'resources/css/published-news.css',
                'resources/css/draft.css',
                'resources/css/postnews-admin-index.css',
                'resources/css/share-interation.css',
                'resources/css/top-news.css',
                'resources/css/featured-news.css',
                'resources/css/trending-news.css',
                'resources/css/popular-news.css',
                'resources/css/carousel-news.css',
                'resources/css/catpost-news.css',
                'resources/css/cookies.css',


                
                'resources/js/main.js',
                'resources/js/calendar.js',
                'resources/js/admin-main.js',
                'resources/js/todo-list.js',
                
            ],
            refresh: true,
            
        }),
    ],
});