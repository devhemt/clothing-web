<?php 
    session_start();
    include_once "config/connectDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothings</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/success.css">
    <link rel="stylesheet" href="css/order.css">

</head>
<body>
    
<!-- header section starts  -->

<header>

    <div id="menu-bar" class="fas fa-bars"></div>

    <a href="index.php" class="logo"><img src="images/logo.png"></a>

    <nav class="navbar">
        <a href="index.php">home</a>
        <a href="index.php?page_layout=sale">sale</a>
        <a href="index.php?page_layout=dresses">dresses</a>
        <a href="index.php?page_layout=accessories">accessories</a>
    </nav>

    <?php include_once "modules/search/search_box.php"; ?>

    <div class="icons" id="user-container">
        <a href="index.php?page_layout=cart"><img src="images/cart.png"></a>
        <a href="admin/index.php"><img src="images/User.png"></a>
        <div class="user-used" id="user-used">
            <a href="index.php?page_layout=order"> Order </a>
            <a href="#"> Login </a>
        </div>
    </div>

    <script>
        let scroll = document.getElementById('user-used');
        $('#user-container').hover(function(){
        scroll.classList.add('active');
        });
        $('#user-container').mouseleave(function(){
        scroll.classList.remove('active');
        });
        
    </script>
</header>

<!-- header section ends -->

<!-- home section starts  -->

<?php include_once "modules/slide/slide.php"; ?>

<!-- home section ends -->
                <?php 
                    if(isset($_GET['page_layout'])) {
                        switch ($_GET['page_layout']) {
                            case 'product':
                                include_once "modules/product/product.php";
                                include_once "modules/contact/contact.php";
                                break;
                            case 'sale':
                                include_once "modules/category/category.php";
                                include_once "modules/product/sale.php";
                                include_once "modules/brand/brand.php";
                                include_once "modules/contact/contact.php";
                                break;
                            case 'dresses':
                                include_once "modules/category/category.php";
                                include_once "modules/product/dresses.php";
                                include_once "modules/brand/brand.php";
                                include_once "modules/contact/contact.php";
                                break;
                            case 'accessories':
                                include_once "modules/category/category.php";
                                include_once "modules/product/accessories.php";
                                include_once "modules/brand/brand.php";
                                include_once "modules/contact/contact.php";
                                break;
                            case 'search':
                                include_once "modules/search/search.php";
                                break;
                            case 'cart':
                                include_once "modules/cart/cart.php";
                                break;
                            case 'success':
                                include_once "modules/cart/success.php";
                                break;
                            case 'order':
                                include_once "modules/order/order.php";
                                break;
                        }
                    }else{
                        include_once "modules/category/category.php";
                        include_once "modules/product/packages.php";
                        include_once "modules/brand/brand.php";
                        include_once "modules/contact/contact.php";
                    } 
                ?>
<!-- banner section starts  -->

<?php include_once "modules/banner/banner.php"; ?>

<!-- banner section ends -->

<!-- footer section  -->

<?php include_once "modules/footer/footer.php"; ?>
















<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/index.js"></script>

</body>
</html>