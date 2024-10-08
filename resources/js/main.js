(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Tranding carousel
    $(".tranding-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        items: 1,
        dots: false,
        loop: false,
        nav : true,
        rewind: true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true" aria-label="Previous slide"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true" aria-label="Next slide"></i>'
        ]
    });


    // Carousel item 1
    $(".carousel-item-1").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: false,
        rewind: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true" aria-label="Previous slide"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true" aria-label="Next slide"></i>'
        ]
    });

    // Carousel item 2
    $(".carousel-item-2").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: false,
        rewind: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true" aria-label="Previous slide"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true" aria-label="Next slide"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            }
        }
    });


    // Carousel item 3
    $(".carousel-item-3").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: false,
        rewind: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true" aria-label="Previous slide"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true" aria-label="Next slide"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    

    // Carousel item 4
    $(".carousel-item-4").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: false,
        rewind: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true" aria-label="Previous slide"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true" aria-label="Next slide"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });
    
})(jQuery);


$(document).ready(function(){
    $('#newsCarousel').carousel({
        interval: 2000 // Set the speed of the carousel
    });
});

 
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 1,
        navText: [
            '<span class="owl-prev" aria-label="Previous slide">&lt;</span>', 
            '<span class="owl-next" aria-label="Next slide">&gt;</span>'
        ]
    });
});



        

