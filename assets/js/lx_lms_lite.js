/** Upload the thumbnail_image **/
jQuery(document).on('change','.lxed_add_thumbnail',function(e){
	var cat_info = [];
	jQuery('.vw_lxed_categories:checked').each(function(i){
	  cat_info[i] = jQuery(this).val();
	});
	if(cat_info.length == 0){
		jQuery('.alert_box').html("Please Select Available Categories  First.");
		jQuery('.alert_box').show();
		setTimeout(function(){
			jQuery('.alert_box').hide();
			jQuery('#lxed_add_thumbnail').val('');
			
		},3000);
		return false;
	}
  	else{
		jQuery('.lp-screen').show();
		var files = e.target.files;
		filename=files[0].name;
		jQuery('.hid_file_name').val(filename);
		
		var done = function (url) {
		  image.src = url;
		  jQuery('.alert').hide();
		  jQuery('#lxed_modal').modal({backdrop:'static', keyboard:false});
		};
		var reader;
		var file;
		var url;
		
		file = files[0];
		filename=files[0].name;
		if (URL) {
			  done(URL.createObjectURL(file));
		} else if (FileReader) {
		reader = new FileReader();
		reader.onload = function (e) {
		  done(reader.result);
		  
		};
		reader.readAsDataURL(file);
		}
		jQuery('.lp-screen').hide();
		jQuery('.hid_class_click').val('lxed_add_thumbnail');
	}
});

/* function for store thumb type info */
function store_thumb_type_info(getdataimage){
	var dataimage={'mode':getdataimage['mode'],'blog_post_id':getdataimage['blog_post_id'],'dataurl':getdataimage['dataurl'],'filename':getdataimage['filename'],'action':'fn_lx_editor_upload_thumbnail'};
	return dataimage;
}