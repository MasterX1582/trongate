<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Your page title here :)</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    
    <link rel="stylesheet" href="<?= BASE_URL ?>../../css/skeleton.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>../../css/normalize.css">
    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>../../images/favicon.png">
    <!-- load the css file from the cart folder (cart module) -->
    <link rel="stylesheet" href="cart_module/css/cart.css">
  </head>
  <body>
    <!-- add top_nav file from templates/top_nav.php -->
    <!-- <?= Template::partial('top_nav') ?> -->
    
    <!-- Primary Page Layout
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <div class="container">
      <div class="row">
        <!-- add content from books module -->
        <?= Template::display($data) ?>
      </div>

      <?= Template::partial('footer') ?>
    </div>
    <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  </body>
</html>