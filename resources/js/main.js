import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function () {

    // Navbar dropdown on hover (desktop only)
    let hoverEnabled = window.innerWidth > 992;

    function onDropdownMouseover() {
        if (hoverEnabled) this.querySelector('.dropdown-toggle')?.click();
    }
    function onDropdownMouseout() {
        if (hoverEnabled) {
            const t = this.querySelector('.dropdown-toggle');
            if (t) { t.click(); t.blur(); }
        }
    }

    document.querySelectorAll('.navbar .dropdown').forEach(function (dd) {
        dd.addEventListener('mouseover', onDropdownMouseover);
        dd.addEventListener('mouseout', onDropdownMouseout);
    });

    window.addEventListener('resize', function () {
        hoverEnabled = window.innerWidth > 992;
    });

    // Main news carousel — 1 slide
    document.querySelectorAll('.carousel-item-1').forEach(function (el) {
        new Swiper(el, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            rewind: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
        });
    });

    // Category carousels — 1 on mobile, 2 on tablet+
    document.querySelectorAll('.carousel-item-2').forEach(function (el) {
        new Swiper(el, {
            modules: [Navigation, Autoplay],
            spaceBetween: 30,
            rewind: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                0:   { slidesPerView: 1 },
                768: { slidesPerView: 2 },
            },
        });
    });

    // Top news carousel — 1 → 2 → 3 items
    document.querySelectorAll('.carousel-item-3').forEach(function (el) {
        new Swiper(el, {
            modules: [Navigation, Autoplay],
            spaceBetween: 30,
            rewind: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                0:   { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
            },
        });
    });

    // Featured news carousel — 1 → 2 → 3 → 4 items
    document.querySelectorAll('.carousel-item-4').forEach(function (el) {
        new Swiper(el, {
            modules: [Navigation, Autoplay],
            spaceBetween: 30,
            rewind: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            navigation: {
                nextEl: el.querySelector('.swiper-button-next'),
                prevEl: el.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                0:    { slidesPerView: 1 },
                768:  { slidesPerView: 2 },
                992:  { slidesPerView: 3 },
                1200: { slidesPerView: 4 },
            },
        });
    });

});
