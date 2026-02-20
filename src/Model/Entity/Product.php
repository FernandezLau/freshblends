<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $stock
 * @property string|null $xs_price
 * @property string|null $s_price
 * @property string|null $m_price
 * @property string|null $l_price
 * @property string|null $xl_price
 * @property string|null $xxl_price
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\SaleItem[] $sale_items
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'price' => true,
        'stock' => true,
        'xs_price' => true,
        's_price' => true,
        'm_price' => true,
        'l_price' => true,
        'xl_price' => true,
        'xxl_price' => true,
        'created' => true,
        'modified' => true,
        'sale_items' => true,
    ];
}
