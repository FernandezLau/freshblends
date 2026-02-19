<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $total
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\SaleItem[] $sale_items
 */
class Sale extends Entity
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
        'user_id' => true,
        'total' => true,
        'created' => true,
        'user' => true,
        'sale_items' => true,
    ];
}
