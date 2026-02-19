<div class="cart-container">
    <h1>Shopping Cart</h1>

    <?php if (empty($cart)): ?>
        <div class="empty-cart">
            <p>Your cart is empty</p>
            <?= $this->Html->link('Continue Shopping', ['controller' => 'Products', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else: ?>
        <div class="cart-items">
            <?php foreach ($cartItems as $cartKey => $item): ?>
                <div class="cart-card">
                    <div class="card-header">
                        <h3><?= h($item['product']->name) ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="product-size">
                            <span class="size-label">Size:</span>
                            <span class="size-value"><?= h($item['size']) ?></span>
                        </div>
                        <div class="product-price">
                            <span class="price-label">Price:</span>
                            <span class="price-value">₱<?= number_format($item['product']->price, 2) ?></span>
                        </div>
                        <div class="product-quantity">
                            <span class="qty-label">Quantity:</span>
                            <span class="qty-value"><?= $item['quantity'] ?></span>
                        </div>
                        <div class="product-subtotal">
                            <span class="subtotal-label">Subtotal:</span>
                            <span class="subtotal-value">₱<?= number_format($item['product']->price * $item['quantity'], 2) ?></span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?= $this->Html->link('Remove', ['controller' => 'Cart', 'action' => 'remove', $item['product']->id, $item['size']], ['class' => 'btn btn-danger btn-small']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
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
                <button class="btn btn-info" onclick="window.print()">Print Receipt</button>
            </div>
        </div>
    <?php endif; ?>
</div>
