var first = true;
window.onload = function () {
    if (first) {
        $('.viewDetail2').hide();
        first = false;
    }
   
}

function insert_input() {
    $.ajax({
        url : "./list1.json",
        dataType: "json",
        error: function () {
            alert('통신실패!!');
        },
        success: function (data) {
            alert(data.data);
            //$('.viewDetail').append('dd');
            $('.viewDetail1').hide();
            $('.viewDetail2').show();
        }
    }).done(function (data) {
        //alert(data.data);
    });
}