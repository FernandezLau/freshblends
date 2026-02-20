<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<div class="products-container">
    <div class="products-header">
        <h1>Products</h1>
        <?= $this->Html->link(__('Add New Product'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-info">
                    <h3><?= h($product->name) ?></h3>
                    <div class="product-price">
                        <span>₱<?= number_format($product->price, 2) ?></span>
                    </div>
                    <div class="product-stock">
                        <span class="stock-label">Stock:</span>
                        <span class="stock-value"><?= $product->stock ?></span>
                    </div>
                </div>

                <div class="product-size-selection">
                    <label for="size-<?= $product->id ?>">Select Size:</label>
                    <select id="size-<?= $product->id ?>" class="size-select" data-product-id="<?= $product->id ?>">
                        <option value="">-- Choose Size --</option>
                        <option value="XS">Extra Small (XS)</option>
                        <option value="S">Small (S)</option>
                        <option value="M" selected>Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                        <option value="XXL">2XL (XXL)</option>
                    </select>
                </div>

                <div class="product-actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $product->id], ['class' => 'btn btn-info btn-small']) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id], ['class' => 'btn btn-warning btn-small']) ?>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $product->id],
                        [
                            'class' => 'btn btn-danger btn-xsmall',
                            'method' => 'delete',
                            'confirm' => __('Are you sure?'),
                        ]
                    ) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const sizeSelect = document.getElementById('size-' + productId);
            const size = sizeSelect.value;
            
            if (!size) {
                alert('Please select a size');
                return;
            }
            
            // Redirect to cart add with product id and size
            window.location.href = '<?= $this->Url->build(['controller' => 'Cart', 'action' => 'add']) ?>/' + productId + '/' + size;
        });
    });
});
</script>