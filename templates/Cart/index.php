<div class="cart-container">
    <h1> Cart</h1>
    
    <!-- Hidden CSRF Token for AJAX requests -->
    <input type="hidden" id="csrfToken" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">

    <div class="cart-wrapper">
        <!-- Left Side: Cart Items -->
        <div class="cart-main">
            <?php if (empty($cart)): ?>
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <?= $this->Html->link('Continue Shopping', ['controller' => 'Products', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
                </div>
            <?php else: ?>
                <!-- <div class="cart-items">
                    <ul class="cart-list">
                        <?php foreach ($cartItems as $cartKey => $item): ?>
                            <li class="cart-list-item">
                                <div class="item-details">
                                    <div class="item-name"><?= h($item['product']->name) ?></div>
                                    <div class="item-info">
                                        <span class="item-size">Size: <?= h($item['size']) ?></span>
                                        <span class="item-price">₱<?= number_format($item['product']->price, 2) ?></span>
                                        <span class="item-qty">Qty: <?= $item['quantity'] ?></span>
                                        <span class="item-subtotal">₱<?= number_format($item['product']->price * $item['quantity'], 2) ?></span>
                                    </div>
                                </div>
                                <div class="item-action">
                                    <?= $this->Html->link('Delete', ['controller' => 'Cart', 'action' => 'remove', $item['product']->id, $item['size']], ['class' => 'btn btn-danger btn-small']) ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div> -->

                <div class="receipt-wrapper">
                    <div class="receipt">
                        <!-- Receipt Header -->
                        <div class="receipt-header">
                            <!-- Receipt Media/Logo -->
                            <div class="receipt-media">
                                <img src="<?= $this->Url->build('/img/fb.jpg') ?>" alt="Fresh Blends Café" class="receipt-logo">
                            </div>
                            <div class="receipt-brand">🛍️ ORDER SUMMARY</div>
                            <div class="receipt-customer-info">
                                <div class="receipt-customer-name" id="receiptCustomerName"></div>
                                <div class="receipt-date" id="receiptDate"></div>
                            </div>
                            <div class="receipt-divider dashed"></div>
                        </div>

                        <!-- Receipt Items -->
                        <div class="receipt-items">
                            <?php foreach ($cartItems as $cartKey => $item): ?>
                                <div class="receipt-line-item">
                                    <div class="receipt-item-top">
                                        <span class="receipt-item-name"><?= h($item['product']->name) ?></span>
                                        <span class="receipt-item-subtotal">₱<?= number_format($item['size_price'] * $item['quantity'], 2) ?></span>
                                    </div>
                                    <div class="receipt-item-meta">
                                        <span class="receipt-meta-text">Size: <?= h($item['size']) ?> &nbsp;·&nbsp; ₱<?= number_format($item['size_price'], 2) ?> × <?= $item['quantity'] ?></span>
                                        <?= $this->Html->link('✕ Remove', ['controller' => 'Cart', 'action' => 'remove', $item['product']->id, $item['size']], ['class' => 'receipt-remove-btn']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="receipt-divider dashed"></div>

                        <!-- Totals -->
                        <div class="receipt-totals">
                            <div class="receipt-total-row">
                                <span>Subtotal</span>
                                <span>₱<?= number_format(array_sum(array_map(fn($i) => $i['size_price'] * $i['quantity'], $cartItems)), 2) ?></span>
                            </div>
                        </div>

                        <div class="receipt-footer">
                            <div class="receipt-divider solid"></div>
                            <div class="receipt-barcode">|||| |||||||| |||| ||| ||||||</div>
                            <div class="receipt-footer-text">Thank you!</div>

                            <button class="btn bt-sm btn-success" onclick="openPrintDialog()">Print Receipt</button>

                        </div>
                    </div>
                </div>

                <!-- <div class="cart-summary">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal:</span>
                            <span class="summary-value">₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Tax (12%):</span>
                            <span class="summary-value">₱<?= number_format($total * 0.12, 2) ?></span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Total:</span>
                            <span class="summary-value">₱<?= number_format($total * 1.12, 2) ?></span>
                        </div>
                    </div>

                    <div class="cart-actions">
                        <?= $this->Html->link('Continue Shopping', ['controller' => 'Products', 'action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link('Checkout', ['controller' => 'Sales', 'action' => 'add'], ['class' => 'btn btn-success']) ?>
                      
                    </div>
                </div> -->
               
            <?php endif; ?>
        </div>

        <!-- Right Side: Available Products -->
        <div class="cart-sidebar">
            <h2>Available Products</h2>
            <div class="products-sidebar-list">
                <?php foreach ($allProducts as $product): ?>
                    <div class="product-sidebar-card" data-product-id="<?= $product->id ?>">
                        <div class="sidebar-product-header">
                            <h4><?= h($product->name) ?></h4>
                            <span class="product-price-badge" data-product-id="<?= $product->id ?>">₱<?= number_format($product->price, 2) ?></span>
                        </div>

                        <div class="sidebar-product-info">
                            <span class="stock-info">Stock: <?= $product->stock ?></span>
                        </div>

                        <div class="sidebar-size-selection">
                            <label for="sidebar-size-<?= $product->id ?>">Size:</label>
                            <select id="sidebar-size-<?= $product->id ?>" class="size-select-sidebar" data-product-id="<?= $product->id ?>"
                                data-base-price="<?= $product->price ?>"
                                data-xs-price="<?= $product->xs_price ?? '' ?>"
                                data-s-price="<?= $product->s_price ?? '' ?>"
                                data-m-price="<?= $product->m_price ?? '' ?>"
                                data-l-price="<?= $product->l_price ?? '' ?>"
                                data-xl-price="<?= $product->xl_price ?? '' ?>"
                                data-xxl-price="<?= $product->xxl_price ?? '' ?>">
                                <option value="">-- Choose Size --</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M" selected>M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>

                        <button class="btn btn-success btn-small add-to-cart-sidebar-btn" data-product-id="<?= $product->id ?>">
                            Add to Cart
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Print Dialog Modal -->
<div id="printModal" class="print-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Prepare Receipt for Print</h2>
            <button class="modal-close" onclick="closePrintDialog()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="printForm" onsubmit="savePrintDetails(); return false;">
                <div class="form-group">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" name="customerName" placeholder="Enter customer name" required>
                </div>
                <div class="form-group">
                    <label for="printDate">Date:</label>
                    <input type="date" id="printDate" name="printDate" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closePrintDialog()">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sales Confirmation Modal -->
<div id="salesModal" class="print-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add to Sales</h2>
            <button class="modal-close" onclick="closeSalesDialog()">&times;</button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom: 1.5rem; color: #2c3e50; font-size: 1rem;">
                Do you want to add this order to sales?
            </p>
            <p style="margin-bottom: 1.5rem; background: #f5f5f5; padding: 1rem; border-radius: 4px; font-size: 0.95rem;">
                <strong>Customer:</strong> <span id="salesCustomerDisplay"></span><br>
                <strong>Date:</strong> <span id="salesDateDisplay"></span><br>
                <strong>Total:</strong> <span id="salesTotalDisplay"></span>
            </p>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="skipAddToSales()">No, Just Print</button>
                <button type="button" class="btn btn-success" onclick="confirmAddToSales()">Yes, Add and Print</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Print Modal Styles */
    .print-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 0;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 500px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
        background: linear-gradient(135deg, #5c3f2c 0%, #000000 100%);
        color: white;
        border-radius: 8px 8px 0 0;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.3rem;
        color: white;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .modal-close:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1rem;
    }

    .modal-footer .btn {
        min-width: 100px;
    }

    /* Receipt Media and Customer Info Styles */
    .receipt-media {
        text-align: center;
        margin-bottom: 1rem;
    }

    .receipt-logo {
        max-width: 150px;
        height: auto;
        margin: 0 auto;
    }

    .receipt-customer-info {
        text-align: center;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        font-weight: 600;
    }

    .receipt-customer-name {
        margin-bottom: 0.25rem;
    }

    .receipt-date {
        font-size: 0.9rem;
        color: #666;
    }

    /* Products Sidebar List */
    .products-sidebar-list {
        max-height: 780px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    @media print {
        .print-modal {
            display: none !important;
        }

        * {
            margin: 0;
            padding: 0;
            background: white !important;
            color: black !important;
        }

        body {
            margin: 0;
            padding: 0;
            background: white !important;
            width: 57mm;
        }

        html {
            width: 57mm;
        }

        .cart-container {
            width: 57mm;
            margin: 0;
            padding: 0;
            background: white;
        }

        h1,
        .cart-sidebar,
        .cart-summary,
        .cart-actions,
        .sidebar-size-selection,
        .sidebar-product-header,
        .sidebar-product-info,
        .add-to-cart-sidebar-btn {
            display: none !important;
        }

        .cart-wrapper {
            display: flex !important;
            width: 57mm;
            margin: 0;
            padding: 0;
        }

        .cart-main {
            width: 57mm;
            margin: 0;
            padding: 0;
            flex: none;
        }

        .receipt-wrapper {
            display: block !important;
            width: 57mm !important;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
        }

        .receipt {
            width: 100% !important;
            page-break-after: avoid;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .receipt-header,
        .receipt-items,
        .receipt-totals,
        .receipt-footer {
            page-break-inside: avoid;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
        }

        .receipt-line-item,
        .receipt-item-top,
        .receipt-item-meta {
            display: block !important;
        }

        .receipt-remove-btn {
            display: none !important;
        }

        .receipt-media,
        .receipt-customer-info {
            display: block !important;
            page-break-inside: avoid;
        }

        button.btn.bt-sm.btn-success {
            display: none !important;
        }
    }
</style>

<script>
    // Store current print details for sales modal
    let currentPrintDetails = {
        customerName: '',
        printDate: '',
        formattedDate: ''
    };

    // Modal and Print Functions
    function openPrintDialog() {
        const modal = document.getElementById('printModal');
        const today = new Date();
        const dateStr = today.toISOString().split('T')[0];
        document.getElementById('printDate').value = dateStr;
        document.getElementById('customerName').value = '';
        document.getElementById('customerName').focus();
        modal.style.display = 'block';
    }

    function closePrintDialog() {
        const modal = document.getElementById('printModal');
        modal.style.display = 'none';
    }

    function closeSalesDialog() {
        const modal = document.getElementById('salesModal');
        modal.style.display = 'none';
    }

    function savePrintDetails() {
        const customerName = document.getElementById('customerName').value.trim();
        const printDate = document.getElementById('printDate').value;
        
        if (!customerName) {
            alert('Please enter customer name');
            return;
        }

        if (!printDate) {
            alert('Please select a date');
            return;
        }

        // Store details for sales modal
        const dateObj = new Date(printDate);
        const formattedDate = dateObj.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });

        currentPrintDetails = {
            customerName: customerName,
            printDate: printDate,
            formattedDate: formattedDate
        };

        // Update receipt with customer info
        document.getElementById('receiptCustomerName').textContent = 'Customer: ' + customerName;
        document.getElementById('receiptDate').textContent = 'Date: ' + formattedDate;

        // Close print modal
        closePrintDialog();

        // Show sales confirmation modal
        showSalesConfirmation();
    }

    function showSalesConfirmation() {
        const salesModal = document.getElementById('salesModal');
        const totalAmount = document.querySelector('.receipt-total-row span:last-child')?.textContent || '₱0.00';
        
        document.getElementById('salesCustomerDisplay').textContent = currentPrintDetails.customerName;
        document.getElementById('salesDateDisplay').textContent = currentPrintDetails.formattedDate;
        document.getElementById('salesTotalDisplay').textContent = totalAmount;
        
        salesModal.style.display = 'block';
    }

    function skipAddToSales() {
        closeSalesDialog();
        // Just print without adding to sales
        setTimeout(() => {
            printReceipt();
        }, 100);
    }

    function confirmAddToSales() {
        // Get CSRF token from the hidden input field
        const csrfTokenInput = document.getElementById('csrfToken');
        const tokenValue = csrfTokenInput ? csrfTokenInput.value : '';
        
        if (!tokenValue) {
            alert('Security token missing. Please refresh the page and try again.');
            return;
        }
        
        // Show saving indicator
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Saving...';
        button.disabled = true;
        
        // Add to sales via AJAX
        const formData = new FormData();
        formData.append('customer_name', currentPrintDetails.customerName);
        formData.append('sale_date', currentPrintDetails.printDate);
        formData.append('_csrfToken', tokenValue);

        fetch('<?= $this->Url->build(['controller' => 'Cart', 'action' => 'saveSale']) ?>', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => {
            // First check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            // Get the text first to debug
            return response.text().then(text => {
                // Try to parse as JSON
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Response text:', text);
                    throw new Error('Invalid JSON response: ' + text.substring(0, 100));
                }
            });
        })
        .then(data => {
            if (data.success) {
                // Close modal and print immediately
                closeSalesDialog();
                // Print right away
                printReceipt();
                // Reload page after printing to show empty cart
                setTimeout(() => {
                    alert('Order saved and printed successfully!');
                    location.reload();
                }, 2000);
            } else {
                alert('Error saving to sales: ' + (data.message || 'Unknown error'));
                button.textContent = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving to sales: ' + error.message);
            button.textContent = originalText;
            button.disabled = false;
        });
    }

    function printReceipt() {
        // The CSS @media print will handle hiding/showing elements
        // Just trigger the print dialog
        window.print();
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const printModal = document.getElementById('printModal');
        const salesModal = document.getElementById('salesModal');
        if (event.target === printModal) {
            closePrintDialog();
        }
        if (event.target === salesModal) {
            closeSalesDialog();
        }
    });

    // Handle size selection and price update
    document.querySelectorAll('.size-select-sidebar').forEach(select => {
        select.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            const selectedSize = this.value;
            const basePrice = parseFloat(this.getAttribute('data-base-price'));
            const priceBadge = document.querySelector(`.product-price-badge[data-product-id="${productId}"]`);
            
            if (!selectedSize) {
                // Show base price if no size selected
                priceBadge.textContent = '₱' + basePrice.toFixed(2);
                return;
            }

            // Get size-specific price
            const sizeKey = selectedSize.toLowerCase();
            const sizePrice = this.getAttribute(`data-${sizeKey}-price`);
            const priceToDisplay = sizePrice ? parseFloat(sizePrice) : basePrice;
            
            priceBadge.textContent = '₱' + priceToDisplay.toFixed(2);
        });

        // Trigger change event on page load for M size (default)
        if (select.value === 'M') {
            select.dispatchEvent(new Event('change'));
        }
    });

    document.querySelectorAll('.add-to-cart-sidebar-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const sizeSelect = document.getElementById('sidebar-size-' + productId);
            const selectedSize = sizeSelect.value;

            if (!selectedSize) {
                alert('Please select a size before adding to cart');
                return;
            }

            // Redirect to add action with product ID and size
            window.location.href = '<?= $this->Url->build(['controller' => 'Cart', 'action' => 'add']) ?>/' + productId + '/' + selectedSize;
        });
    });
</script>