<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaleItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaleItemsTable Test Case
 */
class SaleItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SaleItemsTable
     */
    protected $SaleItems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SaleItems',
        'app.Sales',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SaleItems') ? [] : ['className' => SaleItemsTable::class];
        $this->SaleItems = $this->getTableLocator()->get('SaleItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SaleItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SaleItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\SaleItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
