<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-brand">
            <?= $this->Html->link('POS System', '/') ?>
        </div>
        <div class="navbar-menu">
            <ul class="navbar-list">
                <!-- <li class="navbar-item">
                    <?= $this->Html->link('Home', ['controller' => 'Pages', 'action' => 'display', 'home']) ?>
                </li> -->
                <li class="navbar-item">
                    <?= $this->Html->link('Products', ['controller' => 'Products', 'action' => 'index']) ?>
                </li>
                <li class="navbar-item">
                    <?= $this->Html->link('Sales', ['controller' => 'Sales', 'action' => 'index']) ?>
                </li>
                <li class="navbar-item">
                    <?= $this->Html->link('Cart', ['controller' => 'Cart', 'action' => 'index']) ?>
                </li>
            
            </ul>
        </div>
    </div>
</nav>
