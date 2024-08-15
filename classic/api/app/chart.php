<?php
//$type = $_REQUEST['type'];
$title = "조직도 변경";
if (!$type) {
    $type = 1;
}
?>
<script type="application/javascript">
    var fileUpload = function() {

        var $img = $('#fileImg'),
            imgWidth = $img.attr('width'),
            $fileField = $('#file'),
            $upLoad = $('#upload');

        var $file = $upLoad.css({
            position: "absolute",
            top: "0px",
            right: "0px",
            width: imgWidth + "px",
            cursor: "pointer",
            opacity: "0"
        });

        $file.on('change', function() {
            var fileName = $(this).val();
            $fileField.attr("disabled", "disabled").val(fileName);
        });

    }();
</script>

<style>
    fieldset,
    img {
        border: 0
    }

    legend {
        width: 0;
        height: 0;
        line-height: 0;
        overflow: hidden;
        visibility: hidden;
        font-size: 0;
    }

    fieldset {
        position: relative;
        display: inline-block;
        *display: inline;
    }

    fieldset * {
        vertical-align: middle;
    }
</style>

<div class="dobddfox"
     style="clear:both;height:60px;background:white;width:100%;border:1px solid #c3c3c3;padding:6px;line-height: 60px;margin-top:32px;">

    <div class="" style="width:1000px;height:60px;">

        <p style="float:left; font-size:24px;"><?php echo $title; ?></p>
    </div>

</div>
<br>

<div class="cell_content">

    <div class="cell_img_block" style="background: #e2d693;font-weight: 600">
        이미지
    </div>
</div>
<div class="cell_img_content">
    <div class="cell_img_block">

        <div class="cell_deviceID_img" style="text-align: center;margin-right: 10px;padding-right: 10px;">
            <div class="cell_content">

                <div class="cell_img_block" style="background: #e2d693;font-weight: 600">
                  주의사항
                </div>
            </div>
            <p>추천 이미지사이즈는 1080x1600 사이즈이며 앱 화면을 위해 확장자는 png만 가능합니다.</p>

            <div class="cell_content">

                <div class="cell_img_block" style="background: #e2d693;font-weight: 600">
                    이미지바꾸기
                </div>
            </div>

            <form enctype='multipart/form-data' action='<?php G5_URL ?>/page/app/upload_ok.php?type=<?php echo $type; ?>' method='post'>
                <input type='file' name='myfile'>
                <button >이미지바꾸기</button>
            </form>
        </div>
        <br/>

            <Img
                 src="<?php echo G5_URL . "/page/img/chart.png"; ?>"/>
    </div>
</div>