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

        .catalog-action-add {
            margin-bottom: 20px;
        }

        .catalog-action-add a {
            font-size: 1.5em ;
            background-color: #9e9e9e33;;
            text-decoration: none;
            color: black;
            padding: 10px;
        }

        .catalog-action-add a:hover {
            background-color: cornflowerblue;
        }

        .catalog table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .catalog table td, .catalog table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .catalog table tr:nth-child(even){background-color: #f2f2f2;}

        .catalog table tr:hover {background-color: #ddd;}

        .catalog table th {
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .catalog-product-id {
            text-align: center;
        }

        .catalog-product-img img{
            width: 40px;
            height: 60px;
        }

    </style>

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
                    <?php /** @var \App\Framework\Model $product */
                    foreach ($products as $product) { ?>
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
