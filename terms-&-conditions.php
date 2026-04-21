<?php
/* Template Name: Terms and Conditions */
get_header();
?>
<main class="site-main container">
    <h1>Terms & Conditions</h1>
    <div class="terms-content">
        <p>Welcome to Southern Utah Cabinetry. By accessing and using <strong><a href="<?php echo esc_url( home_url( '/' ) ); ?>">southernutahcabinetry.com</a></strong>, you agree to the following terms and conditions:</p>
        
        <h3>1. Product Offering</h3>
        <p>Southern Utah Cabinetry supplies Ready-To-Assemble (RTA) and fully assembled cabinets. We do not design or manufacture custom cabinets. All sales are based on the styles, colors (including Classic Cream), and dimensions outlined in our official SpecBook.</p>

        <h3>2. Installation</h3>
        <p>Cabinets are sold direct to the consumer/contractor. If the customer does not wish to perform a DIY installation, Southern Utah Cabinetry can coordinate and hire an independent 3rd party installer. The timeline and specific workmanship guarantees of the installation are handled through the 3rd party agreement.</p>

        <h3>3. Contact Information</h3>
        <p>For any disputes, order changes, or questions regarding the sale of goods, please contact us at:</p>
        <ul>
            <li>Phone: <strong><?php echo esc_html( get_theme_mod( 'suc_phone', '(435) 429-1309' ) ); ?></strong></li>
            <li>Email: <strong><a href="mailto:<?php echo esc_attr( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?></a></strong></li>
        </ul>
        
        <?php 
        // Loads any additional content added in the WP Editor
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                the_content();
            }
        }
        ?>
    </div>
</main>
<?php get_footer(); ?>