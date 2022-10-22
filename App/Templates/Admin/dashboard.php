<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Bookstore - <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/App/Assets/Admin/css/style.css">
</head>
<body>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">

        <div class="catalog">
            <div class="catalog-actions">
                <div class="catalog-action-add"><a href="dashboard?productId=new">Add product</a></div>
            </div>
            <table>
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>
                    <tr>
                        <td class="catalog-product-id"><?php echo $product->id; ?></td>
                        <td class="catalog-product-name"><a href="?productId=<?php echo $product->id; ?>"><?php echo $product->name; ?></a></td>
                        <td class="catalog-product-img"><img src="<?php echo $product->image; ?>"></td>
                        <td class="catalog-product-description"><?php echo $product->description; ?></td>
                        <td class="catalog-product-price">$<?php echo $product->price; ?></td>
                        <td class="catalog-product-category"><?php echo $categories[$product->categoryId]; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="footer"></div>

</body>
</html>
