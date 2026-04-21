<?php get_header(); ?>
<main class="site-main">
    <?php
    $home_photo = get_theme_mod('suc_home_photo_link');
    if ( $home_photo ) : ?>
        <div class="home-featured-image" style="width: 100%; max-height: 500px; overflow: hidden;">
            <img src="<?php echo esc_url($home_photo); ?>" alt="Premium Cabinetry" style="width: 100%; height: auto; object-fit: cover;">
        </div>
    <?php else : ?>
        <div class="home-featured-image placeholder" style="width: 100%; height: 300px; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777;">
            <span>[Home Page Photo Placeholder - Set in Customizer]</span>
        </div>
    <?php endif; ?>

    <section class="hero-section">
        <div class="container">
            <h1>Premium RTA & Fully Assembled Cabinetry</h1>
            <p>Southern Utah's premier supplier for high-quality cabinets. We specialize in supplying top-tier Ready-To-Assemble (RTA) and Fully Assembled cabinets directly to contractors and DIYers. This allows us to provide incredible quality with unmatched speed and pricing.</p>
            <p>Prefer professional installation? We can coordinate a trusted 3rd party installer to handle the entire process for you.</p>
            <a href="<?php echo esc_url( home_url( '/order-form/' ) ); ?>" class="btn btn-primary">Start Your Order</a>
        </div>
    </section>

    <section class="features-section container">
        <h2>Our Cabinet Options</h2>
        <div class="feature-grid">
            <div class="feature">
                <h3>Ready-To-Assemble (RTA)</h3>
                <p>Perfect for DIYers and contractors looking to save on assembly and shipping. High-quality materials ready for on-site assembly.</p>
            </div>
            <div class="feature">
                <h3>Fully Assembled</h3>
                <p>Save time on the job site. Order your cabinets fully built and ready for installation the moment they arrive.</p>
            </div>
        </div>
    </section>

    <section class="colors-section container">
        <h2>Available Finishes</h2>
        <div class="two-column-layout">
            <div>
                <h3>Premium Paints</h3>
                <ul class="color-list">
                    <li>Pure White</li>
                    <li>Classic Cream</li>
                    <li>Proper Gray</li>
                    <li>Marine Blue</li>
                </ul>
            </div>
            <div>
                <h3>Beautiful Stains</h3>
                <ul class="color-list">
                    <li>Ideal Gray</li>
                    <li>Rustic Hickory</li>
                </ul>
            </div>
        </div>
        <p class="mt-4">Review our <a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_Brochure_v4_No-Fold-Lines.pdf' ) ); ?>" target="_blank">Brochure</a> for visual details on each finish.</p>
    </section>
</main>
<?php get_footer(); ?>