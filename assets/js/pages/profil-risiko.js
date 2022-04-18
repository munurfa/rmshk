$(function(){
    $('<input>').attr({
        type: 'hidden',
        id: 'idOfHiddenInput',
        name: 'idOfHiddenInput'
    }).appendTo('#datatable-list');
    $('#datatable-list').on( 'init.dt', function () {
        readyCheckbox();
    } ).DataTable().column(0).visible(false);
    $('#chk_list_parent').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
            $('#btn_save_modul').removeClass('disabled');
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
            $('#btn_save_modul').addClass('disabled');
        }
    });

    $('#btn_save_modul').click(function(event) {
        var x=$(this);
        var jml=0;
        var data = $("#idOfHiddenInput").val();

        if (data!=""){
        var notyConfirm = new Noty({
                text: '<h6 class="mb-3">Konfirmasi</h6><label>Apa Anda yakin akan merubah '+jml+' data tersebut pada Dashboard Profil Risiko ?</label>',
                timeout: false,
                modal: true,
                layout: 'center',
                theme: '  p-0 bg-white',
                closeWith: 'button',
                type: 'confirm',
                buttons: [
                    Noty.button('Cancel', 'btn btn-link', function () {
                        notyConfirm.close();
                    }),

                    Noty.button('Ubah Data <i class="icon-paperplane ml-2"></i>', 'btn bg-blue ml-1', function () {
                            notyConfirm.close();
                            looding('light',x.parent().parent());
                            $.ajax({
                                type:'post',
                                url:x.data('url'),
                                data:{id:data},
                                dataType: "json",
                                success:function(result){
                                    stopLooding(x.parent().parent());
                                    console.log(result);
                                    // location.reload();
                                },
                                error:function(msg){
                                    stopLooding(x.parent().parent());
                                },
                                complate:function(){
                                }
                            })
                        },
                        {id: 'button1', 'data-status': 'ok'}
                    )
                ]
            }).show();
        }
    });

    $(document).on('click','input[name="chk_list[]"]', function (event) {
        
    
        var len = $('input[name="chk_list[]"]:checked').length;
        if (len>0){
            $('#btn_save_modul').removeClass('disabled');
            $('#chk_list_parent').prop('checked', true);
        }else{
            $('#btn_save_modul').addClass('disabled');
            $('#chk_list_parent').prop('checked', false);
        }
        updateCheckboxes($(this));
    });


    $("#period").change(function () {
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data = {
			'id': nilai
		};
		var target_combo = $("#term");
		var url = "ajax/get-term";
		_ajax_("post", parent, data, target_combo, url);
    })

    $("#term").change(function () {
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data = {
			'id': nilai
		};
		var target_combo = $("#minggu");
		var url = "ajax/get-minggu";
		_ajax_("post", parent, data, target_combo, url);
    })


    $(document).on('click','.detail-peta', function() {
        var parent = $(this).parent().parent().parent();
        var owner = $("#owner").val();
		var period = $("#period").val();
		var type_ass = $("#type_ass").val();
		var term = $("#term").val();
		var minggu = $("#minggu").val();
		var id = $(this).data('id');
		var level = $(this).data('level');
		var data={'id':id, 'level':level, 'period':period,'owner':owner,'type_ass':type_ass, 'term':term,'minggu':minggu};
		var target_combo = '';
		var url = "profil-risiko/get-detail-map";
		_ajax_("post", parent, data, target_combo, url, 'list_map');
    })
    $(document).on('click','.detail-rcsa', function() {
		var parent = $(this).parent().parent().parent();
		var id = $(this).data('id');
		var data={'id':id};
		var target_combo = '';
		var url = "ajax/get-detail-rcsa";
		_ajax_("post", parent, data, target_combo, url, 'list_mitigasi');
    })

    $(document).on('click','.detail-mitigasi', function() {
		var parent = $(this).parent().parent().parent();
		var id = $(this).data('id');
		var data={'id':id};
		var target_combo = '';
		var url = "ajax/get-detail-mitigasi";
		_ajax_("post", parent, data, target_combo, url, 'list_aktifitas_mitigasi');
    })
    $(document).on('click','.detail-progres-mitigasi', function() {
        var parent = $(this).parent().parent().parent();
		var id = $(this).data('id');
		var owner = $("#owner").val();
		var period = $("#period").val();
		var type_ass = $("#type_ass").val();
		var data={'id':id,'period':period,'owner':owner,'type_ass':type_ass};
		var target_combo = '';
		var url = "ajax/get-detail-progres-mitigasi";
		_ajax_("post", parent, data, target_combo, url, 'list_progres_aktifitas_mitigasi');
    })
    $(document).on('click','#proses', function() {
        var parent = $(this).parent().parent().parent();
		var owner = $("#owner").val();
		var period = $("#period").val();
		var type_ass = $("#type_ass").val();
		var term = $("#term").val();
		var minggu = $("#minggu").val();
		var data={'period':period,'owner':owner,'type_ass':type_ass, 'term':term,'minggu':minggu};
		var url = modul_name+"/get-map";
		_ajax_("post", parent, data, '', url,'result_map');
    });

});

var checkboxes = [];
function readyCheckbox() {
    $('input[name="chk_list[]"]:checked').each(function(){
        id = $(this).val();
        checkboxes.push(id);
    });
    $("#idOfHiddenInput").val(checkboxes);

}
function updateCheckboxes(checkbox){
    //Get the row id
    var id = checkbox.val();

    //Check the array for the id
    var arrPos = checkboxes.indexOf(id);

    //If it exists and we unchecked it, remove it
    if(arrPos > -1 && !checkbox.checked){
        checkboxes.splice(arrPos,1);
    }
    //Else it doesn't exist and we checked it
    else 
    {
        checkboxes.push(id);
    }

    //Finally update the hidden input
    $("#idOfHiddenInput").val(checkboxes);
}

function list_map(hasil){
    // $('#result').html(hasil.combo);
    $("#modal_general").find(".modal-body").html(hasil.combo);
    $("#modal_general").modal("show");
}

function list_mitigasi(hasil){
    $('#result_mitigasi').html(hasil.combo);
}

function list_aktifitas_mitigasi(hasil){
    $('#result_aktifitas_mitigasi').html(hasil.combo);
}
function list_progres_aktifitas_mitigasi(hasil){
    $('#result_progres_aktifitas_mitigasi').html(hasil.combo);
}

function result_map(hasil){
    $("#maps").html(hasil.combo);
    // $("#result_grap1").html(hasil.grap1);
    // $("#result_grap2").html(hasil.data_grap1);
}