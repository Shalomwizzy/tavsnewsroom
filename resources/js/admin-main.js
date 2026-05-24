// ── Theme management ────────────────────────────────────────────────────────
function applyAdminTheme(theme) {
    document.documentElement.setAttribute('data-admin-theme', theme);
    localStorage.setItem('adminTheme', theme);

    var btn = document.getElementById('adminThemeToggle');
    if (btn) {
        if (theme === 'dark') {
            btn.innerHTML = '<i class="fa fa-sun"></i>';
            btn.title = 'Switch to Light Mode';
        } else {
            btn.innerHTML = '<i class="fa fa-moon"></i>';
            btn.title = 'Switch to Dark Mode';
        }
    }

    if (typeof Chart !== 'undefined') {
        Chart.defaults.color      = theme === 'dark' ? '#6C7293' : '#555555';
        Chart.defaults.borderColor = theme === 'dark' ? '#000000' : '#e5e7eb';
    }
}

// Sync icon immediately (theme attribute already set by anti-FOUC script)
applyAdminTheme(localStorage.getItem('adminTheme') || 'dark');

$(document).ready(function(){
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

    // Sidebar Toggler with mobile overlay
    if (!$('.sidebar-overlay').length) {
        $('body').append('<div class="sidebar-overlay"></div>');
    }

    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass('open');
        if ($(window).width() < 992) {
            $('.sidebar-overlay').toggleClass('show');
        }
        return false;
    });

    $(document).on('click', '.sidebar-overlay', function () {
        $('.sidebar, .content').removeClass('open');
        $(this).removeClass('show');
    });

    // Theme Toggle
    $(document).on('click', '#adminThemeToggle', function () {
        var current = document.documentElement.getAttribute('data-admin-theme');
        applyAdminTheme(current === 'dark' ? 'light' : 'dark');
    });

    // Calendar
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });

    // Chart Global Color
    var savedTheme = localStorage.getItem('adminTheme') || 'dark';
    Chart.defaults.color      = savedTheme === 'dark' ? '#6C7293' : '#555555';
    Chart.defaults.borderColor = savedTheme === 'dark' ? '#000000' : '#e5e7eb';
});
