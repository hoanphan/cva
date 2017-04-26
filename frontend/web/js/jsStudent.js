var gt=0;
var countStudent=parseInt($('#countStudent').text())-1;
var UrlBase=$('#urlBase').text();
var dialog = $(
    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
    '<div class="modal-header"><h3 style="margin:0;">Mã hóa mật khẩu</h3></div>' +
    '<div class="modal-body">' +
    '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress">'+
    '<div id="value" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">'+
    '0% Complete (success)'
    +'</div> </div></div></div>' +
    '</div>' +
    '</div></div></div>');
$('#send').click(function () {
    $('#myModal').modal('hide');
    dialog.modal();
    ajax();
});
function ajax() {
    $.ajax({
        url: UrlBase,
        type: 'POST',
        data: {index: gt},
        success: function (result) {
            var i=parseInt(result);
            i=(i/countStudent)*100;
            $('#value').text(i + '% Complete (success)');
            $('#value').width(i+'%');
            if(result!=countStudent) {
                ajax();
                gt++;
            }
            else
                dialog.modal('hide');
        },
        error:function(jqxhr,textStatus,errorThrown)
        {
            $('#contentError').append(errorThrown);
            dialog.modal('hide');
            $('#myModal1').modal();
        }
    });
}
// chage scroses
