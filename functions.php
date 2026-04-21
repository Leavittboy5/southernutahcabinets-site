<?php
// Enqueue styles and scripts
function suc_enqueue_styles() {
    wp_enqueue_style('suc-main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'suc_enqueue_styles');

// Add Customizer settings for Phone and Email so you can edit them easily without touching code later
function suc_customizer_settings($wp_customize) {
    $wp_customize->add_section('suc_contact_info', array(
        'title'    => 'Contact Information',
        'priority' => 30,
    ));

    // Phone Number Setting (Defaulting to the one provided)
    $wp_customize->add_setting('suc_phone', array(
        'default'           => '(435) 429-1309',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('suc_phone', array(
        'label'   => 'Phone Number',
        'section' => 'suc_contact_info',
        'type'    => 'text',
    ));

    // Email Address Setting (Placeholder)
    $wp_customize->add_setting('suc_email', array(
        'default'           => 'info@southernutahcabinetry.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('suc_email', array(
        'label'   => 'Email Address',
        'section' => 'suc_contact_info',
        'type'    => 'email',
    ));

    // Section for Photos & Content
    $wp_customize->add_section('suc_photos_content', array(
        'title'    => 'Photos & Content',
        'priority' => 35,
    ));

    // Family Photo Link
    $wp_customize->add_setting('suc_family_photo_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_family_photo_link', array(
        'label'   => 'Family Photo Link (Contact & About Us)',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));

    // Family Description
    $wp_customize->add_setting('suc_family_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('suc_family_description', array(
        'label'   => 'Family Description (Contact & About Us)',
        'section' => 'suc_photos_content',
        'type'    => 'textarea',
    ));

    // Home Page Photo Link
    $wp_customize->add_setting('suc_home_photo_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_home_photo_link', array(
        'label'   => 'Home Page Photo Link',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('suc_home_photo_link_2', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_home_photo_link_2', array(
        'label'   => 'Home Page Photo Link 2',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('suc_home_photo_link_3', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_home_photo_link_3', array(
        'label'   => 'Home Page Photo Link 3',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));

    // DIY Page Photo Link
    $wp_customize->add_setting('suc_diy_photo_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_diy_photo_link', array(
        'label'   => 'DIY Page Photo Link',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));

    // Order Form Page Photo Link
    $wp_customize->add_setting('suc_order_photo_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('suc_order_photo_link', array(
        'label'   => 'Order Form Page Photo Link',
        'section' => 'suc_photos_content',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'suc_customizer_settings');

// Theme setup
function suc_theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'suc_theme_setup');

// Register Custom Post Type for Photo Galleries
function suc_register_photo_gallery_cpt() {
    $labels = array(
        'name'                  => _x('Photo Galleries', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Photo Gallery', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Photo Galleries', 'text_domain'),
        'name_admin_bar'        => __('Photo Gallery', 'text_domain'),
        'archives'              => __('Gallery Archives', 'text_domain'),
        'attributes'            => __('Gallery Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Gallery:', 'text_domain'),
        'all_items'             => __('All Galleries', 'text_domain'),
        'add_new_item'          => __('Add New Gallery', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __('New Gallery', 'text_domain'),
        'edit_item'             => __('Edit Gallery', 'text_domain'),
        'update_item'           => __('Update Gallery', 'text_domain'),
        'view_item'             => __('View Gallery', 'text_domain'),
        'view_items'            => __('View Galleries', 'text_domain'),
        'search_items'          => __('Search Gallery', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into gallery', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this gallery', 'text_domain'),
        'items_list'            => __('Galleries list', 'text_domain'),
        'items_list_navigation' => __('Galleries list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter galleries list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Photo Gallery', 'text_domain'),
        'description'           => __('Custom Post Type for Photo Galleries', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-gallery',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type('photo_gallery', $args);
}
add_action('init', 'suc_register_photo_gallery_cpt', 0);

// Flush rewrite rules on theme activation
function suc_flush_rewrite_rules_on_activation() {
    suc_register_photo_gallery_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'suc_flush_rewrite_rules_on_activation');
?>