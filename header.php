<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container header-container">
            <div class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <!-- Transparent Logo -->
                    <img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/SUC-logo-transparent.png' ) ); ?>" alt="Southern Utah Cabinetry Logo">
                </a>
            </div>
            <nav class="main-navigation">
                <ul>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/diy/' ) ); ?>">DIY</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">Gallery</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/order-form/' ) ); ?>">Order Form</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/process/' ) ); ?>">Process</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact-and-about-us/' ) ); ?>">Contact & About Us</a></li>
                </ul>
            </nav>
        </div>
    </header>