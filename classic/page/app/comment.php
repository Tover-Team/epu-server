<?php
$mb_id = $_REQUEST[mb_id];
if ($mb_id == "") {
    echo "<script>alert(\"올바른 접근이 아닙니다.\");</script>";
    echo "<script> document.location.href='/endapp.html'; </script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Material Design Bootstrap</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script type="application/javascript">
        function onClickComment() {
            var a = $("#comment").val();
            if (a=="") {
                alert("내용을 입력해 주세요.");
                return;
            }

            location.href = "/endapp.html";
        }
    </script>
</head>

<body>
<div class="form-group shadow-textarea">
    <textarea class="form-control z-depth-1" id="comment" rows="15" placeholder="댓글을 작성해주세요."></textarea>
</div>
<button type="submit" class="btn btn-primary btn-md" onclick="onClickComment()" style="width: 100%">댓글작성</button>
</html>