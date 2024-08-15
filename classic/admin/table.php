
<?php
include_once('./new_header.php');
$my_id = $_COOKIE['user_id'];
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">대시보드</a>
            </li>
            <li class="breadcrumb-item active">유저리스트</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> 리스트 출력 </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>앱 이름</th>
                            <th>유저 아이디</th>
                            <th>스토어타입</th>
                            <th>토큰</th>
                            <th>등록 일자</th>
                            <th>푸시 수신 동의</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>앱 이름</th>
                            <th>유저 아이디</th>
                            <th>스토어타입</th>
                            <th>토큰</th>
                            <th>등록 일자</th>
                            <th>푸시 수신 동의</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        include("dbconfig.php");

                        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                        $sql = "Select * From ds_user WHERE mb_id = '$my_id' ORDER BY reqDate DESC";
                        mysqli_set_charset($conn, 'utf8');
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo substr($row["mb_id"], 0, 30); ?></td>
                                <td><?php echo substr($row["userID"], 0, 30); ?></td>
                                <td><?php
                                    $storeNumber =substr($row["storeNumber"], 0, 30);
                                    $storeType = "안드로이드";
                                    if($storeNumber == 2){
                                        $storeType = "아이폰";
                                    }
                                    echo $storeType; ?></td>
                                <td><?php echo substr($row["token"], 0, 30); ?></td>
                                <td> <?php echo substr($row["reqDate"], 0, 30); ?></td>
                                <td><?php
                                    if ($row["isReceive"] == "N") {
                                        echo "거부";
                                    } else {
                                        echo "동의";
                                    } ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">실시간 리스트입니다.</div>
        </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
</div>
</body>

</html>
