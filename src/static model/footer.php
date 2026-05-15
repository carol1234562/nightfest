<?php

?>
<style>

.main-footer {
    background-color: var(--negro-suave);
    border-top: 1px solid #222222;
    padding: 50px 5% 30px;
    text-align: center;
    color: #666;
    width: 100%;
    margin-top: 50px;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

.footer-socials {
    margin-bottom: 25px;
}

.footer-socials a {
    color: var(--oro-premium);
    font-size: 1.5rem;
    margin: 0 15px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.footer-socials a:hover {
    color: var(--white);
    transform: translateY(-3px);
    text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}

.footer-legal {
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.footer-legal a {
    color: #888;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-legal a:hover {
    color: var(--oro-premium);
}

.footer-legal .divider {
    margin: 0 10px;
    color: #333;
}

.copyright {
    font-size: 0.8rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #444;
    margin-top: 20px;
}
</style>


    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-socials">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
            <div class="footer-legal">
                <a href="#">Términos y Condiciones</a>
                <span class="divider">|</span>
                <a href="#">Ayuda</a>
            </div>
            <p class="copyright">© <?php echo date('Y'); ?> NightFest. Johan & Carolina.</p>
        </div>
    </footer>
