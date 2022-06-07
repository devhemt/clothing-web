<!-- cart section starts  -->

<section class="cart" id="cart">

    <div class="row">

        <div id="first">
            <p>Order Price</p>
        </div>
        <div id="divider"></div>
        <?php
        $thu_muc_anh = 'images/';
        if(isset($_SESSION['cart'])){
            $sum = 0;
            foreach($_SESSION['cart'] as $prd_id => $qty):
            $sql = "select * from product where prdid = '$prd_id'";
            $result = mysqli_query($conn,$sql);
            $each = mysqli_fetch_array($result);
            $sum += $each['price'] * $qty;
        ?>
        <div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="img-container"><img src="<?php echo $thu_muc_anh . $each['image'] ?>"></td>
                    <td class="name">
                        <span><?php echo $each['name'] ?></span>
                        <p>Dress</p>
                    </td>
                    <input type="hidden" id="prd_id" value="<?php echo $each['prdid']; ?>"/>
                    <td class="count-container">
                        <div class="count">
                            <a class="reduction"><p onclick="reduction(<?php echo $each['prdid']; ?>)">-</p></a>
                            <span id="<?php echo $each['prdid']; ?>"><?php echo number_format($qty,0,',','.') ?></span>
                            <a class="increase"><p onclick="increase(<?php echo $each['prdid']; ?>)">+</p></a>
                        </div>
                        <div class="count">
                            <a href="modules/cart/process-cart.php?action=del&prd_id=<?php echo $each['prdid']; ?>"><span>delete</span></a>
                        </div>
                    </td>
                    <td class="price-container">
                        <p><?php echo number_format($each['price'],0,',','.') ?> VND</p>
                        <p id="mes<?php echo $each['prdid']; ?>"></p>
                    </td>
                </tr>
            </table>
        </div>
        <div id="divider"></div>
        <?php endforeach ?>
        <div class="total">
            <a href="index.php">Continue Shopping</a>
            <p id="total">Total: <?php echo number_format($sum,0,',','.') ?> VND</p>
        </div>
        <?php 
        }else{
            echo "<div style=\"color:red\">Có 0 sản phẩm trong giỏ hàng!</div>";
        }    
        ?>
    </div>

</section>

<!-- cart section ends -->

<!-- customer section starts  -->
<section class="customer" id="customer">

    <div class="row">

        <form method="post" action="modules/cart/process-cart.php?action=submit">
            <h1 class="heading">
                Customer Information
            </h1>
            <div id="divider"></div>
            <div class="inputBox">
                <input type="text" placeholder="name" name="user_name" id="user_name">
                <span id="user_name_error"></span>
                <input type="email" placeholder="email" name="user_email" id="user_email">
                <span id="user_email_error"></span>
                <input type="number" placeholder="number" name="user_phone" id="user_phone">
                <span id="user_phone_error"></span>
            </div>
            <textarea placeholder="Address" name="user_address" id="user_address" cols="30" rows="10"></textarea>
            <span id="user_address_error"></span>
            <input type="submit" class="btn" onclick="return validateForm();" value="buy now">
        </form>
    </div>
    
</section>

<!-- customer section ends -->
<script language="javascript">
            function increase(varl)
            {
                $.ajax({
                    url : 'modules/cart/process-cart.php',
                    type : 'get',
                    dataType : 'json',
                    data : {
                        action : 'increase',
                        prd_id : varl
                    },
                    success : function (result){
                        let html1 = '';
                        let html2 = '';
                        let html3 = '';
                        console.log(result);
                        $.each (result, function (key, item){
                            html1 +=  item['amount'];
                            console.log(item['amount']);
                            html2 += 'Total: ';
                            html2 +=  item['sum']; 
                            console.log(item['sum']);
                            html2 += ' VND';
                            if (typeof(item['mes'])!="undefined")  {
                                html3 +=  item['mes'];
                            }

                        });

                        if ( html3!='') {
                            $('#mes'+varl.toString()).html(html3);
                        }

                        let cls = '#'+varl.toString();
                        $(cls).html(html1);
                        $('#total').html(html2);
                    }
                });
            }

            function reduction(varl)
            {
                $.ajax({
                    url : 'modules/cart/process-cart.php',
                    type : 'get',
                    dataType : 'json',
                    data : {
                        action : 'reduction',
                        prd_id : varl
                    },
                    success : function (result){
                        let html1 = '';
                        let html2 = '';
                        let html3 = '';

                        $.each (result, function (key, item){
                            html1 +=  item['amount'];
                            html2 += 'Total: ';
                            html2 +=  item['sum']; 
                            html2 += ' VND';
                            if (typeof(item['mes'])!="undefined")  {
                                html3 +=  item['mes'];
                            }

                        });

                        if ( html3!='') {
                            $('#mes').html(html3);
                        }
                        let cls = '#'+varl.toString();
                        $(cls).html(html1);
                        $('#total').html(html2);
                    }
                });
            }
            
</script>