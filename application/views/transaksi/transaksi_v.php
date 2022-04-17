<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.box-header {
		color: #444;
		display: block;
		padding: 10px;
		position: relative;
	}
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>

<div class="modal fade" role="dialog" id="confirm_send">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation Approve</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" class="id_trans" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_appr">Approve</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="confirm_appr">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" class="id_trans" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_send">Kirimkan</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="confirm_rej">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation Reject</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" class="id_trans"" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-warning yes_rej">Reject</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="frm_user">
          <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Transaksi</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
					<div class="row">
				<div class="col-md-6">
                <div class="form-group">
                  <label>Member</label><span class="label label-danger pull-right member_error"></span>
                  <select class="form-control" name="member" id="member" >
					  <option value="">-- Pilih Member --</option>
					  <?php 
						if(!empty($member)){
							foreach($member as $m){
								echo '<option value="'.$m['id_member'].'">'.$m['nama'].'</option>';
							}
						}
					  ?>
				  </select>
                </div>					
				
				</div>
				
				<div class="col-md-6">          
				
				 <div class="form-group">
                  <label>Amount</label><span class="label label-danger pull-right amount_error"></span>
                  <input type="text" class="form-control" name="amount" id="amount" value="" placeholder="Amount" autocomplete="off" />
                </div>					
				
				</div>
				
				</div>				
				
				<div class="row">
				<div class="col-sm-12">
				<div class="form-group">
                  <label>Deskripsi</label><span class="label label-danger pull-right deskripsi_error"></span>
                  <textarea class="form-control" rows=10 name="deskripsi" id="deskripsi" value="" placeholder="Deskripsi" autocomplete="off" ></textarea>
                </div>
				</div>
				</div>
				
               
				
				
				</form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">
<div class="box-header">
    <a href="#"><button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add Transaksi</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:13%">No.Transaksi</th>			
			<th style="text-align:center; width:19%">Member</th>	
			<th style="text-align:center; width:24%">Alamat Kirim</th>	
			<th style="text-align:center; width:14%">Total</th>	
			<th style="text-align:center; width:14%">Action</th>
		</tr>
		</thead>
		
	
	</table>
</div>

</div>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var status = '<?php echo $status;?>';
$('.add_user').click(function(){
	$('#form_users').find("input[type=text], select, input[type=hidden]").val("");
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});


$('.yes_appr').click(function(){
	var id = $('.id_trans').val();
	var url = '<?php echo site_url('transaksi/upd_trans');?>';
	$('#confirm_appr').modal('hide');
	$.ajax({
		data : {id_transaksi : id, status : 2},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_send').modal('hide');
			$("#id_text").html('<b>Success,</b> Status transaksi telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});	
});

$('.yes_rej').click(function(){
	var id = $('.id_trans').val();
	var url = '<?php echo site_url('transaksi/upd_trans');?>';
	$.ajax({
		data : {id_transaksi : id, status : 3},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_rej').modal('hide');
			$("#id_text").html('<b>Success,</b> Status transaksi telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});	
});

$('.yes_send').click(function(){
	var id = $('.id_trans').val();
	var url = '<?php echo site_url('transaksi/upd_trans');?>';
	$.ajax({
		data : {id_transaksi : id, status : 4},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_appr').modal('hide');
			$("#id_text").html('<b>Success,</b> Status transaksi telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});	
});

function appr_trans(id_trans){	
	$('.id_trans').val('');
	$('.id_trans').val(id_trans);
	$('#confirm_send').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_send").modal('show');
}

function rej_trans(id_trans){	
	$('.id_trans').val('');
	$('.id_trans').val(id_trans);
	$('#confirm_rej').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_rej").modal('show');
}

function send_trans(id_trans){	
	$('.id_trans').val('');
	$('.id_trans').val(id_trans);
	$('#confirm_appr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_appr").modal('show');
}

$(function() {
	var path_role= '<?php echo $load_data;?>';
	
    var dataTable = $('#example88').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,           
        "ajax":{
            url :path_role, // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
				$(".employee-grid-error").html("");
                $("#example88").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#example88").css("display","none");
            }
        },'columnDefs': [
			{
				"targets": 4,
				"className": "text-right",
			},{
				"targets": 5,
				"className": "text-center",
			}
		],
        "language": {
			"lengthMenu": "Display _MENU_ Record per halaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Tampil halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch":        "Cari ",
            "oPaginate": {
				"sFirst":    "Pertama",
				"sLast":    "Terakhir",
				"sNext":    "Berikut",
				"sPrevious": "Sebelum"
            }
        }
    });
});

$('.yes_save').click(function(){
	var member = $('#member').val();
	var amount = $('#amount').val();
	var deskripsi = $('#deskripsi').val();
	
	$('.member_error').text('');
	$('.amount_error').text('');
	
	$('.deskripsi_error').text('');
	
	if(member <= 0 || member == '') {
		$('.member_error').text('Member harus diisi');
		return false;
	}
	if(amount <= 0 || amount == '') {
		$('.amount_error').text('Amount harus diisi');
		return false;
	}
	
	if(deskripsi == '') {
		$('.deskripsi_error').text('Deskripsi harus dipilih');
		return false;
	}
	
	
	var dt = $('#form_users').serialize();
	var url = '<?php echo site_url('transaksi/save');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){			
			if(response > 0){
				$('#frm_user').modal('hide');
				$("#id_text").html('<b>Success,</b> Data transaksi telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}else{
				
			}
		}
	})
});
$('#amount').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>
