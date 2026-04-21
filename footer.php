<footer class="site-footer">
        <div class="container footer-container">
            <div class="footer-logo">
                <!-- Logo with white background for footer contrast if needed -->
                <img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/SUC-logo.png' ) ); ?>" alt="Southern Utah Cabinetry Logo">
            </div>
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p>Phone: <a href="tel:4354291309"><?php echo esc_html( get_theme_mod( 'suc_phone', '(435) 429-1309' ) ); ?></a></p>
                <p>Email: <a href="mailto:<?php echo esc_attr( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?></a></p>
            </div>
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms & Conditions</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_Brochure_v4_No-Fold-Lines.pdf' ) ); ?>" target="_blank">Download Brochure</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_SpecBook_v5.pdf' ) ); ?>" target="_blank">Download SpecBook</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Southern Utah Cabinetry. All rights reserved.</p>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>