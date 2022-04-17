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
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:850px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add/Edit Outlet</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" autocomplete="off">
                <!-- text input -->
				<div class="row">
                
                <div class="form-group">
                  <label>Deskripsi</label><span class="label label-danger pull-right deskripsi_error"></span>
                  <textarea class="form-control" name="deskripsi" id="deskripsi" value="" placeholder="Deskripsi" autocomplete="off"></textarea>
                  <input type="hidden" value="" name="id_outlet" id="id_outlet">
				  <input type="hidden" id="type" name="type">
                </div>
                
				 <div class="form-group col-md-5">
                  <label>Latitude</label><span class="label label-danger pull-right content_error"></span>
                  <input type="text" class="form-control" name="latitude" id="latitude" value="" placeholder="Latitude" autocomplete="off" />
                </div>
                  <div class="form-group col-md-5 col-md-offset-2">
                  <label>Longitude</label><span class="label label-danger pull-right content_error"></span>
                  <input type="text" class="form-control" name="longitude" id="longitude" value="" placeholder="Longitude" autocomplete="off" />
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
    <a href="#"><button class="btn btn-success add_news"><i class="fa fa-plus"></i> Add</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            
            <th style="text-align:center; width:40%">Deskripsi</th>		
						
			<th style="text-align:center; width:13%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';			
				$koordinat = '';			
				if(!empty($faq)){		
					foreach($faq as $f){	
						$view_sub = '';
						$latitude = !empty($f['latitude']) ? $f['latitude'] : '-';
						$longitude = !empty($f['longitude']) ? $f['longitude'] : '-';
						$koordinat = $latitude.','.$longitude;
						$info = $f['id_op'].'Þ'.$f['deskripsi'].'Þ'.$f['latitude'].'Þ'.$f['longitude'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td>'.$f['deskripsi'].$koordinat.'</td>';
						echo '<td align="center" style="vertical-align: middle;">		
			
			<a href="#" id="'.$info.'" title="Edit" class="edit_news"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<button title="Delete" id="'.$f['id_op'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
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
$("input").attr("autocomplete", "off"); 

$('.add_news').click(function(){
	$('#frm_cat').find("input[type=text], select, textarea, input[type=hidden]").val("");
	
	CKEDITOR.instances['deskripsi'].setData('');
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_news').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_outlet').val(dt[0]);
	$('#latitude').val(dt[2]);
	$('#longitude').val(dt[3]);	
	CKEDITOR.instances['deskripsi'].setData(dt[1]);
	//$('#content').text(dt[1]);
	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.del_news').click(function(){
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
	var url = '<?php echo site_url('outlet/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});

$('.yes_save').click(function(){
	//var content = $('#content').val();
	
	var deskripsi = CKEDITOR.instances['deskripsi'].getData();
	$('.content_error').text('');
	if(deskripsi <= 0 || deskripsi == '') {
		$('.content_error').text('Deskripsi harus diisi');
		return false;
	}
	$('#type').val('<?php echo $type;?>');
	for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('outlet/simpan');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){			
			if(response > 0){
				$('#frm_category').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}else{
				
			}
		}
	})
});


$(function() {               
    $('#example88').dataTable({});
});

$("input").attr("autocomplete", "off"); 
 $(function (config) {
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('deskripsi');
});
</script>