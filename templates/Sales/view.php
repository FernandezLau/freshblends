<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale $sale
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sale'), ['action' => 'edit', $sale->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sale'), ['action' => 'delete', $sale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sale->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sale'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sales view content">
            <h3><?= h($sale->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $sale->hasValue('user') ? $this->Html->link($sale->user->username, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sale->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($sale->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($sale->created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Sale Items') ?></h4>
                <?php if (!empty($sale->sale_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Price') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($sale->sale_items as $saleItem) : ?>
                        <tr>
                            <td><?= h($saleItem->id) ?></td>
                            <td><?= h($saleItem->product_id) ?></td>
                            <td><?= h($saleItem->quantity) ?></td>
                            <td><?= h($saleItem->price) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SaleItems', 'action' => 'view', $saleItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SaleItems', 'action' => 'edit', $saleItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'SaleItems', 'action' => 'delete', $saleItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $saleItem->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>