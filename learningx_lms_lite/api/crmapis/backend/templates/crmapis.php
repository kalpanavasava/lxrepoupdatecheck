<?php 
global $lx_plugin_paths,$lx_plugin_urls,$color_palette,$menu_settings,$community_tiles_interface,$tiles_style,$style_2_tiles_interface,$lexicon,$lightbox_settings,$page_style,$breakpoint,$page_devider,$square_icon,$kit_code;
include($lx_plugin_paths['lx_lms_lite'].'assets/css/lms_user_interface_settings.php');

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
	var lx_lms_js = {'ajaxurl':"<?php echo admin_url( 'admin-ajax.php' ); ?>"};
</script>
<script src="<?php echo $lx_plugin_urls['lx_lms_lite'].'api/crmapis/js/api.js';?>"></script>
<div class="lp-screen" style="display:none;"><span><img class="user_interface_loader_img" src="<?php echo get_stylesheet_directory_uri().'/assets/loader/05.svg'?>"></span></div>
<script src="https://kit.fontawesome.com/<?php echo $kit_code;?>.js" crossorigin="anonymous"></script>
<div class="container user_interface">
	<div class="row user_interface_setting_top pt-5">
		<div class="col-md-12">
			<h2 class="head_h2">CRM APIs</h2>
		</div>
	</div>
	<hr/>
	<div class="main_div">
		<div class="row row_tab seven-cols text-center">
			<div class="active col ui ui_settings_salesforce tab_bottom col-md-3">
				<a class="primary tablinks" style="cursor: pointer;" onclick="opentab(event, 'salesforce_tab','ui_settings_salesforce');">Salesforce</a> 
			</div>	
		</div>
		<div class="settings_salesforce tabcontent" id="salesforce_tab">
			<form method="post" id="">
				<div class="mt-3">
					<i>Please review the documentation for any additional information or updates.</i><br/>
					<a href="https://docs.google.com/document/d/1-6J3r4CEg9OLyXJtOmPPHFfwfk03K-qBAzDlW3EDgP8/edit?usp=sharing"><button type="button" class="btn_normal_state">View Documentation</button></a>
				</div>
				<div class="row pt-3">
					<div class="col-md-12 admin_section_title">
						<h4 class="head_h4">WEBHOOKS - CONNECT TO SALESFORCE - AUTHENTICATION</h4>
					</div>
				</div>
				<a href="https://developer.salesforce.com/docs/atlas.en-us.api_iot.meta/api_iot/qs_auth_connected_app.htm">SALESFORCE HELP</a>
				
				<div class="row">
					<div class="col-md-2">
						
					</div>
					<div class="col-md-5 justify-content-center d-flex ai_center">
						<?php 
						$salesforce_environment = get_option('salesforce_environment');
						/* echo "<pre>";print_r($salesforce_environment); */
						$envtype = '';$stg_envcolor = '';$prod_envcolor='style="border-color:'.$color_palette['green'].';color:'.$color_palette['green'].';"';$st_test_button = 'disabled=disabled';$prod_test_button = '';$prod_class ='btn_normal_state';$stg_class = 'btn_dark_state';$activetag_stg = 'Inavtive';$activetag_prod = 'Active';
						if( $salesforce_environment['environment'] == 'staging' ){
							$envtype = 'checked';
							$stg_envcolor = 'style="border-color:'.$color_palette['green'].';color:'.$color_palette['green'].';"';
							$prod_envcolor = '';
							$prod_test_button = 'disabled=disabled';
							$stg_class = 'btn_normal_state';
							$prod_class = 'btn_dark_state';
							$activetag_stg = 'Active';
							$activetag_prod = 'Inactive';
							$st_test_button = '';
						}
						?>
						<input type="hidden" class="color_green" value="<?php echo $color_palette['green'];?>">
						<label class="col-form-label">STAGING/SANDBOX</label>&nbsp;&nbsp;<small class="staging_status"><?php echo $activetag_stg;?></small>
						<div style="position:relative;">
							<label class="lx_toggle">
								<input type="checkbox" class="salesforceenv" id="salesforceenv" name="salesforceenv" <?php echo $envtype?>>
								<span class="off"><i class="<?php echo $square_icon['toggle_off'];?>"></i></span>
								<span class="on" style="display:none;"><i class="<?php echo $square_icon['toggle_on'];?>"></i></span>
							</label>
						</div>
					</div>
					<div class="col-md-5 justify-content-center d-flex ai_center">	
						<label class="col-form-label">PRODUCTION</label>&nbsp;&nbsp;<small class="prod_status"><?php echo $activetag_prod;?></small>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<label class="col-form-label">Endpoint</label>
					</div>
					<div class="col-md-5 staging_input">
						<input name="" type="text" id="bkstgendpoint" class="form-control" value="<?php echo $salesforce_environment['staging']['stg_endpoint'];?>" <?php echo $stg_envcolor;?>>
					</div>
					<div class="col-md-5 prod_input">	
						<input name="" type="text" id="bkliveendpoint" class="form-control" value="<?php echo $salesforce_environment['production']['prod_endpoint'];?>" <?php echo $prod_envcolor;?>>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<label class="col-form-label">Consumer Key</label>
					</div>
					<div class="col-md-5 staging_input">
						<input name="" type="text" id="bkstgconsumerkey" class="form-control" value="<?php echo $salesforce_environment['staging']['stg_consumerkey'];?>" <?php echo $stg_envcolor;?>>
					</div>
					<div class="col-md-5 prod_input">	
						<input name="" type="text" id="bkliveconsumerkey" class="form-control" value="<?php echo $salesforce_environment['production']['prod_consumerkey'];?>" <?php echo $prod_envcolor;?>>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<label class="col-form-label">Consumer Secret</label>
					</div>
					<div class="col-md-5 staging_input">
						<input name="" type="text" id="bkstgconsumersec" class="form-control" value="<?php echo $salesforce_environment['staging']['stg_consumersecret'];?>" <?php echo $stg_envcolor;?>>
					</div>
					<div class="col-md-5 prod_input">	
						<input name="" type="text" id="bkliveconsumersec" class="form-control" value="<?php echo $salesforce_environment['production']['prod_consumersecret'];?>" <?php echo $prod_envcolor;?>>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<label class="col-form-label">Username</label>
					</div>
					<div class="col-md-5 staging_input">
						<input name="" type="text" id="bkstgusername" class="form-control" value="<?php echo $salesforce_environment['staging']['stg_username'];?>" <?php echo $stg_envcolor;?>>
					</div>
					<div class="col-md-5 prod_input">	
						<input name="" type="text" id="bkliveusername" class="form-control" value="<?php echo $salesforce_environment['production']['prod_username'];?>" <?php echo $prod_envcolor;?>>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<label class="col-form-label">Password</label>
					</div>
					<div class="col-md-5 staging_input">
						<input name="" type="text" id="bkstgpassword" class="form-control" value="<?php echo $salesforce_environment['staging']['stg_password'];?>" <?php echo $stg_envcolor;?>>
					</div>
					<div class="col-md-5 prod_input">	
						<input name="" type="text" id="bklivepassword" class="form-control" value="<?php echo $salesforce_environment['production']['prod_password'];?>" <?php echo $prod_envcolor;?>>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-2">
						<button type="button" class="btn_normal_state save_salesforce_data">Save</button>
					</div>
					<div class="col-md-5">
						<button type="button" data-env="staging" class="<?php echo $stg_class;?> btn_staging_test" <?php echo $st_test_button;?>>Test</button>
						<span class="stg_testprompt" style="color:red;display:none;"></span>
					</div>
					<div class="col-md-5">
						<button type="button" data-env="prod" class="<?php echo $prod_class;?> btn_prod_test" <?php echo $prod_test_button;?>>Test</button>
						<span class="stg_prodprompt" style="color:red;display:none;"></span>
					</div>
				</div>
				<div class="row pt-3">
					<div class="col-md-12 admin_section_title">
						<h4 class="head_h4">APIs - CONNECT TO LEARNINGX FROM SALESFORCE - AUTHENTICATION DETAILS</h4>
					</div>
				</div>
				<a href="https://docs.google.com/document/d/1-6J3r4CEg9OLyXJtOmPPHFfwfk03K-qBAzDlW3EDgP8/edit?usp=sharing">LEARNINGX API DOCUMENTATION</a>
				<div class="mt-3">
					<button type="button" class="btn_normal_state bkcreatenewapikey">Create New</button>
				</div>
				<div class="mt-3">
					<b>Endpoint:</b> <?php echo site_url().'/api';?>
				</div>
				<div class="mt-3 bktable_create">
					<div class="bktableheader row">
						<div class="col-md-2"><b>Assign to</b></div>
						<div class="col-md-2"><b>Consumer Key</b></div>
						<div class="col-md-2"><b>Consumer Secret</b></div>
						<div class="col-md-2"><b>Last Used</b></div>
						<div class="col-md-1"></div>
						<div class="col-md-3"></div>
					</div>
					<hr class="mt-1">
					<div class="bktablebody">
						<?php 
						$args = array(
									'meta_query' => array(
										array(
											'key' => 'customapipoint',
											'compare' => 'EXISTS'
										),
									)
								);
						$techmanagers = get_users( $args );
						
						foreach( $techmanagers as $tm ){
							$tmid = $tm->ID;
							
							$user_meta = get_userdata($tmid);
							$user_roles = $user_meta->roles;
							$is_techrole = 0;
							if(in_array('technology_manager',$user_roles)){
								$is_techrole = 1;
							}
							
							
							$apipoint = get_user_meta( $tmid , 'customapipoint' ,true );
							$clientkey = $apipoint['clientkey'];
							$clientsec = $apipoint['clientsec'];
							$last_used = get_user_meta( $tmid , 'api_key_last_used' ,true );
							$usernicename = $tm->user_nicename;
							/* lxprint($apipoint); */
							?>
							<div class="row bkapitable_row<?php echo $tmid;?>">
								<div class="col-md-2">
									<?php echo $usernicename;?>
								</div>
								<div class="col-md-2">
									<div class="input-group mb-3">
										<input type="hidden" class="bkclientidcusapihid<?php echo $tmid;?>" value="<?php echo $clientkey;?>">
										<input type="text" readonly class="form-control bkclientidcusapi" value="<?php echo substr($clientkey, 0, 9).'...';?>">
										<button type="button" class="btn_normal_state btncpyclientkey" data-id="<?php echo $tmid;?>" id="basic-addon1">copy</button>
										<div class="w-100 keycopied<?php echo $tmid;?>" style="display:none;">copied</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<input type="hidden" class="bkclientseccusapihid<?php echo $tmid;?>" value="<?php echo $clientsec;?>">
										<input type="text" readonly class="form-control bkclientseccusapi" value="<?php echo substr($clientsec, 0, 9).'...';?>">
										<button type="button" class="btn_normal_state btncpyclientsec" data-id="<?php echo $tmid;?>" id="basic-addon1">copy</button>
										<div class="w-100 seccopied<?php echo $tmid;?>" style="display:none;">copied</div>
									</div>
								</div>
								<div class="col-md-2">
									<?php 
									if(!empty($last_used)){
										echo date( 'Y-m-d H:i:s',$last_used );
									}else{
										echo 'NA';
									}
									?>
								</div>
								<div class="col-md-1">
									<button type="button" class="btn_danger_state bkcusapideletebtn" data-id="<?php echo $tmid;?>" ><i class="fas fa-trash"></i></button>
								</div>
								<div class="col-md-3">
									<span><?php if($is_techrole == 0 && empty($tmid)){echo "User is no longer a Tech Manager. This key set is now invalid. Please delete.";} ?></span>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="bkcreatnewcusapiauthmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create new Authentication</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal_body_cusapi">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="bkdeleteauthmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Remove API Authentication Keys</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div>Removing these keys will break any existing connections.</div>
			<div class="mb-2">Are you sure you want to proceed?</div>
			<button type="button" data-dismiss="modal" aria-label="Close" class="btn_dark_state">Cancel</button>
			<button type="button" class="btn_normal_state bkcusapideletebtnper">Confirm</button>
      </div>
    </div>
  </div>
</div>