const mix = require('laravel-mix');

mix.js([
    'assets/js/header/mobile-menu.js',
    'assets/js/header/search-newsletter-switch.js',
], 'js/header.js');

mix.sass('assets/css/app.scss', 'css/app.css')
    .options({
        processCssUrls: false
    });

mix.setPublicPath('dist');

mix.options({
    postCss: [
        require('autoprefixer')({
            overrideBrowserslist: ['last 3 versions'],
            cascade: false
        })
    ]
});

mix.disableNotifications();