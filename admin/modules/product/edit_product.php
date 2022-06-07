<?php
    //Lấy các thông tin của sản phẩm cần sửa
    if(isset($_GET['prd_id'])) {
     $prd_id = $_GET['prd_id'];

    //thông tin nature
    $sqlnature = "SELECT * FROM nature WHERE itemsid = $prd_id";
    $resultnat = mysqli_query($conn, $sqlnature);
    $str_color = "";
    $str_size = "";
    $str_amount = "";
    while($each = mysqli_fetch_array($resultnat)) {
        $str_color.=' '.$each['color'];
        $str_size.=' '.$each['size'];
        $str_amount.=' '.$each['amount'];
    }
    $str_color = trim($str_color);
    $str_size = trim($str_size);
    $str_amount = trim($str_amount);
    //Hiển thị các danh mục
    $sqlCategory = "SELECT * FROM category WHERE itemsid = $prd_id";
    $resultCategory = mysqli_query($conn, $sqlCategory);
    $prodcate = mysqli_fetch_array($resultCategory);
    //thong tin san pham
     $sqlProd = "SELECT * FROM product WHERE prdid = $prd_id";
     $resultProd = mysqli_query($conn, $sqlProd);
     $prodEdit = mysqli_fetch_assoc($resultProd);
     //Sửa sản phẩm
     //Lấy thông tin mới
     if(isset($_POST['sbm'])) {
        if(empty($_POST['prd_name'])) {
            echo "Bạn chưa nhập tên sản phẩm!";
        }else{
            $prd_name = $_POST['prd_name'];
        }
        if(empty($_POST['prd_price'])) {
            echo "Bạn chưa nhập giá sản phẩm!";
        }else{
            $prd_price = $_POST['prd_price'];
        }
        if(isset($_POST['prd_promotion'])) {
            $prd_promotion = $_POST['prd_promotion'];
        }
        if(empty($_POST['prd_category'])) {
            echo "Bạn chưa nhập danh mục sản phẩm!";
        }else{
            $prd_category = $_POST['prd_category'];
        }
        if(empty($_POST['prd_details'])) {
            echo "Bạn chưa nhập mô tả sản phẩm!";
        }else{
            $prd_details = $_POST['prd_details'];
        }
        if(empty($_POST['prd_size'])) {
            echo "Bạn chưa nhập size sản phẩm!";
        }else{
            $prd_size = explode(' ', $_POST['prd_size']);
        }
        if(empty($_POST['prd_color'])) {
            echo "Bạn chưa nhập màu sản phẩm!";
        }else{
            $prd_color = explode(' ', $_POST['prd_color']);
        }
        if(empty($_POST['prd_amount'])) {
            echo "Bạn chưa nhập số lượng sản phẩm!";
        }else{
            $prd_amount = explode(' ', $_POST['prd_amount']);
        }
         
        if(isset($_FILES['prd_image'])) {
            if($_FILES['prd_image']['name']) {
                if($_FILES['prd_image']['error'] > 0) {
                    $prd_image = 'no-img.png';
                }else{
                    $tmp_name = $_FILES['prd_image']['tmp_name'];
                    $target_file = "images/".$_FILES['prd_image']['name'];
                    move_uploaded_file($tmp_name,$target_file);
                    $prd_image = $_FILES['prd_image']['name'];
                }
            }else{
                $prd_image = $prodEdit['image'];
            }
            
        }else{
            $prd_image = $prodEdit['image'];
        }



        if (isset($prd_size)&&isset($prd_color)&&isset($prd_amount)) {
            $a = count($prd_size);
            $b = count($prd_color);
            $c = count($prd_amount);
            if ($a=$b&&$b=$c) {
                $sqlreset = "DELETE FROM nature WHERE itemsid=$prd_id";
                mysqli_query($conn, $sqlreset);
                $sqlreset1 = "DELETE FROM nature1 WHERE itemsid=$prd_id";
                mysqli_query($conn, $sqlreset1);
                for ($i=0; $i < count($prd_size) ; $i++) { 
                    $color = $prd_color[$i];
                    $size = strtoupper($prd_size[$i]);
                    $amount = $prd_amount[$i];
                    $sqlnature = "INSERT INTO nature(itemsid, size, color, amount) VALUES
                    ('$prd_id', '$size', '$color', '$amount')";
                    mysqli_query($conn, $sqlnature);
                }
            }else {
                echo "nhập sai định dạng";
            }
            $c = explode(' ',implode(' ',array_unique(explode(' ', $_POST['prd_size']))));
            $d = explode(' ',implode(' ',array_unique(explode(' ', $_POST['prd_color']))));
            $e = count($c);
            $f = count($d);
            if ($e>$f) {
                for ($i=0; $i < $e ; $i++) { 
                    $color1 = $d[$i];
                    $size1 = strtoupper($c[$i]);
                    $sqlnature1 = "INSERT INTO nature1(itemsid, size, color) VALUES
                    ('$prd_id', '$size1', '$color1')";
                    mysqli_query($conn, $sqlnature1);
                }
            } else {
                for ($i=0; $i < $f ; $i++) { 
                    $color1 = $d[$i];
                    $size1 = strtoupper($c[$i]);
                    $sqlnature1 = "INSERT INTO nature1(itemsid, size, color) VALUES
                    ('$prd_id', '$size1', '$color1')";
                    mysqli_query($conn, $sqlnature1);
                }
            }
            


        }




        if (isset($prd_category)) {
            $sqlcategory = "UPDATE category SET
                category = '$prd_category'
                WHERE itemsid = $prd_id
            ";
            mysqli_query($conn, $sqlcategory);
        }


        $sqlUpdate = "UPDATE product SET
                image = '$prd_image',
                name = '$prd_name',
                description = '$prd_details',
                price = $prd_price
                WHERE prdid = $prd_id
        ";

        if(mysqli_query($conn, $sqlUpdate)) {
            header("location: index.php?page=product");
        }else{
            echo "<script>alert('Cập nhật sản phẩm không thành công');</script>";
        }
    }
    }else{
    header('location: index.php?page=product');
    }   
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="">Quản lý sản phẩm</a></li>
            <li class="active"><?php echo $prodEdit['name'];  ?></li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sản phẩm: <?php echo $prodEdit['name'];  ?></h1>
        </div>
    </div><!--/.row-->
    <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6">
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="prd_name" required class="form-control" value="<?php echo $prodEdit['name'];  ?>"  placeholder="">
                            </div>
                                                            
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="number" name="prd_price" required value="<?php echo $prodEdit['price'];  ?>" class="form-control">
                            </div>               
                            <div class="form-group">
                                <label>Khuyến mãi</label>
                                <input name="prd_promotion" type="text" class="form-control">
                            </div>  
                            <div class="form-group">
                                <label>Nature:</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Specifications</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Size</th>
                                            <td><input required name="prd_size" type="text" value="<?php echo $str_size; ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Color</th>
                                            <td><input required name="prd_color" type="text" value="<?php echo $str_color; ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td><input required name="prd_amount" type="text" value="<?php echo $str_amount; ?>" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ảnh sản phẩm</label>
                                <input name="prd_image" type="file" onchange="preview();">
                                <br>
                                <div>
                                    <img width="150px" height="200px" id="prd_image" src="../images/<?php echo $prodEdit['image'];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select name="prd_category" class="form-control">
                                    <?php 
                                        if ($prodcate['category'] == '0') {
                                            echo "<option selected value=\"0\">-- Lựa chọn --</option>";
                                            echo "<option value=\"dress\">-- Dress --</option>";
                                            echo "<option value=\"accessories\">-- Accessories --</option>";
                                        }
                                        if ($prodcate['category'] == 'dress') {
                                            echo "<option value=\"0\">-- Lựa chọn --</option>";
                                            echo "<option selected value=\"dress\">-- Dress --</option>";
                                            echo "<option value=\"accessories\">-- Accessories --</option>";
                                        }
                                        if ($prodcate['category'] == 'accessories') {
                                            echo "<option value=\"0\">-- Lựa chọn --</option>";
                                            echo "<option value=\"dress\">-- Dress --</option>";
                                            echo "<option selected value=\"accessories\">-- Accessories --</option>";
                                        }
                                        
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                    <label>Mô tả sản phẩm</label>
                                    <textarea name="prd_details" required class="form-control" rows="3"><?php echo $prodEdit['description']; ?></textarea>
                                </div>
                            <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div><!-- /.col-->
        </div><!-- /.row -->
    
</div>	<!--/.main-->	

<script>
    function preview() {
        prd_image.src=URL.createObjectURL(event.target.files[0]);
    }
</script>