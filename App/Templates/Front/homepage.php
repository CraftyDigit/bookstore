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
    </style>

    <div class="header">
        <h1>"Simple Bookstore" - <?php echo $pageTitle; ?></h1>
    </div>

    <div class="content">
        <a class="pagelink" href="catalog">Catalog</a>
    </div>

    <div class="footer"></div>

</body>
</html>