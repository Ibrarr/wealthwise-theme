import Splide from '@splidejs/splide';
import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#sponsorLogosSlider', {
        type: 'loop',
        perPage: 4,
        drag   : 'free',
        focus  : 'center',
        autoplay: true,
        arrows: false,
        pagination: false,
        breakpoints: {
            768: {
                perPage: 3,
            },
        },
    }).mount();
});