<?php
/* Template Name: DIY */
get_header();
?>
<main class="site-main container">
    <h1>DIY Cabinetry Solutions</h1>
    <p>Take charge of your remodel with our Ready-To-Assemble (RTA) and fully assembled cabinet options. Perfect for the handy homeowner or independent contractor who wants premium quality without the custom-cabinet price tag.</p>
    
    <h2>Resources for DIYers</h2>
    <p>Everything you need to plan, measure, and order your new cabinets:</p>
    <ul class="resource-links">
        <li><a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_Brochure_v4_No-Fold-Lines.pdf' ) ); ?>" target="_blank" class="btn">View Cabinet Brochure</a></li>
        <li><a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_SpecBook_v5.pdf' ) ); ?>" target="_blank" class="btn">View SpecBook</a></li>
    </ul>

    <h2>Color & Finish Selection</h2>
    <p>Our cabinets are available in a curated selection of professional-grade paints and stains:</p>
    <div class="two-column-layout">
        <div>
            <h3>Paints</h3>
            <ul>
                <li>Pure White</li>
                <li>Classic Cream</li>
                <li>Proper Gray</li>
                <li>Marine Blue</li>
            </ul>
        </div>
        <div>
            <h3>Stains</h3>
            <ul>
                <li>Ideal Gray</li>
                <li>Rustic Hickory</li>
            </ul>
        </div>
    </div>
    
    <div class="contact-prompt" style="margin-top: 40px; padding: 20px; background: var(--bg-light); border-left: 4px solid var(--secondary-color);">
        <p>Need help figuring out your layout or putting together an order? Call us at <strong><?php echo esc_html( get_theme_mod( 'suc_phone', '(435) 429-1309' ) ); ?></strong>.</p>
    </div>
</main>
<?php get_footer(); ?>