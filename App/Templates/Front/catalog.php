<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Bookstore - <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/App/Assets/Front/css/style.css">
</head>
<body>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">
        <a class="pagelink" href="/">Homepage </a>
        <div class="catalog">
        <?php foreach ($categories as $category) { ?>
            <h3 class="product-category-title"><?php echo ucfirst($category->name); ?></h3>
            <div class="product-category">
            <?php foreach ($products as $product) {
                if ($category->id == $product->categoryId) { ?>
                    <div class="product">
                        <div class="product-image">
                            <img src="<?php echo $product->image ?>" alt="product-image">
                        </div>
                        <div class="product-name"><?php echo $product->name; ?></div>
                        <div class="product-price">$<?php echo $product->price; ?></div>
                    </div>
                <?php }
            } ?>
            </div>
        <?php } ?>
        </div>
    </div>

    <div class="footer"></div>

</body>
</html>