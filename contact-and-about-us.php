<?php
/* Template Name: Contact and About Us */
get_header();
?>
<main class="site-main container">
    <div class="two-column-layout">
        <section class="about-us">
            <h1>About Southern Utah Cabinetry</h1>
            <?php
            $family_photo = get_theme_mod('suc_family_photo_link');
            if ( $family_photo ) : ?>
                <div class="family-photo" style="margin-bottom: 20px;">
                    <img src="<?php echo esc_url($family_photo); ?>" alt="Our Family" style="max-width: 100%; height: auto; border-radius: 8px;">
                </div>
            <?php endif; ?>

            <?php
            $family_desc = get_theme_mod('suc_family_description');
            if ( $family_desc ) : ?>
                <div class="family-description" style="margin-bottom: 20px; font-style: italic; color: #555;">
                    <?php echo wpautop(wp_kses_post($family_desc)); ?>
                </div>
            <?php endif; ?>

            <p>At Southern Utah Cabinetry, we believe that high-quality cabinetry shouldn't require months of waiting. That is why we do not build custom cabinets. Instead, we specialize exclusively in supplying premium <strong>Ready-To-Assemble (RTA)</strong> and <strong>Fully Assembled</strong> cabinets.</p>
            <p>By streamlining our offerings, we pass incredible savings and speed directly onto you. We sell direct to contractors and DIYers. If you aren't comfortable installing the cabinets yourself, we have you covered—we can hire a professional 3rd party installer to complete the job seamlessly.</p>
            <p>Explore our classic colors, including our beautiful new <strong>Classic Cream</strong> finish.</p>
        </section>

        <section class="contact-info">
            <h2>Get In Touch</h2>
            <p>Ready to start your project or have questions? Reach out to us today!</p>
            <ul class="contact-list">
                <li><strong>Phone:</strong> <a href="tel:4354291309"><?php echo esc_html( get_theme_mod( 'suc_phone', '(435) 429-1309' ) ); ?></a></li>
                <li><strong>Email:</strong> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?></a></li>
            </ul>
        </section>
    </div>
</main>
<?php get_footer(); ?>