<?php
/**
 * Plugin Name: SUC Invoice System
 * Description: Custom invoice system for Southern Utah Cabinetry.
 * Version: 1.0
 * Author: Southern Utah Cabinetry
 */

/* ==========================================================================
   CUSTOM INVOICE SYSTEM
   ========================================================================== */

// 1. Create the Custom Database Table (Runs automatically)
function suc_create_invoices_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'suc_invoices';
    $charset_collate = $wpdb->get_charset_collate();

    // Added payment_fee and changed shipping_cost to shipping_handling_cost
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        po_number varchar(255) DEFAULT '' NOT NULL,
        client_info text NOT NULL,
        tax_rate float NOT NULL DEFAULT 6.75,
        shipping_handling_cost float NOT NULL DEFAULT 0.00,
        payment_fee float NOT NULL DEFAULT 0.00,
        invoice_items longtext NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action('after_setup_theme', 'suc_create_invoices_table');

// 2. Add the Menu Item in the WordPress Sidebar
function suc_invoices_menu() {
    add_menu_page('Invoices', 'Invoices', 'manage_options', 'suc_invoices', 'suc_invoices_page_handler', 'dashicons-media-spreadsheet', 25);
}
add_action('admin_menu', 'suc_invoices_menu');

// 3. Handle Saving, Updating, and Deleting Data
function suc_handle_invoice_actions() {
    if (!current_user_can('manage_options')) return;
    global $wpdb;
    $table_name = $wpdb->prefix . 'suc_invoices';

    // Save or Update Invoice
    if (isset($_POST['suc_save_invoice_action'])) {
        $data = array(
            'title' => sanitize_text_field($_POST['title']),
            'po_number' => sanitize_text_field($_POST['po_number']),
            'client_info' => sanitize_textarea_field($_POST['client_info']),
            'tax_rate' => floatval($_POST['tax_rate']),
            'shipping_handling_cost' => floatval($_POST['shipping_handling_cost']),
            'payment_fee' => floatval($_POST['payment_fee']),
            'invoice_items' => wp_strip_all_tags(wp_unslash($_POST['invoice_items']))
        );

        if (!empty($_POST['invoice_id'])) {
            // UPDATE existing invoice
            $wpdb->update($table_name, $data, array('id' => intval($_POST['invoice_id'])));
            $msg = 'updated';
        } else {
            // INSERT new invoice
            $wpdb->insert($table_name, $data);
            $msg = 'saved';
        }
        wp_redirect(admin_url('admin.php?page=suc_invoices&msg=' . $msg));
        exit;
    }

    // Delete Invoice
    if (isset($_GET['page']) && $_GET['page'] == 'suc_invoices' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
        wp_redirect(admin_url('admin.php?page=suc_invoices&msg=deleted'));
        exit;
    }
}
add_action('admin_init', 'suc_handle_invoice_actions');

// 4. Render the Dashboard Interface (List, Create, & Edit Forms)
function suc_invoices_page_handler() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'suc_invoices';
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';

    echo '<div class="wrap">';

    // SHOW CREATE / EDIT FORM
    if ($action == 'new' || $action == 'edit') {
        $is_edit = ($action == 'edit' && isset($_GET['id']));
        
        $inv_id = '';
        $title = '';
        $po_number = '';
        $client_info = '';
        $tax_rate = '6.75';
        $shipping_handling_cost = '0.00';
        $payment_fee = '0.00';
        $invoice_items = '[]';

        if ($is_edit) {
            $inv = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['id'])));
            if ($inv) {
                $inv_id = $inv->id;
                $title = $inv->title;
                $po_number = $inv->po_number;
                $client_info = $inv->client_info;
                $tax_rate = $inv->tax_rate;
                $shipping_handling_cost = $inv->shipping_handling_cost;
                $payment_fee = $inv->payment_fee;
                $invoice_items = $inv->invoice_items;
                echo '<h1 class="wp-heading-inline">Edit Invoice</h1>';
            }
        } else {
            $last_inv = $wpdb->get_row("SELECT title FROM $table_name ORDER BY id DESC LIMIT 1");
            $next_num = 1001; 
            if ($last_inv && preg_match('/(\d+)$/', $last_inv->title, $matches)) {
                $next_num = intval($matches[1]) + 1;
            }
            $title = 'INV-' . $next_num;
            echo '<h1 class="wp-heading-inline">Create New Invoice</h1>';
        }

        echo '<a href="?page=suc_invoices" class="page-title-action">&larr; Back to List</a>';
        echo '<hr class="wp-header-end">';
        ?>
        <form method="POST" action="" style="background:#fff; padding:20px; border:1px solid #ccd0d4; max-width: 900px; border-radius:4px;">
            <input type="hidden" name="suc_save_invoice_action" value="1">
            <input type="hidden" name="invoice_id" value="<?php echo esc_attr($inv_id); ?>">
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label>Invoice Title / Number</label></th>
                    <td><input type="text" name="title" required style="width:100%;" value="<?php echo esc_attr($title); ?>" placeholder="e.g. INV-1001"></td>
                </tr>
                <tr>
                    <th scope="row"><label>PO Number (Optional)</label></th>
                    <td><input type="text" name="po_number" style="width:100%;" value="<?php echo esc_attr($po_number); ?>" placeholder="e.g. PO-55829"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Bill To Info</label></th>
                    <td><textarea name="client_info" rows="4" style="width:100%;" placeholder="Client Address / Phone / Email"><?php echo esc_textarea($client_info); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label>Tax Rate (%)</label></th>
                    <td><input type="number" step="0.01" name="tax_rate" value="<?php echo esc_attr($tax_rate); ?>" style="width:100px;"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Shipping & Handling ($)</label></th>
                    <td><input type="number" step="0.01" name="shipping_handling_cost" value="<?php echo esc_attr($shipping_handling_cost); ?>" style="width:100px;"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Payment Processing Fee ($)</label></th>
                    <td><input type="number" step="0.01" name="payment_fee" value="<?php echo esc_attr($payment_fee); ?>" style="width:100px;"></td>
                </tr>
            </table>

            <hr>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Line Items (Client only sees Final Unit Price)</h3>
                <div style="background: #f0f0f1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <strong>Upload CSV:</strong> 
                    <input type="file" id="suc_csv_upload" accept=".csv" style="margin-left: 10px;">
                    <br><small style="color:#666;">Format: <em>Description, Quantity, Base Price</em></small>
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped" style="margin-top: 15px; margin-bottom: 15px;">
                <thead>
                    <tr>
                        <th style="width:40%">Description</th>
                        <th style="width:10%">Qty</th>
                        <th style="width:15%">Base Cost ($)</th>
                        <th style="width:15%">Profit/Upcharge ($)</th>
                        <th style="width:15%">Final Unit Price</th>
                        <th style="width:5%"></th>
                    </tr>
                </thead>
                <tbody id="suc-invoice-body"></tbody>
            </table>
            <button type="button" class="button" id="suc-add-row">Add Blank Line Item</button>

            <input type="hidden" name="invoice_items" id="invoice_items" value="<?php echo esc_attr($invoice_items); ?>">
            
            <p style="margin-top: 30px;"><button type="submit" class="button button-primary button-large"><?php echo $is_edit ? 'Update Invoice' : 'Save Invoice Data'; ?></button></p>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('suc-invoice-body');
            const hiddenInput = document.getElementById('invoice_items');
            const csvInput = document.getElementById('suc_csv_upload');
            
            let rawItems = JSON.parse(hiddenInput.value || '[]');
            if (rawItems.length === 0) {
                rawItems = [{desc: '', qty: 1, base_price: 0, profit: 0}];
            }

            let items = rawItems.map(item => ({
                desc: item.desc || '',
                qty: item.qty || 1,
                base_price: item.base_price !== undefined ? item.base_price : (item.price || 0),
                profit: item.profit || 0
            }));

            function renderRows() {
                tbody.innerHTML = '';
                items.forEach((item, index) => {
                    const finalPrice = (parseFloat(item.base_price) + parseFloat(item.profit)).toFixed(2);
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><input type="text" class="i-desc" data-index="${index}" value="${item.desc}" style="width:100%"></td>
                        <td><input type="number" class="i-qty" data-index="${index}" value="${item.qty}" min="1" style="width:100%"></td>
                        <td><input type="number" step="0.01" class="i-base" data-index="${index}" value="${item.base_price}" style="width:100%"></td>
                        <td><input type="number" step="0.01" class="i-profit" data-index="${index}" value="${item.profit}" style="width:100%"></td>
                        <td style="vertical-align: middle; font-weight: bold; color: #2c3e50;" class="i-total">$${finalPrice}</td>
                        <td><a href="#" class="suc-remove-row" data-index="${index}" style="color:red; text-decoration:none; font-weight:bold;">&times;</a></td>
                    `;
                    tbody.appendChild(tr);
                });
                hiddenInput.value = JSON.stringify(items);
            }

            // Fix for backwards typing: Target DOM updates instead of a full render on every keystroke
            tbody.addEventListener('input', function(e) {
                const index = e.target.getAttribute('data-index');
                if(e.target.classList.contains('i-desc')) items[index].desc = e.target.value;
                if(e.target.classList.contains('i-qty')) items[index].qty = e.target.value;
                if(e.target.classList.contains('i-base')) items[index].base_price = e.target.value;
                if(e.target.classList.contains('i-profit')) items[index].profit = e.target.value;
                
                // Only update the specific total text for this row
                if(e.target.classList.contains('i-base') || e.target.classList.contains('i-profit')) {
                    const tr = e.target.closest('tr');
                    const base = parseFloat(items[index].base_price) || 0;
                    const profit = parseFloat(items[index].profit) || 0;
                    const finalPrice = (base + profit).toFixed(2);
                    tr.querySelector('.i-total').textContent = '$' + finalPrice;
                }
                
                hiddenInput.value = JSON.stringify(items);
            });

            tbody.addEventListener('click', function(e) {
                if(e.target.classList.contains('suc-remove-row')) {
                    e.preventDefault();
                    items.splice(e.target.getAttribute('data-index'), 1);
                    renderRows();
                }
            });

            document.getElementById('suc-add-row').addEventListener('click', function() {
                items.push({desc: '', qty: 1, base_price: 0, profit: 0});
                renderRows();
            });

            csvInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(event) {
                    const text = event.target.result;
                    const rows = text.split('\n');

                    if (items.length === 1 && items[0].desc === '' && items[0].base_price == 0) items = [];

                    rows.forEach(row => {
                        if (row.trim() === '') return; 
                        const cols = row.split(/,(?=(?:(?:[^"]*"){2})*[^"]*$)/); 
                        let desc = cols[0] ? cols[0].replace(/(^"|"$)/g, '').trim() : '';
                        
                        if (desc.toLowerCase().includes('description')) return;

                        let qty = cols[1] ? parseFloat(cols[1].replace(/[^0-9.]/g, '')) : 1;
                        let base = cols[2] ? parseFloat(cols[2].replace(/[^0-9.]/g, '')) : 0;

                        if (isNaN(qty)) qty = 1;
                        if (isNaN(base)) base = 0;

                        if (desc !== '') {
                            items.push({desc: desc, qty: qty, base_price: base, profit: 0});
                        }
                    });

                    renderRows();
                    csvInput.value = ''; 
                };
                reader.readAsText(file);
            });

            renderRows();
        });
        </script>
        <?php
    } 
    
    // SHOW LIST OF INVOICES
    else {
        echo '<h1 class="wp-heading-inline">Manage Invoices</h1>';
        echo '<a href="?page=suc_invoices&action=new" class="page-title-action">Add New Invoice</a>';
        echo '<hr class="wp-header-end">';

        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 'saved') echo '<div class="notice notice-success is-dismissible"><p>Invoice Created!</p></div>';
            if ($_GET['msg'] == 'updated') echo '<div class="notice notice-success is-dismissible"><p>Invoice Updated Successfully!</p></div>';
            if ($_GET['msg'] == 'deleted') echo '<div class="notice notice-error is-dismissible"><p>Invoice Deleted.</p></div>';
        }

        $invoices = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Invoice Number / Title</th><th>PO Number</th><th>Date Created</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        if($invoices) {
            foreach($invoices as $inv) {
                $print_url = admin_url('admin.php?action=suc_print_invoice&id=' . $inv->id);
                $edit_url = admin_url('admin.php?page=suc_invoices&action=edit&id=' . $inv->id);
                $delete_url = admin_url('admin.php?page=suc_invoices&action=delete&id=' . $inv->id);
                $date = date('F j, Y', strtotime($inv->created_at));
                
                // Fetch the PO number or display a dash if empty
                $display_po = !empty($inv->po_number) ? esc_html($inv->po_number) : '-';
                
                echo "<tr>
                    <td><strong>" . esc_html($inv->title) . "</strong></td>
                    <td>{$display_po}</td>
                    <td>{$date}</td>
                    <td>
                        <a href='{$edit_url}' class='button'>Edit</a>
                        <a href='{$print_url}' target='_blank' class='button button-primary'>📄 View / PDF</a>
                        <a href='{$delete_url}' class='button' style='color:#a00;' onclick='return confirm(\"Permanently delete this invoice?\");'>Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo '<tr><td colspan="4">No invoices found. Click "Add New Invoice" to get started.</td></tr>';
        }
        echo '</tbody></table>';
    }
    echo '</div>';
}

// 5. Generate the Clean PDF View (Hides Admin Sidebar)
function suc_print_invoice_action() {
    if (!current_user_can('manage_options') || !isset($_GET['id'])) wp_die('Unauthorized');
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'suc_invoices';
    $invoice = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['id'])));
    if (!$invoice) wp_die('Invoice not found');

    $items = json_decode($invoice->invoice_items, true) ?: array();
    $subtotal = 0;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice - <?php echo esc_attr($invoice->title); ?></title>
        <style>
            :root { --primary-color: #2c3e50; --secondary-color: #d35400; --bg-light: #f9f9f9; --border-color: #dddddd; }
            body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #525659; margin: 0; padding: 40px 20px; color: #333; }
            .invoice-container { max-width: 850px; margin: 0 auto; background: #ffffff; padding: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
            .action-buttons { max-width: 850px; margin: 0 auto 20px auto; display: flex; justify-content: flex-end; }
            .btn-pdf { background: #27ae60; color: white; padding: 12px 24px; font-weight: bold; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; font-size: 1.1rem; }
            .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid var(--primary-color); padding-bottom: 20px; }
            .invoice-logo img { max-height: 80px; width: auto; }
            .invoice-meta { text-align: right; }
            .invoice-meta h1 { margin: 0 0 10px 0; color: var(--primary-color); font-size: 2.5rem; letter-spacing: 2px; }
            .invoice-bill-to { margin-bottom: 40px; }
            .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
            .invoice-table th, .invoice-table td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
            .invoice-table th { background-color: var(--bg-light); color: var(--primary-color); }
            .invoice-totals { width: 350px; float: right; }
            .totals-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
            .grand-total { font-size: 1.2rem; font-weight: bold; color: var(--primary-color); border-top: 2px solid var(--primary-color); border-bottom: none; }
            @media print { body { background-color: #ffffff; padding: 0; } .invoice-container { box-shadow: none; padding: 0; max-width: 100%; } .no-print { display: none !important; } }
        </style>
    </head>
    <body>
        <div class="no-print action-buttons">
            <button type="button" class="btn-pdf" onclick="window.print();">📄 Generate PDF</button>
        </div>

        <div class="invoice-container">
            <div class="invoice-header">
                <div>
                    <div class="invoice-logo">
                        <img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/04/SUC-logo-transparent.png' ) ); ?>" alt="Logo">
                    </div>
                    <div style="font-size: 0.9rem; color: #666; margin-top: 10px;">
                        <p style="margin:2px 0;">Phone: <?php echo esc_html(get_theme_mod('suc_phone', '(435) 429-1309')); ?></p>
                        <p style="margin:2px 0;">Email: <?php echo esc_html(get_theme_mod('suc_email', 'info@southernutahcabinetry.com')); ?></p>
                    </div>
                </div>
                <div class="invoice-meta">
                    <h1>INVOICE</h1>
                    <p style="margin:3px 0;"><strong>Title / #:</strong> <?php echo esc_html($invoice->title); ?></p>
                    <?php if (!empty($invoice->po_number)) : ?>
                        <p style="margin:3px 0;"><strong>PO #:</strong> <?php echo esc_html($invoice->po_number); ?></p>
                    <?php endif; ?>
                    <p style="margin:3px 0;"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($invoice->created_at)); ?></p>
                </div>
            </div>

            <div class="invoice-bill-to">
                <h3 style="color: var(--primary-color); border-bottom: 1px solid var(--border-color); display: inline-block; padding-bottom: 5px; margin-bottom:10px;">Bill To:</h3>
                <div style="white-space: pre-wrap; font-family: inherit; line-height: 1.5;"><?php echo esc_html($invoice->client_info); ?></div>
            </div>

            <table class="invoice-table">
                <thead><tr><th style="width: 55%;">Description</th><th style="width: 15%;">Qty</th><th style="width: 15%;">Unit Price</th><th style="width: 15%;">Total</th></tr></thead>
                <tbody>
                    <?php foreach ($items as $item) : 
                        $qty = floatval(isset($item['qty']) ? $item['qty'] : 1);
                        
                        $base_price = floatval(isset($item['base_price']) ? $item['base_price'] : (isset($item['price']) ? $item['price'] : 0));
                        $profit = floatval(isset($item['profit']) ? $item['profit'] : 0);
                        
                        $final_unit_price = $base_price + $profit;
                        $row_total = $qty * $final_unit_price;
                        $subtotal += $row_total;
                    ?>
                    <tr>
                        <td><?php echo esc_html($item['desc']); ?></td>
                        <td><?php echo esc_html($qty); ?></td>
                        <td>$<?php echo number_format($final_unit_price, 2); ?></td>
                        <td style="font-weight: bold;">$<?php echo number_format($row_total, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php 
            $tax_amount = $subtotal * ($invoice->tax_rate / 100);
            $combined_shipping_fee = $invoice->shipping_handling_cost + $invoice->payment_fee;
            $grand_total = $subtotal + $tax_amount + $combined_shipping_fee;
            ?>
            <div class="invoice-totals">
                <div class="totals-row"><label>Subtotal:</label><span>$<?php echo number_format($subtotal, 2); ?></span></div>
                <?php if ($invoice->tax_rate > 0) : ?>
                <div class="totals-row"><label>Tax (<?php echo esc_html($invoice->tax_rate); ?>%):</label><span>$<?php echo number_format($tax_amount, 2); ?></span></div>
                <?php endif; ?>
                <?php if ($combined_shipping_fee > 0) : ?>
                <div class="totals-row"><label>Shipping & Handling:</label><span>$<?php echo number_format($combined_shipping_fee, 2); ?></span></div>
                <?php endif; ?>
                <div class="totals-row grand-total"><label>Grand Total:</label><span>$<?php echo number_format($grand_total, 2); ?></span></div>
            </div>

            <div style="margin-top: 50px; clear: both; padding-top: 20px; border-top: 1px solid #eee; color: #555; font-size: 0.9rem;">
                <p><strong>Notes:</strong> Payment is due upon receipt. Thank you for choosing Southern Utah Cabinetry!</p>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
add_action('admin_action_suc_print_invoice', 'suc_print_invoice_action');
?>
