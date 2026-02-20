<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="products form content">
            <?= $this->Form->create($product) ?>
            <fieldset>
                <legend><?= __('Add Product') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('price', ['label' => 'Base Price']);
                    echo $this->Form->control('stock');
                ?>
                <h3>Size-Specific Prices (Optional - Leave blank to use base price)</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <?php
                        echo $this->Form->control('xs_price', ['label' => 'XS Price']);
                        echo $this->Form->control('s_price', ['label' => 'S Price']);
                        echo $this->Form->control('m_price', ['label' => 'M Price']);
                        echo $this->Form->control('l_price', ['label' => 'L Price']);
                        echo $this->Form->control('xl_price', ['label' => 'XL Price']);
                        echo $this->Form->control('xxl_price', ['label' => 'XXL Price']);
                    ?>
                </div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
