<?php
/* Template Name: Order Form */
get_header();
?>
<main class="site-main container">
    <?php
    $order_photo = get_theme_mod('suc_order_photo_link');
    if ( $order_photo ) : ?>
        <div class="order-featured-image" style="margin-bottom: 30px;">
            <img src="<?php echo esc_url($order_photo); ?>" alt="Order Cabinets" style="width: 100%; height: auto; border-radius: 8px;">
        </div>
    <?php else : ?>
        <div class="order-featured-image placeholder" style="margin-bottom: 30px; width: 100%; height: 250px; background-color: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #777;">
            <span>[Order Form Page Photo Placeholder - Set in Customizer]</span>
        </div>
    <?php endif; ?>

    <h1>Order Your Cabinets</h1>
    <p>Please review our <a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_SpecBook_v5.pdf' ) ); ?>" target="_blank">SpecBook</a> and <a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_Brochure_v4_No-Fold-Lines.pdf' ) ); ?>" target="_blank">Brochure</a> before placing your order to ensure accurate measurements and styles.</p>

    <?php
    $form_submitted = false;
    $form_error = false;

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order']) ) {
        // Sanitize input
        $cabinet_color = sanitize_text_field($_POST['cabinet_color']);
        $assembly_type = sanitize_text_field($_POST['assembly_type']);
        $installation = sanitize_text_field($_POST['installation']);
        $order_details = sanitize_textarea_field($_POST['order_details']);

        // Prepare Email
        $to = get_theme_mod('suc_email', get_option('admin_email'));
        $subject = 'New Cabinet Order Request';
        $body = "A new cabinet order request has been submitted:\n\n";
        $body .= "Color/Finish: " . $cabinet_color . "\n";
        $body .= "Assembly Preference: " . $assembly_type . "\n";
        $body .= "Installation Preference: " . $installation . "\n";
        $body .= "Order Details:\n" . $order_details . "\n";

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        // Send Email
        if ( wp_mail($to, $subject, $body, $headers) ) {
            $form_submitted = true;
        } else {
            $form_error = true;
        }
    }
    ?>

    <?php if ( $form_submitted ) : ?>
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
            Thank you! Your order request has been submitted successfully. We will be in touch soon.
        </div>
    <?php elseif ( $form_error ) : ?>
        <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
            There was an error submitting your order. Please try again or contact us directly.
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="cabinet-order-form form-layout">
        <div class="form-group">
            <label for="cabinet_color">1. Select Cabinet Color/Finish:</label>
            <select name="cabinet_color" id="cabinet_color" required>
                <option value="">-- Choose a Finish --</option>
                <optgroup label="Paints">
                    <option value="Pure White">Pure White</option>
                    <option value="Classic Cream">Classic Cream</option>
                    <option value="Proper Gray">Proper Gray</option>
                    <option value="Marine Blue">Marine Blue</option>
                </optgroup>
                <optgroup label="Stains">
                    <option value="Ideal Gray">Ideal Gray</option>
                    <option value="Rustic Hickory">Rustic Hickory</option>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="assembly_type">2. Assembly Preference:</label>
            <select name="assembly_type" id="assembly_type" required>
                <option value="">-- Choose Assembly --</option>
                <option value="RTA">Ready-To-Assemble (RTA)</option>
                <option value="Assembled">Fully Assembled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="installation">3. Installation Preference:</label>
            <select name="installation" id="installation" required>
                <option value="">-- Choose Installation Method --</option>
                <option value="DIY">DIY / I have my own Contractor</option>
                <option value="3rd_Party">Please hire a 3rd party installer for me</option>
            </select>
        </div>

        <div class="form-group">
            <label for="order_details">4. Cabinet Order Details (Item numbers from SpecBook):</label>
            <textarea name="order_details" id="order_details" rows="6" placeholder="Example: B15, W3030, LS36..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Order Request</button>
    </form>
</main>
<?php get_footer(); ?>