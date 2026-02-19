<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'price' => 1.5,
                'stock' => 1,
                'created' => '2026-02-19 02:48:33',
                'modified' => '2026-02-19 02:48:33',
            ],
        ];
        parent::init();
    }
}
