<?php
/* Template Name: Gallery */
get_header();
?>
<main class="site-main container">
    <h1>Project Gallery</h1>
    <p>Explore our premium cabinetry in real-world settings. From modern painted finishes like Marine Blue to timeless stains like Rustic Hickory.</p>
    
    <div class="gallery-filters" style="margin-bottom: 30px; font-size: 0.9rem; color: var(--text-light);">
        <p><strong>Browse by Finish:</strong> 
            Pure White | Classic Cream | Proper Gray | Marine Blue | Ideal Gray | Rustic Hickory
        </p>
    </div>

    <div class="gallery-grid">
        <?php 
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