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
        $gallery_query = new WP_Query(array(
            'post_type'      => 'photo_gallery',
            'posts_per_page' => -1,
        ));

        if ( $gallery_query->have_posts() ) {
            while ( $gallery_query->have_posts() ) {
                $gallery_query->the_post();
                ?>
                <div class="gallery-card" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                        <div class="gallery-image" style="height: 200px; background-color: #f4f4f4; display: flex; align-items: center; justify-content: center;">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;'));
                            } else {
                                echo '<span style="color: #999;">No Image Available</span>';
                            } ?>
                        </div>
                        <div class="gallery-info" style="padding: 15px;">
                            <h3 style="margin-top: 0;"><?php the_title(); ?></h3>
                            <?php if ( has_excerpt() ) { ?>
                                <p style="font-size: 0.9em; color: #666;"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            <?php } ?>
                            <span class="btn btn-secondary" style="display: inline-block; margin-top: 10px;">View Gallery</span>
                        </div>
                    </a>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p>No galleries found. Please add some from the WordPress admin.</p>';
        }
        ?>
    </div>
</main>
<?php get_footer(); ?>