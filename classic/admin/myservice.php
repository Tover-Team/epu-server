
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
            <li class="breadcrumb-item active">나의 서비스</li>
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
                            <th>서버 토큰</th>
                            <th>앱 홈페이지</th>
                            <th>앱 카테고리</th>
                            <th>앱 설명</th>
                            <th>계정 명</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>앱 이름</th>
                            <th>서버 토큰</th>
                            <th>앱 홈페이지</th>
                            <th>앱 카테고리</th>
                            <th>앱 설명</th>
                            <th>계정 명</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        include("dbconfig.php");
                        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                        $sql = "SELECT * FROM g5_write_push_service WHERE mb_id = '$my_id'";
                        mysqli_set_charset($conn, 'utf8');
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo substr($row["wr_subject"], 0, 30); ?></td>
                                <td><?php echo substr($row["wr_2"], 0, 30); ?></td>
                                <td><?php echo substr($row["wr_3"], 0, 30); ?></td>
                                <td><?php echo substr($row["wr_4"], 0, 30); ?></td>
                                <td> <?php echo substr($row["wr_5"], 0, 30); ?></td>
                                <td> <?php echo substr($row["wr_9"], 0, 30); ?></td>
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
