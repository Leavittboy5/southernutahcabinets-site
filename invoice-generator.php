<?php
/* Template Name: Invoice Generator */
get_header();
?>
<main class="site-main container invoice-container">
    <div class="no-print" style="margin-bottom: 20px;">
        <h1>Professional Invoice Generator</h1>
        <p>Fill out the details below to generate a professional invoice. You can add multiple cabinet items, specify a tax rate, and then print or save as PDF.</p>
        <button type="button" class="btn btn-primary" onclick="window.print();">Print / Save as PDF</button>
    </div>

    <div class="invoice-wrapper">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="invoice-company-details">
                <h2>Southern Utah Cabinetry</h2>
                <p>Phone: <?php echo esc_html(get_theme_mod('suc_phone', '(435) 429-1309')); ?></p>
                <p>Email: <?php echo esc_html(get_theme_mod('suc_email', 'info@southernutahcabinetry.com')); ?></p>
            </div>
            <div class="invoice-meta">
                <h1 style="color: var(--primary-color); margin-bottom: 10px;">INVOICE</h1>
                <div class="meta-row">
                    <label>Invoice #:</label>
                    <input type="text" value="INV-<?php echo date('Ymd') . rand(10,99); ?>" class="invoice-input" />
                </div>
                <div class="meta-row">
                    <label>Date:</label>
                    <input type="date" value="<?php echo date('Y-m-d'); ?>" class="invoice-input" />
                </div>
                <div class="meta-row">
                    <label>Due Date:</label>
                    <input type="date" class="invoice-input" />
                </div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="invoice-bill-to">
            <h3>Bill To:</h3>
            <textarea placeholder="Client Name&#10;Client Address&#10;City, State ZIP&#10;Phone / Email" rows="4" class="invoice-textarea" style="width: 100%; max-width: 400px;"></textarea>
        </div>

        <!-- Line Items -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Description (Cabinet Item, Finish, etc.)</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 15%;">Total</th>
                    <th style="width: 5%;" class="no-print"></th>
                </tr>
            </thead>
            <tbody id="invoice-items-body">
                <tr class="line-item">
                    <td><input type="text" class="invoice-input item-desc" placeholder="e.g. B15 - Base Cabinet (Pure White)" /></td>
                    <td><input type="number" class="invoice-input item-qty" value="1" min="1" step="1" onchange="calculateInvoice()" /></td>
                    <td><input type="number" class="invoice-input item-price" value="0.00" min="0" step="0.01" onchange="calculateInvoice()" /></td>
                    <td class="item-total-cell">$0.00</td>
                    <td class="no-print"><button type="button" class="btn-remove" onclick="removeRow(this)">X</button></td>
                </tr>
            </tbody>
        </table>

        <div class="no-print" style="margin-bottom: 20px;">
            <button type="button" class="btn" onclick="addRow()">+ Add Line Item</button>
        </div>

        <!-- Totals -->
        <div class="invoice-totals">
            <div class="totals-row">
                <label>Subtotal:</label>
                <span id="subtotal-display">$0.00</span>
            </div>
            <div class="totals-row">
                <label>Tax Rate (%):</label>
                <input type="number" id="tax-rate" class="invoice-input" value="0" min="0" step="0.01" style="width: 80px; text-align: right;" onchange="calculateInvoice()" />
            </div>
            <div class="totals-row">
                <label>Tax Amount:</label>
                <span id="tax-amount-display">$0.00</span>
            </div>
            <div class="totals-row grand-total">
                <label>Grand Total:</label>
                <span id="grand-total-display">$0.00</span>
            </div>
        </div>

        <!-- Notes -->
        <div class="invoice-notes" style="margin-top: 40px;">
            <h3>Notes / Terms:</h3>
            <textarea placeholder="Payment is due upon receipt. Thank you for your business!" rows="3" class="invoice-textarea" style="width: 100%;"></textarea>
        </div>
    </div>
</main>

<style>
/* Invoice Generator Styles */
.invoice-wrapper {
    background: #fff;
    padding: 40px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin-bottom: 40px;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 40px;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 20px;
}

.invoice-company-details h2 {
    margin-bottom: 5px;
}

.invoice-meta {
    text-align: right;
}

.meta-row {
    margin-bottom: 5px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.invoice-bill-to {
    margin-bottom: 30px;
}

.invoice-input, .invoice-textarea {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: inherit;
    font-size: 1rem;
    transition: border-color 0.2s;
}
.invoice-input:focus, .invoice-textarea:focus {
    border-color: var(--secondary-color);
    outline: none;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.invoice-table th, .invoice-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

.invoice-table th {
    background-color: var(--bg-light);
    color: var(--primary-color);
}

.item-total-cell {
    font-weight: bold;
}

.btn-remove {
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-remove:hover {
    background: #c0392b;
}

.invoice-totals {
    width: 300px;
    float: right;
    clear: both;
}

.totals-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.grand-total {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--primary-color);
    border-top: 2px solid var(--primary-color);
    border-bottom: none;
}

/* Clearfix */
.invoice-wrapper::after {
    content: "";
    clear: both;
    display: table;
}

/* Print Styles */
@media print {
    body * {
        visibility: hidden;
    }
    .invoice-wrapper, .invoice-wrapper * {
        visibility: visible;
    }
    .invoice-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 0;
        border: none;
        box-shadow: none;
    }
    .no-print, .site-header, .site-footer {
        display: none !important;
    }
    .invoice-input, .invoice-textarea {
        border: none !important;
        background: transparent !important;
        resize: none;
        padding: 0;
    }
    /* Expand inputs so content is fully visible */
    input[type="text"].invoice-input { width: 100%; }
}
</style>

<script>
function formatCurrency(amount) {
    return '$' + amount.toFixed(2);
}

function calculateInvoice() {
    let subtotal = 0;
    const rows = document.querySelectorAll('.line-item');
    
    rows.forEach(row => {
        const qtyStr = row.querySelector('.item-qty').value;
        const priceStr = row.querySelector('.item-price').value;
        
        const qty = parseFloat(qtyStr) || 0;
        const price = parseFloat(priceStr) || 0;
        
        const rowTotal = qty * price;
        subtotal += rowTotal;
        
        row.querySelector('.item-total-cell').textContent = formatCurrency(rowTotal);
    });

    const taxRateStr = document.getElementById('tax-rate').value;
    const taxRate = parseFloat(taxRateStr) || 0;
    const taxAmount = subtotal * (taxRate / 100);
    const grandTotal = subtotal + taxAmount;

    document.getElementById('subtotal-display').textContent = formatCurrency(subtotal);
    document.getElementById('tax-amount-display').textContent = formatCurrency(taxAmount);
    document.getElementById('grand-total-display').textContent = formatCurrency(grandTotal);
}

function addRow() {
    const tbody = document.getElementById('invoice-items-body');
    const newRow = document.createElement('tr');
    newRow.className = 'line-item';
    
    newRow.innerHTML = `
        <td><input type="text" class="invoice-input item-desc" placeholder="Item description" /></td>
        <td><input type="number" class="invoice-input item-qty" value="1" min="1" step="1" onchange="calculateInvoice()" /></td>
        <td><input type="number" class="invoice-input item-price" value="0.00" min="0" step="0.01" onchange="calculateInvoice()" /></td>
        <td class="item-total-cell">$0.00</td>
        <td class="no-print"><button type="button" class="btn-remove" onclick="removeRow(this)">X</button></td>
    `;
    
    tbody.appendChild(newRow);
    calculateInvoice(); // Recalculate in case of default values
}

function removeRow(btn) {
    const row = btn.closest('tr');
    row.remove();
    calculateInvoice();
}

// Initial calculation on load
document.addEventListener('DOMContentLoaded', calculateInvoice);
</script>

<?php get_footer(); ?>
