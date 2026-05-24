<?php

return [

    /*
     * Each key is a permission slug stored in users.permissions (JSON array).
     * 'routes' is a list of route-name prefixes that belong to this section.
     * Writers without a section in their permissions array cannot access those routes.
     */

    'sections' => [

        'post_news' => [
            'label'  => 'Post News',
            'icon'   => 'fa-newspaper',
            'routes' => [
                'post-news.',
                'admin.post-news.',
                'admin.published-news',
                'admin.pending-news',
                'admin.draft-news',
                'post-news.scheduled',
            ],
        ],

        'categories' => [
            'label'  => 'Categories',
            'icon'   => 'fa-list',
            'routes' => ['categories.'],
        ],

        'comments' => [
            'label'  => 'Comments',
            'icon'   => 'fa-comments',
            'routes' => ['admin.comments.'],
        ],

        'analytics' => [
            'label'  => 'Analytics & SEO',
            'icon'   => 'fa-chart-bar',
            'routes' => ['share-interactions.', 'seo.', 'admin.top-articles'],
        ],

        'home_fixtures' => [
            'label'  => 'Home Fixtures',
            'icon'   => 'fa-house',
            'routes' => [
                'admin.trending-news.',
                'admin.top-news',
                'categories.select_homepage',
                'admin.carousel.',
                'admin.featured_news.',
                'admin.categoryPostNews.',
                'admin.popular_news.',
                'admin.latest_news.',
                'admin.navbar-items.',
                'admin.social_follows.',
                'tags.',
            ],
        ],

        'messages' => [
            'label'  => 'Messages',
            'icon'   => 'fa-message',
            'routes' => ['messages.', 'contact.'],
        ],

        'mail' => [
            'label'  => 'Mail & Subscribers',
            'icon'   => 'fa-envelope',
            'routes' => ['admin.subscribers.', 'admin.email-settings'],
        ],

        'announcements' => [
            'label'  => 'Announcements',
            'icon'   => 'fa-bullhorn',
            'routes' => ['announcements.'],
        ],

        'footer' => [
            'label'  => 'Footer Settings',
            'icon'   => 'fa-shoe-prints',
            'routes' => ['admin.footer_settings.', 'admin.quick_links.', 'admin.blog-settings.'],
        ],

        'management' => [
            'label'  => 'App Management',
            'icon'   => 'fa-gear',
            'routes' => [
                'admin.website-settings.',
                'admin.show.clear.cache',
                'admin.maintenance',
                'admin.env.',
            ],
        ],

    ],

];
