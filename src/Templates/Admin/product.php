<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Bookstore - <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/src/Assets/Admin/css/style.css">
</head>
<body>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">
        <a class="pagelink" href="/admin/dashboard">Dashboard</a>

        <form class="product-form-edit" action="/admin/dashboard/products/<?php echo $product->id ? 'edit?id=' . $product->id : 'add'; ?>" method="post">
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
                <div class="product-field-title">Category</div>
                <select name="product[categoryId]" value="<?php echo $product->categoryId; ?>" required="true">
                    <?php
                    foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $product->categoryId == $category->id ? 'selected' : ''; ?>><?php echo $category->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="product[id]" value="<?php echo $product->id; ?>">
            <div class="product-field">
                <input type="submit" value="Save">
            </div>
        </form>

        <?php if ($product->id) { ?>
            <form action="/admin/dashboard/products/delete" method="post">
                <input type="hidden" name="product[id]" value="<?php echo $product->id?>">
                <div class="product-field">
                    <input type="submit" value="Delete">
                </div>
            </form>
        <?php } ?>

    </div>

    <div class="footer"></div>

</body>
</html>
