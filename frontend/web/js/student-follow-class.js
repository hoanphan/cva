/**
 * Created by HOANDHTB on 10/15/2016.
 */
var kt=1;

var urlGetScroses=$('#getScrosesUrl').text();
var sl=$('#slCountScroses').text();

$(document).ready(function () {
    $('#dslop-tenlop').change(function () {
        changeClass();
    })
    saveClick();

})
function changeClass() {

    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu học sinh....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    var MaLop = $('#dslop-tenlop').val();

    if (MaLop != '' && MaLop != 'danh sách lớp ...') {

            $dialog.modal();
            $.ajax({
                    url:urlGetScroses,
                type:'POST',
                data:{
                      Class:MaLop
            },
            success:function (result) {
                $('#dsdiem-index').find('.col-xs-12').remove();
                $('#dsdiem-index').append(result);
                $dialog.modal('hide');
            }
        });


    }
}
function saveClick() {

    var dialogSave = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lưu dữ liệu điểm của học sinh....</h3></div>' +
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
        '</div> <div class="modal-body"> Môn học chưa được chọn</div>'+
        '<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button> </div> </div> </div>'
    );
    $('#saveChage').click(function () {
        $('#Message').modal('hide');
        kt=1;
        var MaLop = $('#dslop-tenlop').val();

        if(MaLop!=''&&MaLop!=null) {
                dialogSave.modal();
                $('tbody').find('tr').find('input[type="number"]').each(function () {
                    var value = $(this).val();
                    var idStudent = $(this).attr('id');
                    ajaxSave(idStudent,value);
                });

        }
        else
            dialogError.modal();
           dialogSave.modal('hide');
    });

}

function  ajaxSave(idStudent,value) {
    var urlSave=$('#ajaxSave').text();
    $.ajax({
        url:urlSave,
        type:'POST',
        data:{
            idStudent:idStudent,
            value:value
        },
        success:function (result) {
                console.log(result);
        }
    })
}


