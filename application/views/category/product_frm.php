<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.table > tbody > tr > td{
		vertical-align : middle;
	}
	.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>
<?php
$tanggal = date('Y-m');

$photo = !empty($products->img) ? base_url('uploads/kategori/products/'.$products->img) : '';
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
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add/Edit Variant</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Nama Variant</label><span class="label label-danger pull-right nama_variant_error"></span>
                  <input type="text" class="form-control" name="nama_variant" id="nama_variant" value="" placeholder="Nama Variant" autocomplete="off" />
                  <input type="hidden" value="" name="id_variant" id="id_variant">
                </div>
               <div class="form-group" style="display:none;">
                  <label>Stok</label><span class="label label-danger pull-right stok_error"></span>
                  <input type="text" class="form-control" name="stok" id="stok" value="" placeholder="Stok" autocomplete="off" />
                  
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

<div class="box-body">	
	<table  class="table table-bordered table-reponsive">
	<form name="frm_edit" id="frm_edit" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Product Information  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="13%"><b>Nama Product </b></td>
			<td width="2%">:</td>
			<td width="35%">
            <input type="hidden" name="id_product" id="id_product" value="<?php echo !empty($products) ? $products->id_product : '';?>"  />
			<input class="form-control" name="nama_product" id="nama_product" placeholder="Nama Product" style="width:90%; height:18px;" type="text" value="<?php echo !empty($products->nama_product) ? ucwords($products->nama_product) : '';?>">
			</td>
            
            
            
            <td width="17%"><b>Kategori Wholesale</b> </td><td width="1%">:</td><td>
			<select class="form-control" name="kategori" id="kategori" >
            	<option value="">- Kategori Wholesale -</option>
                <?php
					if(!empty($kat)){
						foreach($kat as $k){
							if($products->id_kategori == $k['id_kategori']){
								echo '<option selected="selected" value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
							}else{
								echo '<option value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
							}
						}
					}
				?>
            </select>
			 </td>
            
			</tr>
            
			<tr>
            
            <td><b>Harga</b><span class="label label-danger pull-right"></span></td><td width="2%">:</td>
            <td>
			<input class="form-control" name="harga" id="harga" placeholder="Harga" style="width:90%; height:18px;" type="text" value="<?php echo !empty($products->harga) ? number_format($products->harga,0,',','.') : '0.00';?>">
			</td>
			
			
            <td><b>Sub Kategori Wholesale</b> </td><td width="2%">:</td>
            <td>
			<select class="form-control" name="sub_kategori" id="sub_kategori" >
            	<option value="">- Sub Kategori Wholesale -</option>
                <?php
					if(!empty($sub_kat)){
						foreach($sub_kat as $sk){
							if($products->id_subkategori == $sk['id_sub']){
								echo '<option selected="selected" value="'.$sk['id_sub'].'">'.$sk['nama_sub'].'</option>';
							}else{
								echo '<option value="'.$sk['id_sub'].'">'.$sk['nama_sub'].'</option>';
							}
						}
					}
				?>
            </select>
			 </td>
			
			</tr>
            
           <tr>
				
            	<td><b>Harga Crazy Sale</b></td>
                <td>:</td>
                <td>
				<input class="form-control" name="harga_crazysale" id="harga_crazysale" placeholder="Harga Crazy Sale" style="width:90%; height:18px;" type="text" value="<?php echo !empty($products->harga_crazysale) ? number_format($products->harga_crazysale,0,',','.') : '0.00';?>">
				</td>
				<td><b>Kategori Retail</b> </td><td width="1%">:</td><td>
				<select class="form-control" name="kategori_retail" id="kategori_retail" >
					<option value="">- Kategori Retail -</option>
					<?php
						if(!empty($kat2)){
							foreach($kat2 as $k){
								if($products->id_kategori2 == $k['id_kategori']){
									echo '<option selected="selected" value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}else{
									echo '<option value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}
							}
						}
					?>
				</select>
				 </td>
            </tr>	
			
			<tr>			
            	
				<td><b>Berat (Gram)</b><span class="label label-danger pull-right"></span></td><td width="2%">:</td>
				<td>
				<input class="form-control" name="weight" id="weight" placeholder="Berat" style="width:90%; height:18px;" type="text" value="<?php echo !empty($products->weight) ? number_format($products->weight,0,',','.') : '1.000';?>">
				</td>
				
				<td><b>Sub Kategori Retail</b> </td><td width="2%">:</td>
				<td>
				<select class="form-control" name="sub_kategori_retail" id="sub_kategori_retail" >
					<option value="">- Sub Kategori Retail -</option>
					<?php
						if(!empty($sub_cat2)){
							foreach($sub_cat2 as $sk){
								if($products->id_subkategori2 == $sk['id_sub']){
									echo '<option selected="selected" value="'.$sk['id_sub'].'">'.$sk['nama_sub'].'</option>';
								}else{
									echo '<option value="'.$sk['id_sub'].'">'.$sk['nama_sub'].'</option>';
								}
							}
						}
					?>
				</select>
				 </td>
            </tr>	
			
            
            <tr><td><b>Deskripsi</b></td><td width="2%">:</td><td>
				<textarea name="deskripsi" id="deskripsi" class="form-control" style="width:90%;" rows="5"><?php echo !empty($products->deskripsi) ? $products->deskripsi : '';?></textarea>
			</td>
			<td><b>Type Product</b></td><td width="2%">:</td><td>
				<?php if($products->type_trans == 1 ){
					echo '<input type="checkbox" name="type_trans" checked id="type_trans" style="height:18px; width:8%;" /> Retail <br/>';
				}else{
					echo '<input type="checkbox" name="type_trans" id="type_trans" style="height:18px; width:8%;" /> Retail <br/>';
				}?>
				<?php if($products->type_sample == 1 ){
					echo '<input type="checkbox" name="type_sample" checked id="type_sample" style="height:18px; width:8%;" /> Wholesale';
				}else{
					echo '<input type="checkbox" name="type_sample" id="type_sample" style="height:18px; width:8%;" /> Wholesale';
				}?>
			</td>
			</tr>	
			
            
            <tr>
            	<td><b>Photo</b></td>
                <td>:</td>
                <td><input type="file" name="userfile" id="userfile" accept="image/*" /></td>
				<td><b>Crazy Sale</b></td>
                <td>:</td>
                <td>
				<?php if(!empty($products->crazy_sale) && $products->crazy_sale = 'crazy_sale' ){
					echo '<input type="checkbox" name="crazy_sale" checked id="crazy_sale" style="height:18px; width:8%;" />';
				}else{
					echo '<input type="checkbox" name="crazy_sale" id="crazy_sale" style="height:18px; width:8%;" />';
				}?>
				</td>
            </tr>	
            <tr>
            <td></td><td></td>
            <td><div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
				<img id="blah" style="width: 200px; height: 150px;" src="" alt="">
				
			</div></td>
			<td></td>
			<td></td>
			<td></td>
            </tr>	
			</table>
			</td>
		
	</table>
	
	</form>
	
	<?php if($id_product > 0){ ?>
	<br/>
	<table  class="table table-bordered table-reponsive">
	<form name="frm_edit" id="frm_edit" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
		<div class='alert alert-info alert-dismissable' id="success-alert">
   
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			<div id="id_text"><b>Welcome</b></div>
		</div>
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Variant  </th>
		</tr>
		<tr>
			<td><button type="button" class="btn btn-success add_variant"><i class="fa fa-plus"></i> Add Variant</button></td>
			
		</tr>
		<tr>
			
			<td> 
				<table id="example88" class="table table-bordered table-striped">
					<thead><tr>
						<th style="text-align:center; width:4%">No.</th>
						<th style="text-align:center; width:62%">Nama Variant</th>			
						
						<th style="text-align:center; width:26%">Action</th>
					</tr>
					</thead>
					<tbody>
						<?php 				
							$i =1;							
							$info = '';			
							if(!empty($variant)){		
								foreach($variant as $v){									
									$info = $v['id_variant'].'Þ'.$v['nama_variant'].'Þ'.$v['stok'];
									echo '<tr>';
									echo '<td align="center">'.$i++.'.</td>';
									echo '<td>'.$v['nama_variant'].'</td>';
									
									echo '<td align="center" style="vertical-align: middle;">		
			
			<a href="#" id="'.$info.'" title="Edit" class="edit_variant"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<button title="Delete" id="'.$v['id_variant'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
									
									echo '</tr>';
								}
							}
						?>
					</tbody>
				
				</table>
			</td>
		</tr>
	</table>
	
	</form>
	
	
	<?php } ?>
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
var photo = '<?php echo $photo;?>';
$('.del_news').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.add_variant').click(function(){
	$('.nama_variant_error').text('');
	$('.stok_error').text('');
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$(".yes_save").prop( "disabled", false );
	$('#frm_category').modal('show');
});
$('.edit_variant').click(function(){
	$('.nama_variant_error').text('');
	$('.stok_error').text('');
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");	
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_variant').val(dt[0]);
	$('#nama_variant').val(dt[1]);
	$('#stok').val(dt[2]);	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$(".yes_save").prop( "disabled", false );
	$('#frm_category').modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('category/del_variant');?>';
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
	alert('ok');
	$(".yes_save").prop( "disabled", true );
	var id_product = '<?php echo $id_product;?>';
	var nama_variant = $('#nama_variant').val();
	var stok = $('#stok').val();
	var id_variant = $('#id_variant').val();
	$('.nama_variant_error').text('');
	$('.stok_error').text('');
	if(nama_variant == '' && nama_variant == 0){
		$('.nama_variant_error').text('Nama Variant harus diisi');
		$(".yes_save").prop( "disabled", false );
		return false;
	}
	
	var url = '<?php echo site_url('category/save_variant');?>';
	$.ajax({
		data : {id_product : id_product,nama_variant:nama_variant, stok:stok, id_variant:id_variant},
		url : url,
		type : "POST",
		success:function(response){
			if(response > 0){
				location.reload();
			}				
		}
	});
	
});
$('#blah').attr('src', photo);
$('.canc').click(function(){
	window.location = '<?php echo site_url('products');?>';
});
$('#blah').attr('src', photo);
 $('.btn_save').click(function(){
	 var url = '<?php echo site_url('category/simpan_product');?>';
	 $('#frm_edit').attr('action', url);
	 $('#frm_edit').submit();
	 //window.location = '<?php echo site_url('merchants');?>';
 });
$("#userfile").change(function(){
	$('#blah').attr('src', '');
	readURL(this);
});
function readURL(input) {
   if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
}

$('#stok').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});

$('#harga').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
$('#harga_crazysale').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
$('#weight').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});

$('#kategori').on('change', function() {
	var _val = this.value;
	var opt = '';
	opt += '<option value="">- Sub Kategori Wholesale -</option>';			
	var url = '<?php echo site_url('category/get_sub');?>';
	if(_val > 0){
		$.ajax({
			data : {kategori : _val},
			url : url,
			dataType  : 'json',
			type : "POST",
			success:function(response){					
				if(response.length != ''){					
					for (var i = 0; i < response.length; i++) {																
						opt += '<option value="'+response[i].id_sub+'">'+response[i].nama_sub+'</option>';											
					}									
				}
				$("#sub_kategori").html(opt);
			}
		});
	}else{
		$("#sub_kategori").html(opt);
	}			
			
});
$('#kategori_retail').on('change', function() {
	var _val = this.value;
	var opt = '';
	opt += '<option value="">- Sub Kategori Retail -</option>';			
	var url = '<?php echo site_url('category/get_sub');?>';
	if(_val > 0){
		$.ajax({
			data : {kategori : _val},
			url : url,
			dataType  : 'json',
			type : "POST",
			success:function(response){					
				if(response.length != ''){					
					for (var i = 0; i < response.length; i++) {																
						opt += '<option value="'+response[i].id_sub+'">'+response[i].nama_sub+'</option>';											
					}									
				}
				$("#sub_kategori_retail").html(opt);
			}
		});
	}else{
		$("#sub_kategori_retail").html(opt);
	}			
			
});
$(function() {               
    $('#example88').dataTable({});
});
</script>
