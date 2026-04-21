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
}
add_action('customize_register', 'suc_customizer_settings');
?>