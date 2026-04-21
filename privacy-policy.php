<?php
/* Template Name: Privacy Policy */
get_header();
?>
<main class="site-main container">
    <h1>Privacy Policy</h1>
    <div class="privacy-content">
        <p><strong>Last Updated: <?php echo date('F j, Y'); ?></strong></p>
        
        <p>At Southern Utah Cabinetry (operating via <strong><a href="<?php echo esc_url( home_url( '/' ) ); ?>">southernutahcabinetry.com</a></strong>), we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and protect your personal information when you visit our website or place an order.</p>

        <h3>1. Information We Collect</h3>
        <p>We collect information that you voluntarily provide to us through our Order Form and Contact pages, including:</p>
        <ul>
            <li><strong>Personal Details:</strong> Name, phone number, and email address.</li>
            <li><strong>Project Details:</strong> Chosen finishes (e.g., Pure White, Classic Cream, Proper Gray, Marine Blue, Ideal Gray, or Rustic Hickory), assembly preferences (RTA or Assembled), and item codes.</li>
            <li><strong>Installation Preferences:</strong> Whether you require 3rd party installation support.</li>
        </ul>

        <h3>2. How We Use Your Information</h3>
        <p>The information we collect is used strictly to:</p>
        <ul>
            <li>Process, confirm, and fulfill your cabinet orders.</li>
            <li>Communicate regarding shipping, billing, or order modifications.</li>
            <li>Coordinate with 3rd party installers if requested.</li>
        </ul>

        <h3>3. Data Sharing</h3>
        <p>We do not sell your personal information. Data is only shared with trusted partners necessary for fulfillment (shipping companies) or installation (3rd party contractors), as requested by you.</p>

        <h3>4. Contact Us</h3>
        <p>For questions regarding this policy, please contact us at:</p>
        <ul>
            <li>Phone: <strong><?php echo esc_html( get_theme_mod( 'suc_phone', '(435) 429-1309' ) ); ?></strong></li>
            <li>Email: <strong><a href="mailto:<?php echo esc_attr( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'suc_email', 'info@southernutahcabinetry.com' ) ); ?></a></strong></li>
        </ul>
    </div>
</main>
<?php get_footer(); ?>