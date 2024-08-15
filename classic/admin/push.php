<?php
include_once('./new_header.php');
$my_id = $_COOKIE['user_id'];
include("dbconfig.php");
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conn, 'utf8');

$sql = "SELECT * FROM g5_write_push_service WHERE mb_id = '$my_id'";
$result = mysqli_query($conn, $sql);
$row = @mysqli_fetch_assoc($result);
$link = $row[wr_3];


$sql = "SELECT * FROM g5_write_push_service WHERE mb_id = '$my_id'";
$result = mysqli_query($conn, $sql);
$count = 0;
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">대시보드</a>
            </li>
            <li class="breadcrumb-item active">푸시발송</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">푸시발송</div>
            <div class="card-body">
                <form action="bbs/push_notifiaction_topic.php" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">푸시 제목 </label>
                        <input name="mb_subject" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="푸시제목을 입력하세요(ios는 노출되지 않습니다)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">푸시 발송내용 (이미지가 있을 경우 20자 이하만 노출됩니다)</label>
                        <input name="mb_content" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="푸시메세지를 입력하세요">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">이동할 링크 경로를 입력하세요 (Android만 지원합니다)</label>
                        <input name="mb_link" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="주소를 입력하세요" value="<?php echo $link ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">이미지 경로 (Android만 지원합니다)</label>
                        <input name="mb_image" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="이미지 주소를 입력하세요 확장자까지 입력 (ex) .jpg .png)">
                    </div>
                    <div class="form-group">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input name="mb_service<?php echo $count?>" class="form-check-input" type="checkbox"> <?php echo substr($row["wr_subject"], 0, 30).$count; ?>
                                </label>
                            </div>
                            <?php $count++?>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" href="login_check.php"></input>
                </form>

            </div>
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
