<?php
    $rowPerPage = 5; //Số user trên 1 trang.
    $keyword = "";
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    }

    $sqlSearch = "SELECT * FROM account WHERE username LIKE '$keyword'";
    $query = mysqli_query($conn, $sqlSearch);
    $totalRecords = mysqli_num_rows($query); //số bản ghi lấy được.
    //Tổng số trang
    $totalPage = ceil($totalRecords/$rowPerPage);

    //lấy trang hiện tại từ đường dẫn.
    if(isset($_GET['current_page'])) {
        $current_page = $_GET['current_page'];
    }else{
        $current_page = 1;
    }
    
    if($current_page < 1) {
        $current_page = 1;
    }

    if($current_page > $totalPage) {
        $current_page = $totalPage;
    }
    // SELECT * FROM table_name LIMIT $start,$rowPerPage;
    $start = ($current_page - 1)*$rowPerPage;
    $sql_pagination = "SELECT * FROM account WHERE username LIKE '$keyword' ORDER BY id ASC LIMIT $start,$rowPerPage";
    $resultPagination = mysqli_query($conn, $sql_pagination);

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Danh sách thành viên</li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kết quả tìm kiếm: <?php echo $keyword ?></h1>
        </div>
    </div><!--/.row-->
    <div id="toolbar" class="btn-group">
        <a href="index.php?page=add_user" class="btn btn-success">
            <i class="glyphicon glyphicon-plus"></i> Thêm thành viên
        </a>
        <?php
        if (isset($_GET['err'])) {
            echo "<div class=\"alert alert-danger\">Đây là quyền hạn của Admin !</div>";
        }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table 
                        data-toolbar="#toolbar"
                        data-toggle="table">

                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="name"  data-sortable="true">Họ & Tên</th>
                            <th data-field="price" data-sortable="true">Email</th>
                            <th>Quyền</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php  if(mysqli_num_rows($resultPagination) > 0) {
                                        while ($row = mysqli_fetch_assoc($resultPagination)) {
                            ?>  
                                <tr>
                                    <td style=""><?php echo $row['id'] ?></td>
                                    <td style=""><?php echo $row['name'] ?></td>
                                    <td style=""><?php echo $row['username'] ?></td>
                                    <?php
                                        if ($row['type']=='1') {
                                            echo "<td><span class=\"label label-danger\">Admin</span></td>";
                                        } else {
                                            echo "<td><span class=\"label label-warning\">Staff</span></td>";
                                        }   
                                    ?>
                                    <td class="form-group">
                                        <a href="index.php?page=edit_user&prd_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a onclick="return confirmDel();" href="modules/user/del_user.php?prd_id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Hiển thị nút trở về trang trước -->
                            <?php if($current_page > 1) { ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $current_page-1; ?>">&laquo;</a></li>
                            <?php }else { ?>
                                <li class="page-item disabled"><a class="page-link" href="">&laquo;</a></li>
                           <?php } ?>
                            <!-- Page menu item -->
                            <?php for($i = 1; $i <= $totalPage; $i++) { 
                                    if($i > $current_page - 3 && $i < $current_page + 3) { 
                                        if($i == $current_page) {   
                            ?>
                                            <li class="page-item active"><a class="page-link" href="index.php?page=product&current_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php }else { ?>
                                            <li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                            <?php 
                                    }
                                }
                            }
                            ?>
                            <!-- Hiển thị nút next trang -->
                            <?php if($current_page < $totalPage) { ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=product&current_page=<?php echo $current_page + 1; ?>">&raquo;</a></li>
                            <?php }else {?>
                                <li class="page-item disabled"><a class="page-link disabled" href="">&raquo;</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div><!--/.row-->	
</div>	<!--/.main-->

<script>
    function confirmDel() {
        return confirm("Bạn có chắc chắn xóa?");
    }
</script>