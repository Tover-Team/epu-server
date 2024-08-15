
<?php
include_once('./header.php');
?>
    <div class="viewDetail1">
        <?php
        include("dbconfig.php");
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $page = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $list = 10;
        $block = 3;
        $sql = "SELECT COUNT(*) FROM g5_member";
        $num = mysqli_query($conn, $sql);

        $pageNum = ceil($num + 1 / $list); // 총 페이지
        $blockNum = ceil($pageNum / $block); // 총 블록
        $nowBlock = ceil($page / $block);

        $s_page = ($nowBlock * $block) - 2;
        if ($s_page <= 1) {
            $s_page = 1;
        }
        $e_page = $nowBlock * $block;
        if ($pageNum <= $e_page) {
            $e_page = $pageNum;
        }


        $start = ($list * $page - 10);
        $end = ($list * $page);
        $sql = "Select * From ds_user WHERE mb_id = 'hotelpark' ORDER BY reqDate DESC LIMIT $start,$end";
        mysqli_set_charset($conn, 'utf8');
        $result = mysqli_query($conn, $sql);

        ?>
        <div class="cell_content">

            <div class="cell_header ">
                <div class="cell_deviceID">
                   디바이스아이디
                </div>
                <div class="cell_storeID">
                    스토어타입
                </div>
                <div class="cell_reqDate">
                    등록날짜
                </div>
            </div>
        </div>
        <?php

        while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <div class="cell_content">

               <div class="cell_block">
                   <div class="cell_deviceID">
                       <?php echo substr($row["token"], 0, 30); ?>
                   </div>
                   <div class="cell_storeID">
                       <?php echo substr($row["storeNumber"], 0, 30); ?>
                   </div>
                   <div class="cell_reqDate">
                       <?php echo substr($row["reqDate"], 0, 30); ?>
                   </div>
               </div>
            </div>
            <?php
        }
        ?>




        <div class="foot_content" style="margin-top: 10px">
           <div class="foot_block">
               <a href="<?= $PHP_SELP ?>?page=<?= $page - 1 ?>"><div class="foot_next">
                       이전
                   </div></a>
               <div class="foot_center">
                   <?php




                   for ($p = $s_page; $p <= $e_page; $p++) {
                       ?>

                       <a href="<?= $PHP_SELP ?>?page=<?= $p ?>"><?= $p ?></a>

                       <?php
                   }
                   ?>
               </div>
               <a href="<?= $PHP_SELP ?>?page=<?= $page + 1 ?>"><div class="foot_pre">
                       다음
                   </div></a>
           </div>
        </div>


        <?php
        $s_point = ($page - 1) * $list;
        echo "<br/>현재 페이지" . $page."/".$pageNum . "<br/>";

        $sql = "SELECT * FROM ds_user WHERE mb_id = 'hotelpark' ORDER BY no DESC LIMIT $s_point,$list";
        $real_data = mysqli_query($conn, $sql);

        for ($i = 1; $i <= $num; $i++) {
            $fetch = mysqli_fetch_assoc($result);
            ?>

            <div>
                <?= $fetch['list_no'] ?>
            </div>

            <?php
            if ($fetch == false) {
                exit;
            }
        }

        ?>

    </div>

</div>
</body>


</html>




