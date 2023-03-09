<section id="content-wrapper">
	<div class="fliprecord_content">
		<div class="fliprecord_innercon mb-2">
			<div class="row pt-4 flipviewwholerow">
				<div class="col-md-4 mt-1">
				 <?php 
				 /* $colmheight = '0px';
				 if( empty(get_post_meta($fliprecordingid,'additional_notes',true)) && empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
					 $colmheight = '56vh';
				 }elseif(!empty(get_post_meta($fliprecordingid,'additional_notes',true)) && empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
					 $colmheight = '26vh';
				 }elseif(empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
					 $colmheight = '26vh';
				 }elseif(!empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
					 $colmheight = '0vh';
				 }
				 if(empty(get_post_meta($fliprecordingid,'recording_multiple_image_path',true))){
					 $colmheight = '44px';
				 } */
				 
				/*  $div_show = '';
				 if( $colmheight == '0px' || $colmheight == '0vh' ){
					$div_show = 'display:none;';
				 } */
				 
				if( !empty($repliesid) ){
					$fliprecordingid = $repliesid;
				}
				
				$div_show = '';
				if( !empty(get_post_meta($fliprecordingid,'additional_notes',true)) && !empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true)) && !empty(get_post_meta($fliprecordingid,'recording_multiple_image_path',true))){
					$div_show = 'display:none;';
				}
				 /* lxprint($square_icon); */
				 
				 ?>
				 <div class="row mb-2" style="border:3px solid <?php echo $color_palette['light_grey'];?>;border-radius: 10px;margin:unset;<?php echo $div_show; ?>">
					<div class="col-md-1 col-1 col-xs-1 p-2">
						<i class="<?php echo $square_icon['infobox']; ?>" style="font-size:20px;"></i>
					</div>
					<div class="col-md-11 col-11 col-xs-11 p-2" style="color:<?php echo $color_palette['grey'];?>">
						<?php 
						if(empty(get_post_meta($fliprecordingid,'recording_multiple_image_path',true))){
							echo "<div>Images: None</div>";
						}
						if(empty(get_post_meta($fliprecordingid,'additional_notes',true))){
							echo "<div>Additional text: None</div>";
						}
						if(empty(get_post_meta($fliprecordingid,'recordingpdf_upload',true))){
							echo "<div>Attachments: None</div>";
						}
						?>
					</div>
				 </div>
				<?php if(!empty(get_post_meta($fliprecordingid,'additional_notes',true))){ ?>
					<div>
						<div class="form-group" style="position:relative;">
							<div class="fliprecord_textblock">
								<?php echo FnFormatMytext( get_post_meta($fliprecordingid,'additional_notes',true) );?>
							</div>
							<?php /* <i class="fa fa-2x <?php echo $flipicons['fullsceenon'];?> flipviewtextzoom" aria-hidden="true"></i> */ ?>
						</div>
					</div>
				<?php } ?>
					<div class="modal fade" id="flipviewtextzoommodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document" style="max-width: 100%;margin: unset;">
						<div class="modal-content" style="height: 100vh;width: 100vw;">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <i class="<?php echo $flipicons['fullsceenoff'];?> flipviewtextzoomout" aria-hidden="true"></i>
							</button>
						  </div>
						  <div class="modal-body" style="overflow:auto;">
							<?php echo FnFormatMytext( get_post_meta($fliprecordingid,'additional_notes',true) );?>
						  </div>
						</div>
					  </div>
					</div>
					<script>
						jQuery(document).on('click','.flipviewtextzoom',function(){
							jQuery('#flipviewtextzoommodal').modal('show');
						});
					</script>
					<?php 
					$allpdf = get_post_meta($fliprecordingid,'recordingpdf_upload',true);
					if(!empty($allpdf)){
					?>
					<div class="pt-4 view_pdf_block">
						<div style="overflow: auto;height: 90px;">
							<?php 
							foreach( $allpdf as $pdfurl ){
							?>
								<a href="<?php echo $pdfurl;?>" download ><button class="btn btn_normal_inverse_state w-100" style="text-align: justify;margin: 5px 0px;">
									<i class="<?php echo $flipicons['attachment'];?>" aria-hidden="true"></i>
									<span><?php echo basename( $pdfurl );?></span>
								</button></a>
							<?php 
							}
							 ?>
						</div>
					</div>
					<?php } ?>
					<div class="pt-4">
						<?php  
						$audiorec = get_post_meta($fliprecordingid,'flip_recording_audio',true);
						$auidogt = '';
						if( !empty($audiorec) ){
							$auidogt = $audiorec;
						}
						?>
						<audio controls controlsList="nodownload noplaybackrate">
						  <source src="<?php echo $auidogt;?>">
						Your browser does not support the audio element.
						</audio>
					</div>
				</div>
				<div class="col-md-8 mt-1">
					<?php 
					$sliderimages = get_post_meta($fliprecordingid,'recording_multiple_image_path',true);
						/* echo "<pre>";print_r(get_post_meta($fliprecordingid,'recording_multiple_image_path',true)); */
					if(!empty($sliderimages)){
					?>
					<div id="MultiImagesCarousal" class="carousel slide" data-interval="false" >
					
						<ol class="carousel-indicators">
							<?php 
							$i=0;
							foreach( $sliderimages as $data ){
								$isactive = '';
								if($i==0){
									$isactive='active';
								}
							?>
							<li data-target="#MultiImagesCarousal" data-slide-to="<?php echo $i;?>" class="<?php echo $isactive;?>"></li>
							<?php $i++;} ?>
						</ol>
						<div class="carousel-inner">
							<?php 
							$i=1;
							foreach( $sliderimages as $simg ){
								$classactive = '';
								if( $i == 1 ){
									$classactive = 'active';	
								}
							?>
							<div class="carousel-item <?php echo $classactive;?>">
							  <img class="d-block" src="<?php echo $simg['original'];?>" alt="First slide">
							</div>
							<?php $i++;} ?>
						</div>
						<div class="">
							<a class="carousel-control-prev flipviewarrowleft" href="#MultiImagesCarousal" role="button" data-slide="prev">
								<i class="fa fa-chevron-left" style="font-size: 30px;"></i>
								<span class="sr-only">Previous</span>
							</a>
						</div>
						<div class="">
							<a class="carousel-control-next flipviewarrowright" href="#MultiImagesCarousal" role="button" data-slide="next">
								<i class="fa fa-chevron-right" style="font-size: 30px;"></i>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</div>
					<div class="d-flex justify-content-center">
						<div class="num"></div>
					</div>
					<?php }else{
						$tmbimg = $lx_plugin_urls['lx_lms_lite'].'/assets/img/flip_thumbnail.png';
						?>
						<div class="imagesthumb">
							<img src="<?php echo $tmbimg;?>" />
						</div>
						<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="row bg-dark flipviewfooter">
	<?php 
	if( !empty($repliesid) ){
		$fliprecordingid = $parentrecid;
	}
	
	$settting_arr = get_post_meta($fliprecordingid,'settings_array',true);
	$all_response_ids = $wpdb->get_results("select post_id from ".$wpdb->prefix."postmeta where meta_key='parent_recording_id' and meta_value=".$fliprecordingid);
	
	if( $settting_arr['replies'] == 'ON' ){
		if( $settting_arr['repliesvis'] == 'Open' || ( get_post( $fliprecordingid )->post_author == get_current_user_ID() || current_user_can('admin') || current_user_can('site_owner') ) ){
	?>
	
	<div class="replies_btns_main" style="position: absolute;right: 7%;">
		<div class="d-flex replies_btns justify-content-end">
			<div class="add_recording_reply">
				<form method="post" action="<?php echo site_url().'/create-fl1p-recording/'; ?>">
					<input type="hidden" name="parentfliplistid" value="<?php echo $parent_fliplistid; ?>" />
					<input type="hidden" name="parentrec_id" value="<?php echo $fliprecordingid; ?>" />
					<button type="submit" class="btn add_reply_btn"><i class="<?php echo $flipicons['reply'];?>" aria-hidden="true"></i></button>
				</form>
			</div>
			<div class="view_recording_response">
				<button type="button" class="btn view_response_btn"><i class="<?php echo $flipicons['responses'];?>" aria-hidden="true"></i>
				</button>
				<small class="count_recresponses"><?php	echo '('.count($all_response_ids).')'; ?></small>
				<input type="hidden" class="total_recresponses" name="total_recresponses" value="<?php	echo count($all_response_ids); ?>" />
			</div>
		</div>
		<div class="text-white replies_txt" style="">Reply / Respond</div>
	</div>
	<?php } }?>
	<div class="col-md-4">
		<div class="pt-2 pb-2">
			<h2 class="text-white"><?php echo get_post( $fliprecordingid )->post_title;?></h2>
			<?php
			$subtitle = date('jS F Y - h:i A',strtotime( get_post( $fliprecordingid )->post_date ));
			if( !empty(get_post_meta($fliprecordingid,'subtitle',true)) ){
				$subtitle = get_post_meta($fliprecordingid,'subtitle',true);
			}
			?>
			<div class="text-white">- <?php echo $subtitle;?></div>
		</div>
	</div>
	<?php 
	
	/* if( !empty($settting_arr) ){
		if( $settting_arr['replies'] == 'ON' && $settting_arr['repliesvis'] == 'Open' ){
			FNFlipRecordingResponses($fliprecordingid,$all_response_ids);
		}else if( $settting_arr['replies'] == 'ON' && $settting_arr['repliesvis'] == 'Restricted' ){
			if ( current_user_can('administrator') || get_post($fliprecordingid)->post_author ){
				FNFlipRecordingResponses($fliprecordingid,$all_response_ids);
			}
		}
	} */
	if( $settting_arr['replies'] == 'ON' ){
		if( $settting_arr['repliesvis'] == 'Open' || ( get_post( $fliprecordingid )->post_author == get_current_user_ID() || current_user_can('admin') || current_user_can('site_owner') ) ){
		?>
		<div class="col-md-4"> 
			<?php
			if( !empty($all_response_ids) ){	
			/* echo "<pre>";print_r($all_response_ids); */
			$all_replies_id = array();
			foreach( $all_response_ids as $response_id){
				$all_replies_id[] = $response_id->post_id;
			}
			
			/* echo "<pre>";print_r(end($all_replies_id)); */
			
			$i=1;
			foreach( $all_response_ids as $response_id ){
				$res_id = $response_id->post_id;
				
				$response_title = get_post( $res_id )->post_title;
				$response_subtitle = date('jS F Y - h:i A',strtotime( get_post( $res_id )->post_date ));
				if( !empty(get_post_meta($res_id,'subtitle',true)) ){
					$response_subtitle = get_post_meta($res_id,'subtitle',true);
				} 
				
				/* echo $res_id .'--'. end($all_replies_id); */
				$displayreplies = 'style="display:none;"';$active = '';$attrhidden = '';$firstnavigation ='';$lastnavigation ='';
				if( $all_replies_id[0] == $res_id ){
					$firstnavigation = 'style="display:none;"';
				}
				if( $res_id == end($all_replies_id) ){
					$lastnavigation = 'style="display:none;"';
				}
				if( $i==1 && empty($repliesid)){
					$displayreplies = '';
					$active = 'active';
					$attrhidden = 'hidden';
				}
				
				if( !empty($repliesid) && $res_id == $repliesid ){
					$displayreplies = '';
					$active = 'active';
				}
				/* echo $displayreplies.'---'.$active.'--'.$res_id.'--'.$repliesid; */
			?>
			
			<div class="row repliesnavigatordiv repliesnavigatordiv<?php echo $res_id;?> <?php echo $active; ?>" data-replyid="<?php echo $res_id;?>" <?php echo $displayreplies; ?> <?php echo $attrhidden;?> >
				<div class="col-md-1 col-1 d-flex align-items-center">
				<?php if(count($all_response_ids) > 1){ ?>
					<div class='' <?php echo $firstnavigation; ?>><a href="javascript:void(0);" data-replyid="<?php echo $res_id;?>" data-click = "previous" class="text-white previousreplies"><i class="<?php echo $flipicons['navigation_left'];?>" style="font-size:30px;"></i></a></div>
				<?php } ?>
				</div>
				<div class="col-md-10 col-10 d-flex justify-content-center">
					<div class="" style="padding: 8px 20px;">
						<div class=""><h2 class="text-white"><?php echo $response_title; ?></h2></div>
						<div class="text-white"><?php echo $response_subtitle; ?></div>
					</div>
				</div>
				<div class="col-md-1 col-1 d-flex align-items-center" style="padding:unset;">
				<?php if(count($all_response_ids) > 1){ ?>
					<div class='' <?php echo $lastnavigation; ?>><a href="javascript:void(0);" data-click = "next" data-replyid="<?php echo $res_id;?>" class="text-white nextreplies"><i class="<?php echo $flipicons['navigation_right'];?>" style="font-size:30px;"></i></a></div>
				<?php } ?>
				</div>
			</div>
			<?php
				$i++;
			} 
		}	
		?>
		</div> 
		<?php
		}
	}
	
	/* echo "<pre>";print_r($settting_arr['repliesvis']);
	die(); */
	/* echo $fliprecordingid;
	echo get_post( $fliprecordingid )->post_author; */
	/* if( $settting_arr['replies'] == 'ON' ){
		if( $settting_arr['repliesvis'] == 'open' || ( get_post( $fliprecordingid )->post_author == get_current_user_ID() || current_user_can('admin') || current_user_can('site_owner') ) ){
	?>
	<div class="col-md-4 d-flex justify-content-center">
		
	</div>
		<?php } } */  ?>  
	<?php 
	$repliesedit = 'style="display:none"';
	if( !empty($repliesid) ){
		$repliesid = $repliesid;
		$repliesedit = '';
	}else{
		$repliesid = $all_replies_id[0];
	}
	?>
	<?php if( get_post($repliesid)->post_author == get_current_user_id() && !empty($repliesid) ){ ?>
	<div class="fliprecording_response_edit_div" <?php echo $repliesedit; ?> >
		<form method="post" action="<?php echo site_url().'/create-fl1p-recording/'; ?>">
			<input type="hidden" class="hidrepliesid" name="response_id" value="<?php echo $repliesid;?>">
			<input type="hidden" name="parentrec_id" value="<?php echo $fliprecordingid;?>">
			<input type="hidden" name="parentfliplistid" value="<?php echo $parent_fliplistid; ?>" />
			<button type="submit" class="btn_normal_state"><i class="<?php echo $square_icon['edit'];?>"></i></button>
		</form>
	</div>
	<?php } ?>
</div>