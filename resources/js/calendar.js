(function ($) {
    "use strict";

    // Tempus Dominus Initialization for Calendar
    $(function () {
        $('#calendar').datetimepicker({
            inline: true,
            format: 'L',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'far fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'far fa-times-circle'
            }
        });
    });

})(jQuery);