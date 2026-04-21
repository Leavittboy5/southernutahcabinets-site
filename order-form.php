<?php
/* Template Name: Order Form */
get_header();
?>
<main class="site-main container">
    <h1>Order Your Cabinets</h1>
    <p>Please review our <a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_SpecBook_v5.pdf' ) ); ?>" target="_blank">SpecBook</a> and <a href="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/VWC_Brochure_v4_No-Fold-Lines.pdf' ) ); ?>" target="_blank">Brochure</a> before placing your order to ensure accurate measurements and styles.</p>

    <form action="#" method="POST" class="cabinet-order-form form-layout">
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