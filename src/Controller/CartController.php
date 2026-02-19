<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Cart Controller
 *
 */
class CartController extends AppController
{

  public function index()
{
    $session = $this->request->getSession();
    $cart = $session->read('Cart') ?? [];

    $cartItems = [];
    $total = 0;

    if (!empty($cart)) {
        $productsTable = $this->fetchTable('Products');

        // Extract product IDs from cart keys (format: productId_size)
        $productIds = [];
        $cartDetails = [];
        
        foreach (array_keys($cart) as $cartKey) {
            $parts = explode('_', $cartKey);
            $productId = $parts[0];
            $size = isset($parts[1]) ? $parts[1] : 'M';
            $productIds[] = $productId;
            $cartDetails[$cartKey] = ['product_id' => $productId, 'size' => $size];
        }

        $products = $productsTable
            ->find()
            ->where(['id IN' => array_unique($productIds)])
            ->all();

        // Map products with their cart details
        foreach ($products as $product) {
            foreach ($cartDetails as $cartKey => $details) {
                if ((int)$details['product_id'] === (int)$product->id) {
                    $cartItems[$cartKey] = [
                        'product' => $product,
                        'quantity' => $cart[$cartKey],
                        'size' => $details['size']
                    ];
                    $total += $product->price * $cart[$cartKey];
                }
            }
        }
    }

    $this->set(compact('cart', 'cartItems', 'total'));
}

    public function add($productId, $size = 'M')
    {
        $session = $this->request->getSession();
        $cart = $session->read('Cart') ?? [];

        // Create a unique key combining product ID and size
        $cartKey = $productId . '_' . $size;
        
        $cart[$cartKey] = ($cart[$cartKey] ?? 0) + 1;

        $session->write('Cart', $cart);
        return $this->redirect($this->referer());
    }

    public function clear()
    {
        $this->request->getSession()->delete('Cart');
        return $this->redirect(['action' => 'index']);
    }

    public function remove($productId, $size = 'M')
    {
        $session = $this->request->getSession();
        $cart = $session->read('Cart') ?? [];

        $cartKey = $productId . '_' . $size;
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
        }

        $session->write('Cart', $cart);
        return $this->redirect(['action' => 'index']);
    }
}
