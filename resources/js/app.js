import './bootstrap';
 // BACK TO TOP 

   // Get the button
   document.addEventListener('DOMContentLoaded', function () {
    var mybutton = document.getElementById("backToTopBtn");

    function handleScroll() {
        var scrollY = window.scrollY || document.documentElement.scrollTop;

        if (scrollY > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    window.addEventListener('scroll', handleScroll);

    mybutton.addEventListener("click", function () {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    });

    // Trigger the handleScroll function once to handle initial state
    handleScroll();
});