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

$photo = !empty($news->img) ? base_url('uploads/news/'.$news->img) : '';
?>


<div class="box box-success">

<div class="box-body">	
	<table  class="table table-bordered table-reponsive">
	<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> News  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="8%"><b>Judul </b></td>
			<td width="2%">:</td>
			<td>
            <input type="hidden" name="id_news" id="id_news" value="<?php echo !empty($news) ? (int)$news->id_news : '';?>"  />
			<input class="form-control" name="judul" id="judul" placeholder="Judul" style="width:97%; height:18px;" type="text" value="<?php echo !empty($news->judul) ? ucwords($news->judul) : '';?>">
			</td>           
			</tr>
            
			<tr>
            	<td><b>Image</b></td>
                <td>:</td>
                <td><input type="file" name="userfile" id="userfile" accept="image/*" /></td>
				
            </tr>	
            <tr>
            <td></td><td></td>
            <td><div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
				<img id="blah" style="width: 200px; height: 150px;" src="" alt="">
				
			</div></td>
			
            </tr>		
            
            <tr><td><b>Berita</b></td><td width="2%">:</td><td> 
				<textarea class="form-control" name="content" id="content" value="" placeholder="News" autocomplete="off"><?php echo !empty($news->description) ? ucwords($news->description) : '';?></textarea>
			</td>
			
			</tr>	
			
            
            
			</table>
			</td>
		
	</table>
	
	</form>
	
	
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
var photo = '<?php echo $photo;?>';
$("input").attr("autocomplete", "off"); 
 $(function (config) {
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('content');
});
$('#blah').attr('src', photo);
$('.canc').click(function(){
	window.location = '<?php echo site_url('news');?>';
});
$('#blah').attr('src', photo);

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

$('.btn_save').click(function(){
	//var content = $('#content').val();
	var content = CKEDITOR.instances['content'].getData();
	$('.content_error').text('');
	// if(content <= 0 || content == '') {
		// $('.content_error').text('Konten harus diisi');
		// return false;
	// }
	for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();

	// var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('news/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});
</script>
