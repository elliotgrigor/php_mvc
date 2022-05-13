<h2>Products</h2>

<?php // IF ALL PRODUCTS
if (isset($data['products'])): ?>

    <?php foreach ($data['products'] as $product): ?>
        <p>
            <?= $product->name ?>
            <br/>
            <?= $product->description ?>
            <a href="<?= url_to('products', $product->id) ?>">Show</a>
        </p>
    <?php endforeach; ?>

<?php // IF SINGLE PRODUCT
elseif (isset($data['product'])): ?>

    <?php $product = $data['product']; ?>
    <p>
        <?= $product->name ?>
        <br/>
        <?= $product->description ?>
    </p>

<?php // IF NOTHING
else: ?>

    <p>There doesn't seem to be anything here.</p>
    
<?php endif; ?>