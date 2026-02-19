<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CartController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CartController Test Case
 *
 * @link \App\Controller\CartController
 */
class CartControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Cart',
    ];
}
