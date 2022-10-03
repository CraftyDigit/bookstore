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

        .product-form-edit {
            margin-top: 20px;
        }

        .product-field {
            width: 600px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .product-field-title {
            font-size: 1.15em;
            margin-bottom: 5px;
        }

        .product-field-note {
            color: #3a3a3a;
        }

        .product-field img {
            width: 120px;
            height: 180px;
        }

        .product-field input, .product-field textarea {
            width: 100%;
            font-size: 1.15em;
        }
    </style>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">
        <a class="pagelink" href="dashboard">Dashboard</a>

        <form class="product-form-edit" action="dashboard?productId=<?php echo $product->id?>" method="post">
            <div class="product-field">
                <div class="product-field-title">Name</div>
                <input type="text" name="product[name]" value="<?php echo $product->name; ?>" required="true">
            </div>
            <div class="product-field">
                <div class="product-field-title">Image</div>

                <?php if ($product->image) { ?>
                    <img src="<?php echo $product->image; ?>" alt="product-image">
                <?php } ?>

                <input type="text" name="product[image]" value="<?php echo $product->image; ?>" required="true">
            </div>
            <div class="product-field">
                <div class="product-field-title">Description</div>
                <textarea name="product[description]" rows="3" ><?php echo $product->description; ?></textarea>
            </div>
            <div class="product-field">
                <div class="product-field-title">Price ($)</div>
                <input type="number" step="0.01" name="product[price]" value="<?php echo $product->price; ?>" required="true">
            </div>
            <div class="product-field">
                <div class="product-field-title">Category ID</div>
                <input type="text" name="product[categoryId]" value="<?php echo $product->categoryId; ?>" required="true">
                <div class="product-field-note">Categories: <?php echo $categoryList; ?>  </div>
            </div>
            <input type="hidden" name="product[id]" value="<?php echo $product->id; ?>">
            <input type="hidden" name="point" value="<?php echo $product->id ? 'product_save' : 'product_add'; ?>">
            <div class="product-field">
                <input type="submit" value="Save">
            </div>
        </form>

        <?php if ($product->id) { ?>
            <form action="dashboard" method="post">
                <input type="hidden" name="product[id]" value="<?php echo $product->id?>">
                <input type="hidden" name="point" value="product_delete">
                <div class="product-field">
                    <input type="submit" value="Delete">
                </div>
            </form>
        <?php } ?>

    </div>

    <div class="footer"></div>

</body>
</html>
