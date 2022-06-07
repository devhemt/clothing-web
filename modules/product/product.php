<?php 
    if(isset($_GET['prd_id'])) {
        $prd_id = $_GET['prd_id'];
        $sql = "SELECT * FROM product WHERE prdid=$prd_id";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_array($result);
        $thu_muc_anh = 'images/';
        $dem = mysqli_num_rows($result);


        $sqlnat = "SELECT * FROM nature1 WHERE itemsid=$prd_id";
        $resultnat = mysqli_query($conn, $sqlnat);
        $sqlnat1 = "SELECT * FROM nature1 WHERE itemsid=$prd_id";
        $resultnat1 = mysqli_query($conn, $sqlnat1);
    }else{
        header("location: index.php");
    }
?>

<!-- product section starts  -->

<section class="product" id="product">

    <div class="row">

        <div class="image">
            <img src="<?php echo $thu_muc_anh . $product['image'] ?>" alt="">
        </div>


        <div class="product-details">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2"><h1><?php echo $product['name'] ?></h1></td>
                    <td><img src="images/Logo.png"></td>
                </tr>
                <tr>
                    <td colspan="3"><h3>category</h3></td>
                </tr>
                <tr>
                    <td colspan="3">
                    <span>COLOR:</span>
                    <div class="color-container">
                        <?php
                            while($each = mysqli_fetch_array($resultnat)) {
                                if ($each['color'] != "") {
                        ?>
                        <div id="colors" class="colors" style="background-color:<?php echo $each['color']?>;">
                        <input type="hidden" value="<?php echo $each['color']?>" class="colors active"/>
                        </div>
                        <?php 
                                }
                            }
                        ?>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <span>SIZE:</span>
                    <div class="size-container">
                        <?php
                            while($each = mysqli_fetch_array($resultnat1)) {
                                
                        ?>
                        <div id="sizes" class="sizes"><?php echo $each['size']?>
                        <input type="hidden" value="<?php echo $each['size']?>" class="sizes active"/>
                        </div>
                        <?php 
                            }
                        ?>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <div class="status-container">
                        <span id="statuss"></span>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                    <div class="details-container">
                        <span>Description:</span>
                        <p id="des-container"><?php echo $product['description'] ?></p>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td id="price"><?php echo number_format($product['price'],0,',','.') ?> VND</td>
                    <td colspan="2">
                    <div class="add-cart">
                        <form  method="post" action="modules/cart/process-cart.php?action=add&prd_id=<?php echo $product['prdid']; ?>">
                            <input type="hidden" name="size" id="size" value="">
                            <input type="hidden" name="color" id="color" value="">
                            <input type="submit" class="subhidden" id="subhidden" value="ADD TO CART">
                        </form>
                        <input type="hidden" name="prdid" id="prdid" value="<?php echo $product['prdid']; ?>">
                    </div>
                    </td>
                </tr>
            </table>

        </div>


    </div>

</section>

<!-- product section ends -->

<!-- comment section starts  -->

<section class="comment" id="comment">

    <div class="row">

        <p id="title">Comment and Review</p>

        <div class="comment-container">
            <div>
                <img src="images/image1.png" alt="">
                <p id="author">Author</p>
                <p id="date">hhhh</p>    
            </div>
            <div id="heart">
                <span>125</span>
                <i class="fas fa-heart"></i>
            </div>
            <p id="content">This is my very first order through site, and I am totally and completely satisfied! The fit is great and so are the prices. I will definitely return again and again...</p>
        </div>
        <div id="divider"></div>
        <div class="cmt-content">
            <form method="post" action="">
                <textarea placeholder="Left a comment here" name="" id="" cols="30" rows="10"></textarea>
                <input type="submit" id="submit" value="send message">
            </form>
        </div>
    </div>

</section>

<!-- comment section ends -->

<script language="javascript">
            $('#sizes').click(function()
            {
                let colorvalue = document.getElementsByClassName('colors active');
                let sizevalue = document.getElementsByClassName('sizes active');

                if (colorvalue.length==2&&sizevalue.length==2) {
                    color.value = colorvalue[1].value;
                    size.value = sizevalue[1].value;
                    $.ajax({
                        url : 'modules/product/amount-check.php',
                        type : 'get',
                        dataType : 'text',
                        data : {
                            color : $('#color').val(),
                            size : $('#size').val(),
                            prdid : $('#prdid').val()
                        },
                        success : function (result){   
                            $('#statuss').html(result);
                        }
                    }); 
                }
                
            });
            $('#colors').click(function()
            {
                let colorvalue = document.getElementsByClassName('colors active');
                let sizevalue = document.getElementsByClassName('sizes active');

                if (colorvalue.length==2&&sizevalue.length==2) {
                    color.value = colorvalue[1].value;
                    size.value = sizevalue[1].value;
                    $.ajax({
                        url : 'modules/product/amount-check.php',
                        type : 'get',
                        dataType : 'text',
                        data : {
                            color : $('#color').val(),
                            size : $('#size').val(),
                            prdid : $('#prdid').val()
                        },
                        success : function (result){   
                            $('#statuss').html(result);
                        }
                    }); 
                }
                
            });
</script>