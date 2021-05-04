var wasSubmitted = false;

function checkBeforeSubmit() {
    if(!wasSubmitted) {
        wasSubmitted = true;
        return wasSubmitted;
    }
    return false;
}

function showModal(url, title) {
    $("#modalTitle").empty();
    $("#modalTitle").html(title);

    $("#modalBody").empty();
    $("#modalBody").html("Loading ...");
    $("#modalBody").load(url);

    $("#modal").modal({backdrop: 'static', keyboard: false});
    $("#modal").modal("show");
    return false;
}

function changeModalConten(url, title) {
    $("#modalTitle").empty();
    $("#modalTitle").html(title);

    $("#modalBody").empty();
    $("#modalBody").html("Loading ...");
    $("#modalBody").load(url);
    return false;
}

function toggleFormRKTByRKU(divHide, divShow, url)
{
    $(divHide).empty();
    $.get(url, function (data) {
        //$(divShow).show();
        $(divShow).html(data);
        //alert("Load was performed.");
    });
}

function ambilChildContent(obj) {
    if(checkBeforeSubmit()) {
        $('#child_content').empty();
        var temp = '<div class="loader" style="text-align:center"><h3>Loading...</h3></div>';
        $("#child_content").html(temp);
        var link = $(obj).data('uri');
        if (link != undefined) {
            $.ajax({
                type: "POST",
                //data: $('#form-periode-rekap').serialize(),
                dataType: 'html',
                url: link,
                success: function (response, statusText, xhr, $form) {
                    $('#child_content').empty();
                    $('#child_content').html(response);
                    wasSubmitted = false;
                },
                error: function (error) {
                    $('#child_content').html(error.responseText);
                    wasSubmitted = false;
                }
            });
        } else {
            setTimeout(function () {
                $("#child_content").html("Data tidak valid");
            }, 1000);
            wasSubmitted = false;
        }
    }
}

if(typeof showAlasan != 'function'){
    function showAlasan(th){
 		//alert($(th).attr("data-url"));

        if ( $( "#modal_alasan" ).length == 0 ) {
            var modal = '<div class="modal fade" id="modal_alasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"><div class="modal-content"> <div class="modal-header"><button type="button" id="model_reverse_close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 style="color: #000;text-align: center;" class="modal-title" id="myModalLabel">Alasan (Tidak Sesuai RKU)</h4> </div><div class="modal-body" id="content_alasan"> </div><div class="modal-footer"><button type="button" id="modal_close" class="btn btn-default" data-dismiss="modal">Close</button> </div></div></div></div>';
            $("body").prepend(modal);
        }

 		var urlLink = $(th).attr("data-url");
 		$('#modal_alasan').modal('show');

 		$.ajax({
 			url: urlLink ,
 			type: 'GET',
 			//dataType:"JSON",
 			//data: formData,
 			//async: false,
 			beforeSend :function(){

 				$('#content_alasan').html('<b>Loading...</b>');
 			},
 			complete  : function(){

 			},
 			success: function (data) {
 				$('#content_alasan').html(data);
 			},
 			error: function(xhr, status, error) {
 				// this will display the error callback in the modal.
 				alert( xhr.status + " " +xhr.statusText + " " + xhr.responseText);

 			},
 			cache: false,
 			/* contentType: false,
 			processData: false */
 		});


 		return false;
 	}
}
