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

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Yes</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">
 
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            
            <th style="text-align:center; width:8%">Tanggal</th>		
            <th style="text-align:center; width:15%">Member</th>		
            <th style="text-align:center; width:15%">Produk</th>		
            <th style="text-align:center; width:15%">Alamat</th>		
						
			<th style="text-align:center; width:10%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$view_img = '';
				$info = '';			
				$koordinat = '';			
				if(!empty($inquiry_sample)){		
					foreach($inquiry_sample as $_is){	
						$view_sub = '';
						$view_img = '';
						// $view_img = site_url('outlet/pabrik_img/'.$f['id_op']);
						// $latitude = !empty($f['latitude']) ? $f['latitude'] : '-';
						// $longitude = !empty($f['longitude']) ? $f['longitude'] : '-';
						// $koordinat = $latitude.','.$longitude;
						$info = $_is['id_inquiry'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td>'.date('d-m-Y', strtotime($_is['created_at'])).'</td>'; 
						echo '<td>'.$_is['nama'].'<br/>'.$_is['email'].'</td>';
						echo '<td>'.$_is['nama_product'].'</td>';
						echo '<td>'.$_is['address'].'<br/>'.$_is['phone'].'</td>';
						echo '<td align="center" style="vertical-align: middle;">';		
							if($_is['status'] == 1){		
								echo '<button title="Approve" id="2_'.$info.'" class="btn btn-xs btn-success btn_appr"><i class="glyphicon glyphicon-ok"></i> Approve</button>
									<button title="Reject" id="3_'.$info.'" class="btn btn-xs btn-danger btn_appr" style="margin-top:5px; width:69px;"><i class="glyphicon glyphicon-remove"></i> Reject</button>';	
							}
							if($_is['status'] == 2){	
								echo 'Approved by '.ucfirst($_is['fullname']).' <br/>'.date('d-m-Y H:i', strtotime($_is['status_date']));
							}
							if($_is['status'] == 3){	
								echo 'Rejected by '.ucfirst($_is['fullname']).' <br/>'.date('d-m-Y H:i', strtotime($_is['status_date']));
							}
			
						echo '</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script type="text/javascript">
$("#success-alert").hide();

$('.btn_appr').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('inquiry/upd_status');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});

$(function() {               
    $('#example88').dataTable({});
});

$("input").attr("autocomplete", "off"); 

</script>