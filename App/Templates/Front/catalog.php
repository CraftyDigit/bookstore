<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Bookstore - <?php echo $pageTitle; ?></title>
</head>
<body>

    <style>
        body {
            background-color: azure;
        }

        .header, .content {
            padding: 20px;
        }

        .pagelink {
            font-size: 2em ;
            background-color: #9e9e9e33;;
            text-decoration: none;
            color: black;
            padding: 10px;
        }

        .pagelink:hover {
            background-color: cornflowerblue;
        }

        .catalog {
            margin: 40px 0;
        }

        .product-category-title {
            background-color: #04AA6D;
            color: white;
            padding: 8px;
        }

        .product-category {
            display: flex;
            gap: 20px;
        }

        .product {
            width: 200px;
        }

        .product-image{
            width: 200px;
            height: 300px;
            margin-bottom: 20px;
        }

        .product-image img{
            width: 100%;
            height: 100%;
        }

        .product-name, .product-price {
            text-align: center;
        }

        .product-price {
            font-weight: bold;
        }
    </style>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">
        <a class="pagelink" href="/">Homepage </a>
        <div class="catalog">
        <?php foreach ($categories as $categoryId => $categoryData) { ?>
            <h3 class="product-category-title"><?php echo ucfirst($categoryData['name']); ?></h3>
            <div class="product-category">
            <?php /** @var \App\Framework\Model $product */
            foreach ($products as $product) {
                if ($categoryData['id'] == $product->categoryId) { ?>
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