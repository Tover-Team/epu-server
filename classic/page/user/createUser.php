<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Child</title>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script type="text/javascript">google.load("jquery", "1")</script>
    <script language="javascript" type="text/javascript">

        function moveClose() {
            // var bank = $('#bank').val();
            // var name = $('#name').val();
            // var number = $('#number').val();
            // opener.location.href="./bank_update.php?wr_id=" + 2 + "&bank=" + bank + "&name=" + name  + "&number=" + number;
            // //.alert(value);
            // self.close();
            window.opener.location.reload();
            window.close();

            // opener.document.location.reload();
            // self.close();
        }
    </script>

</head>
<body>
<br>
<b><font size="5" color="gray">사용자를 추가합니다.</font></b>
<br><br>

<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-body">
            <form>
                <input type="text" id="mb_id" placeholder="사번" value="<?echo $_REQUEST[bank] ?>"><br><br>
                <input type="text" id="mb_name" placeholder="이름" value="<?echo $_REQUEST[name] ?>"><br><br>
                <input type="text" id="number" placeholder="닉네임"  value="<?echo $_REQUEST[number] ?>"><br><br>
                <input type="text" id="mb_2" placeholder="직위"  value="<?echo $_REQUEST[number] ?>"><br><br>
                <select name="co_tag_filter_use" id="co_tag_filter_use">
                    <option value="1"<?php echo get_selected(1, $co['co_tag_filter_use']); ?>>사용함</option>
                    <option value="0"<?php echo get_selected(0, $co['co_tag_filter_use']); ?>>사용안함</option>
                </select><br><br>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" onclick="moveClose()" data-dismiss="modal">추가하기</button>
            <button type="button" class="btn" data-dismiss="modal">닫기</button>
        </div>
    </div>
</div>
<input type="button" value="수정하기" onclick="moveClose()">
</body>
</html>
