/**
 * Created by HOANDHTB on 11/3/2016.
 */
var textStatus1="";
var gt=0;
var countStudent=parseInt($('#countStudent').text());
var dialog = $(
    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
    '<div class="modal-header"><h3 style="margin:0;">Đang gửi dữ liệu lên server</h3></div>' +
    '<div class="modal-body">' +
    '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
    '</div>' +
    '</div></div></div>');
var dialogGetData = $(
    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
    '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu</h3></div>' +
    '<div class="modal-body">' +
    '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress">'+
    '<div id="value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">'+
    '0% Complete (success)'
    +'</div> </div></div></div>' +
    '</div>' +
    '</div></div></div>');
var dialogWait=$('<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
    '<div class="modal-header"><h3 style="margin:0;">Xin chờ 1 chút</h3></div>' +
    '<div class="modal-body">' +
    '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
    '</div>' +
    '</div></div></div>');
var dialogError = $('' +
    ' <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
    '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'
    +'<div class="modal-header">'
    +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span'+
    'aria-hidden="true">&times;</span></button>'+
    '<h4 class="modal-title" id="myModalLabel"><h3 class="panel-title"><i class="fa fa-bullhorn"></i>'+
    'Thông báo</h3></h4>'+
    '</div> <div class="modal-body">Có lỗi sảy ra!<br/>'+textStatus1+'</div>'+
    '<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button> </div> </div> </div>'
);
$(document).ready(function () {

    $('textarea').remove();

    $('#sms').click(function () {
        sendSms();
    });
    $('#get').click(function () {

        getData();
    });
    $('#repeat').click(function () {
        // Request();
    })

})
function getData() {
    var thang = $('#dsthang-tenthang').val();
    var semester = $('#dshocky-tenhocky').val();
    if(semester !="") {
        dialogGetData.modal();
        ajax(thang, semester);
    }
    else
        alert('Không để học kỳ trống');
}
function ajax(month,semester) {
    var  url=$('#ajax').text();
    $.ajax({
            url:url,
        type:'POST',
        data:{
        month:month,
            semester:semester,
            index:gt
    },
    success: function (result) {
        gt=parseInt(result);
        var i=parseInt(result);
        i=Math.round((i/countStudent)*100,2);
        $('#value').text(i + '% Complete (success)');
        $('#value').width(i+'%');
        if(gt!=countStudent)
            ajax(month,semester);
        else {
            dialogGetData.modal('hide');
            window.location="<?=Url::toRoute(['/send/sms'])?>"
        }
    },
    error:function(jqxhr,textStatus,errorThrown)
    {
        setErrorText(textStatus);
        dialogGetData.modal('hide');
        dialogError.modal();
    }
})
}
/*function sendSms() {
    var month=$('#dsthang-tenthang').val();
    var semester=$('#dshocky-tenhocky').val();
    if(semester!=null&&semester!='') {
        dialog.modal()
        $.ajax({
                url: '<?=Url::toRoute(['about/send-sms'])?>',
            type: 'POST',
            data: {
            month: month,
                semester: semester
        },
        success: function (result) {
            dialog.modal('hide');
            $('#gridview').find('.gridview').remove();
            $('#gridview').append(result);

            var test = new Date()
            var day = test.getDate();
            var month = test.getMonth() + 1;
            var year = test.getFullYear();
            var hour = test.getHours();
            var minute = test.getMinutes() + 5;
            var mini = test.getSeconds();
            var str = year + "/" + month + "/" + day + " " + hour + ":" + minute + ":" + mini;

            $("#getting-started")
                .countdown(str, function (event) {

                    $(this).text(
                        event.strftime('%M:%S')
                    );
                    if (event.strftime('%M:%S') == "00:00") {
                        dialogWait.modal();
                        $.ajax(
                            {
                                url: '<?=Url::toRoute(['send/check-sms'])?>',
                            type: 'POST',
                            data: {
                            month: month
                        },
                        success: function (result) {
                            $('#gridview').find('.gridview').remove();
                            $('#gridview').append(result);
                            dialogWait.modal('hide');
                        }
                    }
                    )
                    }
                });

            $('#sms').attr('disabled', 'disabled');
        }
    })
    }
}*/

/*function Request() {
    var month=$('#dsthang-tenthang').val();
    dialogWait.modal();
    $.ajax(
        {
            url: '<?=Url::toRoute(['send/check-sms'])?>',
        type: 'POST',
        data: {
        month: month
    },
    success: function (result) {
        $('#gridview').find('.gridview').remove();
        $('#gridview').append(result);
        dialogWait.modal('hide');
    }
}
)
}*/
function setErrorText(textStatus) {
    dialogError = $('' +
        ' <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
        '<div class="modal-dialog" role="document">'+
        '<div class="modal-content">'
        +'<div class="modal-header">'
        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span'+
        'aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel"><h3 class="panel-title"><i class="fa fa-bullhorn"></i>'+
        'Thông báo</h3></h4>'+
        '</div> <div class="modal-body">Có lỗi sảy ra!<br/>'+textStatus+'</div>'+
        '<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button> </div> </div> </div>'
    );
}