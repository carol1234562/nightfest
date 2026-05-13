$(document).ready(function() {

    // --- 1. LÓGICA DE COOKIES Y ACCESO ---
    function checkCookies() {
        if (localStorage.getItem('nightfest_cookies') === 'accepted') {
            $('#cookie-banner').hide();
            $('.auth-buttons').css('display', 'flex').hide().fadeIn();
            
            if (!sessionStorage.getItem('welcome_shown')) {
                $('#welcome-modal').css('display', 'flex').hide().fadeIn();
            }
        } else {
            $('.auth-buttons').hide();
            $('#cookie-banner').fadeIn();
        }
    }

    $('#accept-cookies').click(function() {
        localStorage.setItem('nightfest_cookies', 'accepted');
        checkCookies();
    });

    $('#close-welcome').click(function() {
        $('#welcome-modal').fadeOut();
        sessionStorage.setItem('welcome_shown', 'true');
    });

    // --- 2. EFECTOS HOVER OPTIMIZADOS ---
    // Limpiamos antes de añadir para evitar duplicados al recargar
    $('.club-card .hover-overlay').remove();
    $('.club-card').append('<div class="hover-overlay" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(212,175,55,0.2); display:flex; align-items:center; justify-content:center; pointer-events:none;"><span style="color:#fff; font-weight:bold; padding:10px 20px;"></span></div>');

    $('.club-card').hover(
        function() {
            $(this).find('.hover-overlay').stop().fadeIn(300);
            $(this).find('img').css('transform', 'scale(1.05)');
        },
        function() {
            $(this).find('.hover-overlay').stop().fadeOut(200);
            $(this).find('img').css('transform', 'scale(1)');
        }
    );

    // --- 3. CONFIGURACIÓN DE SLIDERS ---
    // Slider Galería
    $('.slider-galeria').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        dots: true,
        arrows: true,
        responsive: [
            { breakpoint: 1024, settings: { slidesToShow: 2 } },
            { breakpoint: 768, settings: { slidesToShow: 1 } }
        ]
    });

    // Slider Promotores
    $('.slider-promotores').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        dots: false,
        arrows: true,
        responsive: [
            { breakpoint: 992, settings: { slidesToShow: 2 } },
            { breakpoint: 768, settings: { slidesToShow: 1 } }
        ]
    });

    checkCookies();
});