<?php get_header(); ?>
<main class="site-main">
    <?php
    $photos = array_filter(array(
        get_theme_mod('suc_home_photo_link'),
        get_theme_mod('suc_home_photo_link_2'),
        get_theme_mod('suc_home_photo_link_3')
    ));
    if ( !empty($photos) ) :
        $photos = array_values($photos); // reindex
    ?>
        <div class="home-carousel" style="position: relative; width: 100%; height: 500px; overflow: hidden; background: #000;">
            <?php foreach($photos as $index => $photo) : ?>
                <div class="carousel-slide" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity: <?php echo $index === 0 ? '1' : '0'; ?>; transition: opacity 0.5s ease-in-out; z-index: <?php echo $index === 0 ? '1' : '0'; ?>;">
                    <img src="<?php echo esc_url($photo); ?>" alt="Premium Cabinetry" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            <?php endforeach; ?>

            <?php if (count($photos) > 1) : ?>
                <button class="carousel-btn prev" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%); z-index: 10; background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; font-size: 1.5rem;">&#10094;</button>
                <button class="carousel-btn next" style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); z-index: 10; background: rgba(0,0,0,0.5); color: white; border: none; padding: 10px 15px; cursor: pointer; font-size: 1.5rem;">&#10095;</button>
            <?php endif; ?>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.carousel-slide');
            if (slides.length <= 1) return;

            let currentSlide = 0;
            const nextBtn = document.querySelector('.carousel-btn.next');
            const prevBtn = document.querySelector('.carousel-btn.prev');
            let slideInterval;

            function showSlide(index) {
                slides.forEach(slide => {
                    slide.style.opacity = '0';
                    slide.style.zIndex = '0';
                });
                slides[index].style.opacity = '1';
                slides[index].style.zIndex = '1';
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            if(nextBtn) nextBtn.addEventListener('click', function() {
                nextSlide();
                resetInterval();
            });
            if(prevBtn) prevBtn.addEventListener('click', function() {
                prevSlide();
                resetInterval();
            });

            function startInterval() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }

            startInterval();
        });
        </script>
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