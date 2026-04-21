<?php
/* Template for individual photo galleries */
get_header();
?>
<main class="site-main container">
    <article id="post-<?php the_ID(); ?>" <?php post_class('single-gallery'); ?>>
        <header class="gallery-header" style="margin-bottom: 30px;">
            <h1 class="gallery-title"><?php the_title(); ?></h1>
            <p style="color: #666;"><a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>">&larr; Back to Galleries</a></p>
        </header>

        <div class="gallery-content">
            <?php
            while ( have_posts() ) :
                the_post();

                // Display the featured image at the top if it exists
                if ( has_post_thumbnail() ) {
                    echo '<div class="gallery-featured-image" style="margin-bottom: 20px;">';
                    the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 8px;'));
                    echo '</div>';
                }

                // Display the content (which could include a WordPress native gallery block or images)
                the_content();
            endwhile;
            ?>
        </div>
    </article>
</main>
<?php get_footer(); ?>