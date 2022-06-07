<?php
    //Thêm sản phẩm
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
            if($_FILES['prd_image']['error'] > 0) {
                $prd_image = 'no-img.png';
            }else{
                $tmp_name = $_FILES['prd_image']['tmp_name'];
                $target_file = "../images/".$_FILES['prd_image']['name'];
                move_uploaded_file($tmp_name,$target_file);
                $prd_image = $_FILES['prd_image']['name'];
            }
        }


        $sqlInsert = "INSERT INTO product(image, name, description, price) VALUES 
        ('$prd_image', '$prd_name', '$prd_details', '$prd_price')";
        mysqli_query($conn, $sqlInsert);

        $sqlmaxid = "SELECT * FROM product ORDER BY prdid DESC LIMIT 1";
        $resultmaxid = mysqli_query($conn, $sqlmaxid);
        $maxid = mysqli_fetch_assoc($resultmaxid);
        $nowid = $maxid['prdid'];
        $flag = false;
        if (isset($prd_size)&&isset($prd_color)&&isset($prd_amount)) {
            $a = count($prd_size);
            $b = count($prd_color);
            $c = count($prd_amount);
            if ($a=$b&&$b=$c) {
                for ($i=0; $i < count($prd_size) ; $i++) { 
                    $color = $prd_color[$i];
                    $size = strtoupper($prd_size[$i]);
                    $amount = $prd_amount[$i];
                    $sqlnature = "INSERT INTO nature(itemsid, size, color, amount) VALUES
                    ('$nowid', '$size', '$color', '$amount')";
                    mysqli_query($conn, $sqlnature);
                    $flag = true;
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
                    ('$nowid', '$size1', '$color1')";
                    mysqli_query($conn, $sqlnature1);
                }
            } else {
                for ($i=0; $i < $f ; $i++) { 
                    $color1 = $d[$i];
                    $size1 = strtoupper($c[$i]);
                    $sqlnature1 = "INSERT INTO nature1(itemsid, size, color) VALUES
                    ('$nowid', '$size1', '$color1')";
                    mysqli_query($conn, $sqlnature1);
                }
            }
            


        }


        if (isset($prd_category)) {
            $sqlcategory = "INSERT INTO category(itemsid, category) VALUES
            ('$nowid', '$prd_category')";
            mysqli_query($conn, $sqlcategory);
        }
        


        if($flag) {
            header("location: index.php?page=product"); 
        }else{
            echo "<script>alert('Thêm sản phẩm không thành công');</script>";
        }
}   
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="">Quản lý sản phẩm</a></li>
            <li class="active">Thêm sản phẩm</li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Thêm sản phẩm</h1>
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
                                <input required name="prd_name" class="form-control" placeholder="">
                            </div>
                                                            
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input required name="prd_price" type="number" min="0" class="form-control">
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
                                            <td><input required name="prd_size" type="text" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Color</th>
                                            <td><input required name="prd_color" type="text" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td><input required name="prd_amount" type="text" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ảnh sản phẩm</label>
                                <input required name="prd_image" type="file" onchange="preview();">
                                <br>
                                <div>
                                    <img id="prd_image" width="150px" height="200px" src="img/no-img.png">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select name="prd_category" class="form-control">
                                    <option value="0">-- Lựa chọn --</option>
                                    <option value="dress">-- Dress --</option>
                                    <option value="accessories">-- Accessories --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                    <label>Mô tả sản phẩm</label>
                                    <textarea required name="prd_details" class="form-control" rows="3"></textarea>
                                </div>
                            <button name="sbm" type="submit" class="btn btn-success">Thêm mới</button>
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