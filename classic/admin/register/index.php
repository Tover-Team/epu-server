<?php
include_once('new_header.php');
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
                <form action="register_service_db.php" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">서비스 계정</label>
                        <input name="mb_id" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 이름</label>
                        <input name="wr_subject" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">상태</label>
                        <input name="wr_1" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="상태 (0 안드로이드 1 ios 2 둘다)">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 토큰키</label>
                        <input name="wr_2" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 홈페이지</label>
                        <input name="wr_3" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 카테고리</label>
                        <input name="wr_4" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 설명(80자)</label>
                        <input name="wr_5" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">앱 자세한 설명(4000자)</label>
                        <input name="wr_6" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">계정 명</label>
                        <input name="wr_9" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">계정 비밀번호</label>
                        <input name="wr_10" class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <input type="submit" class="btn btn-primary btn-block"></input>
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
