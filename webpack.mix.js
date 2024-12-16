const mix = require('laravel-mix');

mix.js([
    'assets/js/header/menu.js',
    'assets/js/header/mobile-menu.js',
    'assets/js/header/search-newsletter-switch.js',
], 'js/header.js');

mix.js([
    'assets/js/global/search.js',
], 'js/global.js');

mix.js([
    'assets/js/content-event/agenda.js',
    'assets/js/content-event/share.js',
    'assets/js/content-event/register.js',
    'assets/js/content-event/sponsor-logos.js',
], 'js/content-event.js');

mix.js([
    'assets/js/content-blog/share.js',
], 'js/content-blog.js');

mix.js([
    'assets/js/content-video/share.js',
], 'js/content-video.js');

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