<?php
$thu_muc_anh = 'images/';
$rowPerPage = 6;
$keyword = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
}
$arr_keyword = explode(" ", $keyword); //iphone xs => ['iphone', 'xs']
$str_keyword = '%' . implode("%", $arr_keyword) . '%'; //%iphone%xs%

$sqlSearch = "SELECT * FROM product WHERE name LIKE '$str_keyword'";
$query = mysqli_query($conn, $sqlSearch);
$totalRecords = mysqli_num_rows($query); //số bản ghi lấy được.
//Tổng số trang
$totalPage = ceil($totalRecords / $rowPerPage);

//lấy trang hiện tại từ đường dẫn.
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

if ($page < 1) {
    $page = 1;
}

if ($page > $totalPage && 0 < $totalRecords) {
    $page = $totalPage;
}
// SELECT * FROM table_name LIMIT $start,$rowPerPage;
$start = ($page - 1) * $rowPerPage;
$sql_pagination = "SELECT * FROM product WHERE name LIKE '$str_keyword' LIMIT $start,$rowPerPage";
$resultPagination = mysqli_query($conn, $sql_pagination);
?>

<!--	List Product	-->
<section class="packages" id="packages">

    <h3 class="heading-sp">
        Kết quả tìm kiếm với sản phẩm:<?php echo $keyword; ?>
    </h3>

    <div class="box-container">
    <?php
        if (mysqli_num_rows($resultPagination)) {
            while ($prd = mysqli_fetch_assoc($resultPagination)) {
    ?>
        <a href="index.php?page_layout=product&prd_id=<?php echo $prd['prdid']; ?>" >
        <div class="box">
            <img src="<?php echo $thu_muc_anh . $prd['image'] ?>" alt="">
            <div class="content">
                <h3> <?php echo $prd['name'] ?> </h3>
                <div class="price"><?php echo number_format($prd['price'],0,',','.') ?> VND</div>
            </div>
        </div>
        </a>
        <?php
            }
        } else {
        ?>
            <h3 class="heading-sp">
                <?php echo "Không có sản phẩm nào được tìm thấy!"; ?>
            </h3>
        <?php
        }
        ?>

    </div>

    <div class="more">
        <!-- Hiển thị nút next trang -->
        <?php if ($page < $totalPage) { ?>
            <a href="index.php?page_layout=search&keyword=<?php echo $keyword; ?>&page=<?php echo $page + 1; ?>" class="content">See More</a>
        <?php } else { ?>
            <a href="index.php?page_layout=search&keyword=<?php echo $keyword; ?>&page=1" class="content">See More</a>
        <?php } ?>
    </div>
</section>
<!--	End List Product	-->