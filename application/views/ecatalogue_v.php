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
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_id" value="">
				<input type="hidden" id="status" value="">
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

<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Catalogue</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Judul</label><span class="label label-danger pull-right content_error"></span>
                  <input type="text" class="form-control" name="judul" id="judul" value="" placeholder="Judul" autocomplete="off" />
                  <input type="hidden" value="" name="id_catalogue" id="id_catalogue">
				  
                </div>
				<div class="form-group">
                  <label>Kategory</label><span class="label label-danger pull-right content_error"></span>
                  <select class="form-control" name="kategori" id="kategori" >
					<option value="">- Pilih Kategori -</option>
					<?php
						if(!empty($kat)){
							foreach($kat as $k){
								echo '<option value="'.$k['id_kat'].'">'.$k['nama_kategori'].'</option>';
							}
						}
					?>
				</select>
                  
				  
                </div>
				
				
                <div class="form-group">
					
					<label>File</label><span class="label label-danger pull-right category_error"></span>
					<input type="file" class="form-control custom-file-input" name="userfile" id="userfile" accept="application/pdf" /><br/>
					<label id="file_name"></label>
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
    <a href="#"><button class="btn btn-success add_news"><i class="fa fa-plus"></i> Add Catalogue</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">

    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:23%">Judul</th>
			<th style="text-align:center; width:20%">Kategori</th>
			<th style="text-align:center; width:30%">Nama File</th>
			
			
			<th style="text-align:center; width:13%">Action</th>
			
			
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

$(function() {
	var path_role= '<?php echo site_url('catalogue/catalogue_data');?>';
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
        },
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

$('.add_news').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('#file_name').text('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_catalogue').val('');
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$(".yes_save").prop( "disabled", false );
	$('#frm_category').modal('show');
});
function edit_cat(dts){
	$('#frm_cat').find("input[type=text], select").val("");
	$('#file_name').text('');	
	var val = dts;
	var dt = val.split('Þ');
	$('#id_catalogue').val(dt[0]);
	$('#judul').val(dt[1]);
	$('#file_name').text('Nama File : '+dt[2]);	
	$('#kategori').val(dt[4]);	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$(".yes_save").prop( "disabled", false );
	$('#frm_category').modal('show');
}
$("#userfile").change(function(){
	$('#file_name').text('');
	readURL(this);
});
function readURL(input) {
	if (input.files && input.files[0]) {
        $('#file_name').text('Nama File : '+input.files[0].name);
    }
}

$('.yes_save').click(function(){
	var judul = $('#judul').val();
	var userfile = $('#userfile').val();
	var file_name = $('#file_name').text();
	$('.category_error').text('');
	$('.content_error').text('');
	if(judul <= 0 || judul == '') {
		$('.content_error').text('Judul harus diisi');
		return false;
	}
	
	if(file_name == '' || userfile == '') {
		$('.category_error').text('File harus diisi');
		return false;
	}
	$(".yes_save").prop( "disabled", true );
	var url = '<?php echo site_url('catalogue/simpan_cat');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});
function del_cat(id_category){	
	$('#del_id').val(id_category);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
}

$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('catalogue/del');?>';
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
</script>
