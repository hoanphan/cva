/**
 * Created by HOANDHTB on 10/15/2016.
 */
var dialogSave = $(
    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
    '<div class="modal-header"><h3 style="margin:0;">Đang lưu dữ liệu điểm của học sinh....</h3></div>' +
    '<div class="modal-body">' +
    '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
    '</div>' +
    '</div></div></div>');
var kt=1;
var choDiem=1;
var urlGetScroses=$('#getScrosesUrl').text();
var sl=$('#slCountScroses').text();
var chodiem=$('#choDiem').text();
$(document).ready(function () {
    $('#dsmonhoc-tenmonhoc').change(function () {
        changeSubject();

    });
    saveClick();

})
function changeSubject() {

    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;">Đang lấy dữ liệu điểm của học sinh....</h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');
    var MaLop = $('#dslop-tenlop').val();
    var MonHoc = $('#dsmonhoc-tenmonhoc').val();
    var HocKy = $('#dshocky-tenhocky').val();

    if (MaLop != '' && MaLop != 'danh sách lớp ...') {
        var idSemester=$('#semester').text();
        if (MonHoc != null&&MonHoc!='') {
            if(HocKy!=idSemester)
            {
                $('#btn-save').css('display','none');
            }
            else
                $('#btn-save').css('display','block');
            $dialog.modal();
            $.ajax({
                    url:urlGetScroses,
                type:'POST',
                data:{
                Class:MaLop,
                    Subject:MonHoc,
                    Semester:HocKy
            },
            success:function (result) {
                $('#dsdiem-index').find('.col-xs-12').remove();
                $('#dsdiem-index').append(result);

                $('input[type="text"]').keydown(function (e) {
                    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
                    if (key == 40) {
                        e.preventDefault();
                        var tg=sl;
                        var tabIndex=$(this).attr('tabindex');
                        tg=parseInt(tg)+parseInt(tabIndex);
                        while ($('input[tabindex="'+tg+'"]').is(':disabled'))
                        {
                            tg=parseInt(tg)+parseInt(sl);
                        }
                        var textInput= $('input[tabindex="'+tg+'"]');
                        textInput.focus();
                        textInput.select();

                    }
                    if (key == 38) {
                        e.preventDefault();
                        var tg=sl;
                        var tabIndex=$(this).attr('tabindex');
                        tg=parseInt(tabIndex)-parseInt(tg);
                        while ($('input[tabindex="'+tg+'"]').is(':disabled'))
                        {
                            tg=parseInt(tg)-parseInt(sl);
                        }

                        $('input[tabindex="'+tg+'"]').select();
                    }
                    if (key == 39) {
                        e.preventDefault();
                        var inputs = $(this).parents('form').find(':input[type="text"]:enabled:visible:not("disabled")');
                        //inputs.eq(inputs.index(this) + 1).focus();
                        inputs.eq(inputs.index(this) + 1).select();
                    }
                    if (key == 37) {
                        e.preventDefault();
                        var inputs = $(this).parents('form').find(':input[type="text"]:enabled:visible:not("disabled")');
                        // inputs.eq(inputs.index(this) - 1).focus();
                        inputs.eq(inputs.index(this) - 1).select();
                    }
                    //click();


                });
                ajaxReport(HocKy,MaLop,MonHoc);
                $dialog.modal('hide');
            }
        });
            $.ajax({
                url:chodiem,
                type:'POST',
                data:{
                    subject:MonHoc
                },
                success:function (result) {
                    $('#txtLaChoDiem').val(result);
                }
            });
        }
    }
}
function saveClick() {



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
    var dialogCheckInvalid = $('' +
        ' <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
        '<div class="modal-dialog" role="document">'+
        '<div class="modal-content">'
        +'<div class="modal-header">'
        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span'+
        'aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel"><h3 class="panel-title"><i class="fa fa-bullhorn"></i>'+
        'Thông báo</h3></h4>'+
        '</div> <div class="modal-body">Dữ liệu vừa nhập chưa đúng, xin vui lòng kiểm tra lại!</div>'+
        '<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button> </div> </div> </div>'
    );
    $('#saveChage').click(function () {
        $('#Message').modal('hide');
        kt=1;
        var id_semsester=$('#dshocky-tenhocky').val();
        var id_subject=$('#dsmonhoc-tenmonhoc').val();
        var MaLop = $('#dslop-tenlop').val();

        checkInvalid();
        var array=[];
        if(id_subject!=''&&id_subject!=null) {
            if(kt==1) {
                dialogSave.modal();
                var LaChoDiem=$('#txtLaChoDiem').val();
                $('tbody').find('tr').find('input[type="text"]').each(function () {
                    var value = $(this).val();
                    var name = $(this).attr('id');
                    var index1 = name.indexOf('_');
                    var last_index = name.lastIndexOf('_');
                    var id_student = name.substr(0, index1);
                    var id_Type = name.substr(index1 + 1, last_index - index1 - 1);
                    var serial = name.substr(last_index + 1, name.length - 1 - last_index);
                    if(LaChoDiem=="1") {
                    //     if ($.isNumeric(value)) {
                    //         array.push({
                    //             semester:id_semsester,
                    //             subject:id_subject,
                    //             student:id_student,
                    //             type:id_Type,
                    //             serial:serial,
                    //             value:value
                    //         });
                    //        // ajaxSave(id_semsester, id_subject, id_student, id_Type, serial, value);
                    //     }
                    // }
                    // else
                    // {
                        if(value!="-")
                        {
                            array.push({
                                semester:id_semsester,
                                subject:id_subject,
                                student:id_student,
                                type:id_Type,
                                serial:serial,
                                value:value
                            });
                           // ajaxSave(id_semsester, id_subject, id_student, id_Type, serial, value);
                        }
                    }

                });
                //ajaxSaveAvge(id_semsester,id_subject,MaLop);
                if(array.length>0) {
                    ajaxSave2(array);
                    //changeSubject();
                }
                else
                    ajaxSaveAvge(id_semsester,id_subject,MaLop);

            }
            else
                dialogCheckInvalid.modal();
        }
        else
            dialogError.modal();

    });

}

function  ajaxSaveAvge(idSemester,idSubject,idClass) {
    var urlSave=$('#ajaxAvgeScrose').text();
    $.ajax({
        url:urlSave,
        type:'POST',
        data:{
            idSemester:idSemester,
            idClass:idClass,
            idSubject:idSubject
        },
        success:function (result) {
            if(result==false)
            {
                changeSubject();
            }
        }

    })
}

function  ajaxSave2(arr) {
    var myData=JSON.stringify(arr);
    var urlSave=$('#ajaxSave').text();
    $.ajax({
        url:urlSave,
        type:'POST',
        dataType:'json',
        data:{myData:myData},
        success:function (result) {
            $('#dsdiem-index').find('.col-xs-12').remove();
            console.log(result);
            $('#dsdiem-index').append(result['value']);

            $('input[type="text"]').keydown(function (e) {
                var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
                if (key == 40) {
                    e.preventDefault();
                    var tg=sl;
                    var tabIndex=$(this).attr('tabindex');
                    tg=parseInt(tg)+parseInt(tabIndex);
                    while ($('input[tabindex="'+tg+'"]').is(':disabled'))
                    {
                        tg=parseInt(tg)+parseInt(sl);
                    }
                    var textInput= $('input[tabindex="'+tg+'"]');
                    textInput.focus();
                    textInput.select();

                }
                if (key == 38) {
                    e.preventDefault();
                    var tg=sl;
                    var tabIndex=$(this).attr('tabindex');
                    tg=parseInt(tabIndex)-parseInt(tg);
                    while ($('input[tabindex="'+tg+'"]').is(':disabled'))
                    {
                        tg=parseInt(tg)-parseInt(sl);
                    }

                    $('input[tabindex="'+tg+'"]').select();
                }
                if (key == 39) {
                    e.preventDefault();
                    var inputs = $(this).parents('form').find(':input[type="text"]:enabled:visible:not("disabled")');
                    //inputs.eq(inputs.index(this) + 1).focus();
                    inputs.eq(inputs.index(this) + 1).select();
                }
                if (key == 37) {
                    e.preventDefault();
                    var inputs = $(this).parents('form').find(':input[type="text"]:enabled:visible:not("disabled")');
                    // inputs.eq(inputs.index(this) - 1).focus();
                    inputs.eq(inputs.index(this) - 1).select();
                }

            });
            dialogSave.modal('hide');
        },
        error: function (error) {
            alert('error; ' + eval(error));
        }
    });

}


function checkInvalid() {

    var id_subject=$('#dsmonhoc-tenmonhoc').val();
    var choDiem=$('#txtLaChoDiem').val();
    if(id_subject!='') {
        $('tbody').find('tr').find('input[type="text"]').each(function () {
            var value = $(this).val();
            if (choDiem=="1")
            {
                if ($.isNumeric(value)) {
                    if(value<0)
                    {
                        kt=0;
                        return false;
                    }
                    else  if(value>0&&value<1)
                    {
                        kt=0;
                        return false;
                    }
                    else
                    if(value>10)
                    {
                        kt=0;
                        return false;
                    }
                }
                else {
                    if (value != '-') {
                        kt = 0;
                        return false;
                    }
                }
            }
            else
            {
                if(value=="CD"||value=="D"||value=='-')
                {
                    kt=1
                }
                else {
                    kt = 0;
                    return false;
                }
            }
        });
    };

}
function  ajaxReport(Semester,Class,Subject)
{
    $('#report').find('span').remove();
    var urlReport=$('#ajaxReport').text();
    $.ajax({
        url:urlReport,
        type:'POST',
        data:{
            idSemester:Semester,
            idClass:Class,
            idSubject:Subject
        },
        success:function (result) {
          $('#report').append(result);
        }

    })
}