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
    $productsTable = $this->fetchTable('Products');

    if (!empty($cart)) {
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
                    // Get size-specific price or fall back to base price
                    $size = $details['size'];
                    $priceField = strtolower($size) . '_price';
                    
                    // Safely get size-specific price
                    $sizePrice = null;
                    if (method_exists($product, 'get')) {
                        $sizePrice = $product->get($priceField);
                    } else {
                        $sizePrice = $product->$priceField ?? null;
                    }
                    
                    // Use size price if it exists and is not empty, otherwise use base price
                    $sizePrice = (!empty($sizePrice)) ? $sizePrice : $product->price;
                    
                    $cartItems[$cartKey] = [
                        'product' => $product,
                        'quantity' => $cart[$cartKey],
                        'size' => $details['size'],
                        'size_price' => (float)$sizePrice
                    ];
                    $total += $sizePrice * $cart[$cartKey];
                }
            }
        }
    }

    // Fetch all products for the right sidebar
    $allProducts = $productsTable->find()->all();

    $this->set(compact('cart', 'cartItems', 'total', 'allProducts'));
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

    public function saveSale()
    {
        $this->request->allowMethod(['post']);
        $this->disableAutoRender();
        $this->response = $this->response->withType('application/json');

        try {
            $session = $this->request->getSession();
            $cart = $session->read('Cart') ?? [];

            if (empty($cart)) {
                $this->response->getBody()->write(json_encode(['success' => false, 'message' => 'Cart is empty']));
                return $this->response;
            }

            $data = $this->request->getData();
            $customerName = $data['customer_name'] ?? null;
            $saleDate = $data['sale_date'] ?? date('Y-m-d');

            if (!$customerName) {
                $this->response->getBody()->write(json_encode(['success' => false, 'message' => 'Customer name is required']));
                return $this->response;
            }

            // Fetch cart items with product details
            $cartItems = [];
            $total = 0;
            $productsTable = $this->fetchTable('Products');

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

            foreach ($products as $product) {
                foreach ($cartDetails as $cartKey => $details) {
                    if ((int)$details['product_id'] === (int)$product->id) {
                        $size = $details['size'];
                        $priceField = strtolower($size) . '_price';
                        $sizePrice = $product->$priceField ?? $product->price;
                        $sizePrice = (!empty($sizePrice)) ? $sizePrice : $product->price;
                        
                        $cartItems[$cartKey] = [
                            'product' => $product,
                            'quantity' => $cart[$cartKey],
                            'size' => $details['size'],
                            'size_price' => (float)$sizePrice
                        ];
                        $total += $sizePrice * $cart[$cartKey];
                    }
                }
            }

            // Create a new sale with the customer name
            $salesTable = $this->fetchTable('Sales');
            $sale = $salesTable->newEmptyEntity();
            
            // Fetch users table
            $usersTable = $this->fetchTable('Users');
            
            // Try to find or create a user with the customer name
            $user = $usersTable->find()
                ->where(['username' => $customerName])
                ->first();
            
            if (!$user) {
                // Create a new user for this customer
                $user = $usersTable->newEmptyEntity();
                $user->username = $customerName;
                $user->email = $customerName . '@pos.local';
                $user->password = password_hash('customer123', PASSWORD_BCRYPT);
                $user->role = 'customer';
                
                if (!$usersTable->save($user)) {
                    $this->response->getBody()->write(json_encode([
                        'success' => false, 
                        'message' => 'Failed to create customer user: ' . implode(', ', array_keys($user->getErrors()))
                    ]));
                    return $this->response;
                }
            }

            $sale->user_id = $user->id;
            $sale->total = $total;
            $sale->created = $saleDate;

            if ($salesTable->save($sale)) {
                // Add sale items
                $saleItemsTable = $this->fetchTable('SaleItems');
                
                foreach ($cartItems as $cartKey => $item) {
                    $saleItem = $saleItemsTable->newEmptyEntity();
                    $saleItem->sale_id = $sale->id;
                    $saleItem->product_id = $item['product']->id;
                    $saleItem->quantity = $item['quantity'];
                    $saleItem->price = $item['size_price'];
                    
                    $saleItemsTable->save($saleItem);
                }

                // Clear the cart
                $session->delete('Cart');

                $this->response->getBody()->write(json_encode([
                    'success' => true, 
                    'message' => 'Sale saved successfully', 
                    'sale_id' => $sale->id
                ]));
                return $this->response;
            } else {
                $this->response->getBody()->write(json_encode([
                    'success' => false, 
                    'message' => 'Failed to save sale: ' . implode(', ', array_keys($sale->getErrors()))
                ]));
                return $this->response;
            }

        } catch (\Exception $e) {
            $this->response->getBody()->write(json_encode([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
}
