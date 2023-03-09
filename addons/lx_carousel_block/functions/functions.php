<?php 
/**** lx_carousel_block get category content****/
function get_category_content($attributes,$view_selection){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$id = $attributes['lx_category_selection'];
	$course_status = $attributes['lx_course_status'];
	$course_access = $attributes['lx_course_access'];
	$term_ids=explode(',',$id);
	if( count($term_ids) == 1 ){ ?>
	<style>
		.row_tab {
			width:100% !important;
		}
	</style>
	<?php }
	?>
	<style>
		.row_tab{
			width: 70% !important;
			margin: 0 auto !important;
			text-align: center;
		}
		.tab_bottom {
			cursor: pointer;
			border-bottom: 2px solid <?php echo $color_palette['hyperlinks']; ?> !important;
		}
		.tabcontent {
			display:none;
		}
	</style>
	<?php
	/* if(is_front_page()){ ?>
		<div class='lx_home_main'>
	<?php
	} */
	?>
	<div class="<?php echo $attributes['className']; ?>">
	<?php
	if( $view_selection == 'Tab' ){
		$termsidsarr = array();
		foreach( $term_ids as $td ){
			$wterm =  get_term_by('id',$td,'category');
			if(is_super_admin()){
				$termsidsarr[] = $td;
			}else{
				if( $wterm->slug != 'test' ){
					$termsidsarr[] = $td;
				}
			}
			
		}
		$term_ids = $termsidsarr;
	?>
		<div class="course_tab_row">
			<div class="row row_tab" style="<?php if( count($term_ids) == '1' ){ ?>width:100% !important;<?php } ?>">
			<?php
			
				foreach($term_ids as $key => $term_id)
				{
					$term=get_term_by('slug',$term_id,'category');
					$name=$term->name;
					if($name=='Sponsored'){
						$name='Public Articles';
					}
					?>
						<div class="col course_category_info_<?php echo $key; ?> <?php if($key == 0 ){ echo 'tab_bottom';} ?>">
							<a class="tablinks" onclick="opentabinfo(event, 'course_category_<?php echo $key; ?>','course_category_info_<?php echo $key; ?>')" style="cursor: pointer;"><?php echo strtoupper($name);?></a>
						</div>	
					<?php
				}
			?>
			</div>
			<?php 
				foreach($term_ids as $key => $term_id){
			?>
					<div class="tab_course_content pub_lib_forum course_category_<?php echo $key; ?> tabcontent home_course_main" style="<?php if($key== 0 ){ ?>display:block;<?php } ?>" id="course_category_<?php echo $key; ?>">
						<?php
							$term=get_term_by('slug',$term_id,'category');
							$term_id=$term->term_id;
							$name=$term->name;
							$get_course_id = $wpdb->get_results("select * from ".$wpdb->prefix."term_relationships where term_taxonomy_id='".$term_id."'");
							$posts=get_posts(
								array(
									'post_type' => 'lx_course',
									'post_status' => $course_status,
									'posts_per_page' => -1,
									'category'=>$term_id
								)
							);
							if(isset($page_style['content_tile']) && function_exists('consolidaide_course_view')){
								foreach($posts as $post){
									$cost = get_post_meta( $post->ID,'lx_course_cost',true );
									if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
										consolidaide_course_view($post);
									} else if(in_array("paid", explode(",",$course_access))){
										if($cost != 0 || $cost != ''){
											consolidaide_course_view($post);
										}
									} else if(in_array("free", explode(",",$course_access))){
										if($cost == 0 || $cost == ''){
											consolidaide_course_view($post);
										}
									}
								}
							}else{
							?>
							<div class="row">
							<?php
								$total_course = count($posts);
								$count_course = 0;
								if( $total_course > 0 ){
									foreach($posts as $post){
										$cost = get_post_meta( $post->ID,'lx_course_cost',true );
										if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
											$count_course++;
										} else if(in_array("paid", explode(",",$course_access))){
											if($cost != 0 || $cost != ''){
												$count_course++;
											}
										} else if(in_array("free", explode(",",$course_access))){
											if($cost == 0 || $cost == ''){
												$count_course++;
											}
										}
									}
								}
								if( $count_course > 0 ){
									foreach($posts as $post){
										$cost = get_post_meta( $post->ID,'lx_course_cost',true );
										if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
											get_course($post->ID);
										} else if(in_array("paid", explode(",",$course_access))){
											if($cost != 0 || $cost != ''){
												get_course($post->ID);
											}
										} else if(in_array("free", explode(",",$course_access))){
											if($cost == 0 || $cost == ''){
												get_course($post->ID);
											}
										}
									}
								} else{
									?><div class="col-md-12" style="text-align: center;">This category doesn't have any content yet.</div><?php
								}
							?>
							</div>
						<?php
							}
						?>
					</div>
			<?php				
				}
			?>
		</div>
	<?php	
	} else if( $view_selection == 'List' ){
		
		$termsidsarr = array();
		foreach( $term_ids as $td ){
			$wterm =  get_term_by('id',$td,'category');
			if(is_super_admin()){
				$termsidsarr[] = $td;
			}else{
				if( $wterm->slug != 'test' ){
					$termsidsarr[] = $td;
				}
			}
			
		}
		$term_ids = $termsidsarr;
		
		foreach($term_ids as $key => $term_id) {
			if(convert_to_number($term_id)){
				$term=get_term($term_id,'category');
			}else{
				$term=get_term_by('slug',$term_id,'category');
			}
			$term_id=$term->term_id;
			$name=$term->name;
			if($name=='Sponsored'){
				$name='Public Articles';
			}
			$posts=get_posts(
				array(
					'post_type' => 'lx_course',
					'post_status' => $course_status,
					'posts_per_page' => -1,
					'category'=>$term_id
				)
			);
			$total_course=count($posts);
			$count_course = 0;
			if( $total_course > 0 ){
				foreach($posts as $post){
					$cost = get_post_meta( $post->ID,'lx_course_cost',true );
					if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
						$count_course++;
					} else if(in_array("paid", explode(",",$course_access))){
						if($cost != 0 || $cost != ''){
							$count_course++;
						}
					} else if(in_array("free", explode(",",$course_access))){
						if($cost == 0 || $cost == ''){
							$count_course++;
						}
					}
				}
			}
			if( $count_course > 0 ){
				?>
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_innr1">
						<span><<?php echo $page_devider['style'];?> class="head_<?php echo $page_devider['style'];?>"><?php echo $name;?></<?php echo $page_devider['style'];?>></span>
					</div>
				</div>
				<div class="vw_bg_lwhite home_course_main front_page_info">
					<div class="load_here">
						<?php if(isset($page_style['content_tile']) && function_exists('consolidaide_course_view')){
							foreach($posts as $post){
								$cost = get_post_meta( $post->ID,'lx_course_cost',true );
								if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
									consolidaide_course_view($post);
								} else if(in_array("paid", explode(",",$course_access))){
									if($cost != 0 || $cost != ''){
										consolidaide_course_view($post);
									}
								} else if(in_array("free", explode(",",$course_access))){
									if($cost == 0 || $cost == ''){
										consolidaide_course_view($post);
									}
								}
							}
						}else{
						?>
							<div class="row front_page_info">
							<?php 
								foreach($posts as $post){
									$cost = get_post_meta( $post->ID,'lx_course_cost',true );
									if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
										get_course($post->ID);
									} else if(in_array("paid", explode(",",$course_access))){
										if($cost != 0 || $cost != ''){
											get_course($post->ID);
										}
									} else if(in_array("free", explode(",",$course_access))){
										if($cost == 0 || $cost == ''){
											get_course($post->ID);
										}
									}
								}
							?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
			}
		}
	}
	/* if(is_front_page()){ */ ?>
		</div>
	<?php
	/* } */
}

function convert_to_number($number) {
    return is_numeric($number) ? ($number + 0) : FALSE;
}

function get_course_content($attributes){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$id = $attributes['lx_category_selection'];
	$view_selection = $attributes['lx_view_selection'];
	$course_status = $attributes['lx_course_status'];
	$course_access = $attributes['lx_course_access'];
	$lx_section_title = $attributes['lx_section_title'];
	$temp_course=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp-course' and post_type='lx_course'");
	$temp_course_id = array();
	foreach($temp_course as $info){
		$temp_course_id[] = $info->ID;
	}
	$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
	$course_taxonomy_info = get_terms( array(
		'taxonomy' => 'category',
		'hide_empty' => false,
		 'parent' => $parent_cat_id
	) );
	$term_id = array();
	foreach($course_taxonomy_info as $info){
		$term_id[] = $info->term_id;
	}
	$posts=get_posts(
		array(
			'post_type' => 'lx_course',
			'post_status' => $course_status,
			'post__not_in'=> $temp_course_id,
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'community_id',
					'compare' => 'NOT EXISTS'
				),
			),
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $term_id,
					'operator' => 'NOT IN',
				),
			), 
		)
	);
	 /* echo "<pre>";print_r($contcat); */
	$total_course=count($posts);
	$count_course = 0;
	if( $total_course > 0 ){
		foreach($posts as $post){
			$cost = get_post_meta( $post->ID,'lx_course_cost',true );
			if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
				$count_course++;
			} else if(in_array("paid", explode(",",$course_access))){
				if($cost != 0 || $cost != ''){
					$count_course++;
				}
			} else if(in_array("free", explode(",",$course_access))){
				if($cost == 0 || $cost == ''){
					$count_course++;
				}
			}
		}
	}
	?>
	<?php
	if( $count_course > 0 ){
		/* if(is_front_page()){ ?>
			<div class="lx_home_main">
		<?php
		} */ ?>
		<div class="<?php echo $attributes['className']; ?>">
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1 standarized_tab_innr_course">
				<span>
					<<?php echo $page_devider['style'];?>>
					<?php echo $lx_section_title;?>
					</<?php echo $page_devider['style'];?>>
				</span>
			</div>
		</div>
		<div class="vw_bg_lwhite home_course_main front_page_info">
			<div class="load_here">
				<?php if(isset($page_style['content_tile']) && function_exists('consolidaide_course_view')){
					foreach($posts as $post){
						$cost = get_post_meta( $post->ID,'lx_course_cost',true );
						if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
							consolidaide_course_view($post);
						} else if(in_array("paid", explode(",",$course_access))){
							if($cost != 0 || $cost != ''){
								consolidaide_course_view($post);
							}
						} else if(in_array("free", explode(",",$course_access))){
							if($cost == 0 || $cost == ''){
								consolidaide_course_view($post);
							}
						}
					}
				}else{
				?>
					<div class="row front_page_info">
					<?php 
						foreach($posts as $post){
							$cost = get_post_meta( $post->ID,'lx_course_cost',true );
							if (in_array("paid", explode(",",$course_access)) && in_array("free", explode(",",$course_access))) {
								get_course($post->ID);
							} else if(in_array("paid", explode(",",$course_access))){
								if($cost != 0 || $cost != ''){
									get_course($post->ID);
								}
							} else if(in_array("free", explode(",",$course_access))){
								if($cost == 0 || $cost == ''){
									get_course($post->ID);
								}
							}
						}
					?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php
	/* if(is_front_page()){ */ ?>
		</div>
	<?php
	/* } */
	
	}
}
/**** lx_carousel_block get articulate web category content ****/
function get_alt_web_category_content($id,$view_selection,$open_in,$resource_type){
	$resource_info = explode(',',$resource_type);
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style,$lx_plugin_paths;
	$term_ids=explode(',',$id);
	if(count($term_ids) == 1 ){ ?>
	<style>
		.row_tab {
			width:100% !important;
		}
	</style>
	<?php }
	?>
	<style>
		.row_tab{
			width: 70% !important;
			margin: 0 auto !important;
			text-align: center;
		}
		.alt_web_tab_bottom {
			cursor: pointer;
			border-bottom: 2px solid <?php echo $color_palette['hyperlinks']; ?> !important;
		}
		.alt_web_tabcontent {
			display:none;
		}
		.articulate_content .row{
			width: 100%; 
		}
	</style>
	<?php
	if(is_front_page()){ ?>
		<div class='lx_home_main'>
	<?php
	}
	if($view_selection == 'Tab'){
		foreach($resource_info as $key => $resource_type){
	?>
		<div class="alt_web_tab_row">
			<div class="row row_tab front_page_info">
				<?php	
				foreach($term_ids as $key => $term_id)
				{
					$term=get_term($term_id,'category');
					$name=$term->name;
					if($name=='Sponsored'){
						$name='Public Articles';
					}
					?>
					<div class="col alt_web_category_info_<?php echo $key; ?> <?php if($key == 0 ){ echo 'alt_web_tab_bottom';} ?>">
						<a class="alt_web_tablinks" onclick="opentabinfoAltWeb(event, 'alt_web_category_<?php echo $key; ?>','alt_web_category_info_<?php echo $key; ?>')" style="cursor: pointer;"><?php echo strtoupper($name);?></a>
					</div>	
					<?php
				}
				
			?>
			</div>
			<?php			
				foreach($term_ids as $key => $term_id){
					?>
					<div class="articulate_content alt_web_category_<?php echo $key; ?> alt_web_tabcontent home_course_main row" style="padding:15px;<?php if($key== 0 ){ ?>display:flex;<?php } ?>" id="alt_web_category_<?php echo $key; ?>">
					<?php 
						
						$all_posts=get_posts(
							array(
								'post_type' => 'lx_articulate',
								'post_status' => 'publish',
								'posts_per_page' => -1,
								'category'=>$term_id
							)
						);
						$total_content=count($all_posts);
						$count=0;
						foreach ($all_posts as $post){
							$content=get_post_meta($post->ID,'xapi_content',true);
							$content_info=get_post_meta($post->ID,'articulate_web_category',true);
							if(isset($content['content_tool'])){
								$content_type = $content['content_tool'];
							} else if(isset($content_info)){
								$content_type = $content_info;
							}
							if( ($content_type == 'articulate_storyline' || $content_type == 'articulate_rise') && $resource_type == 'zip_package' ){
								$content_type = 'zip_package';
							}
							if( $resource_type == "resource_url" && $content_type == 'articulate_web' ){
								$count++;
								$resource_type = 'resource_url';
							}else if( $content_type == "zip_package" && $resource_type == 'zip_package')  {
								$count++;
								$resource_type = 'zip_package';
							} 				
						}
						if($count>0){
							$posts=get_posts(
								array(
									'post_type' => 'lx_articulate',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'category'=>$term_id
								)
							);
							?>
							<div class="row front_page_info show_more_content_<?php echo $term_id;?>">
								<?php
								foreach ($posts as $post){
									$content=get_post_meta($post->ID,'xapi_content',true);
									$content_info=get_post_meta($post->ID,'articulate_web_category',true);
									if(isset($content['content_tool'])){
										$content_type = $content['content_tool'];
									} else if(isset($content_info)){
										$content_type = $content_info;
									}
									if( ($content_type == 'articulate_storyline' || $content_type == 'articulate_rise') && $resource_type == 'zip_package' ){
										$content_type = 'zip_package';
									} 
									$view='Tab';
									
									if( $resource_type == "resource_url" && $content_type == 'articulate_web' ){
										include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/articulate_tile.php');
										$resource_type = 'resource_url';
									}else if( $content_type == "zip_package" && $resource_type == 'zip_package')  {
										include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/articulate_tile.php');
										$resource_type = 'zip_package';
									} 		
								}
								?>
							</div>
							<?php
						}else{
							?><div class="col-md-12" style="text-align: center;">This Category doesn't have any content yet.</div><?php
						}
					?>
					</div>
			<?php } ?>
		</div>
	<?php
		}
	}elseif($view_selection == 'List'){
		foreach($resource_info as $key => $resource_type){
			
		foreach($term_ids as $key => $term_id)
		{
			$term=get_term($term_id,'category');
			$name=$term->name;
			if($name=='Sponsored'){
				$name='Public Articles';
			}
			$all_posts=get_posts(
				array(
					'post_type' => 'lx_articulate',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'category'=>$term_id,
				)
			);
			$total_content = count($all_posts);
			$count=0;
			foreach ($all_posts as $post){
				$content=get_post_meta($post->ID,'xapi_content',true);
				$content_info=get_post_meta($post->ID,'articulate_web_category',true);
				if(isset($content['content_tool'])){
					$content_type = $content['content_tool'];
				} else if(isset($content_info)){
					$content_type = $content_info;
				}
				if( ($content_type == 'articulate_storyline' || $content_type == 'articulate_rise') && $resource_type == 'zip_package' ){
					$content_type = 'zip_package';
				}
				if( $resource_type == "resource_url" && $content_type == 'articulate_web' ){
					$count++;
					$resource_type = 'resource_url';
				}else if( $content_type == "zip_package" && $resource_type == 'zip_package')  {
					$count++;
					$resource_type = 'zip_package';
				} 				
			}
			
			if($count > 0){
				?>
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_innr1">
						<span><<?php echo $page_devider['style'];?> class="head_<?php echo $page_devider['style'];?>"><?php echo $name;?></<?php echo $page_devider['style'];?>></span>
					</div>
				</div>
				<?php
				$posts=get_posts(
					array(
						'post_type' => 'lx_articulate',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'category'=>$term_id
					)
				);
				?>
				<div class="row front_page_info show_more_content_<?php echo $term_id;?>">
					<?php
					foreach ($posts as $post){
					
						$content=get_post_meta($post->ID,'xapi_content',true);
						$content_info=get_post_meta($post->ID,'articulate_web_category',true);
						if(isset($content['content_tool'])){
							$content_type = $content['content_tool'];
						} else if(isset($content_info)){
							$content_type = $content_info;
						}
						if( ($content_type == 'articulate_storyline' || $content_type == 'articulate_rise') && $resource_type == 'zip_package' ){
							$content_type = 'zip_package';
						} 
						$view='Tab';
						if( $resource_type == "resource_url" && $content_type == 'articulate_web' ){
							include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/articulate_tile.php');
							$resource_type = 'resource_url';
						}else if( $content_type == "zip_package" && $resource_type == 'zip_package')  {
							include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/articulate_tile.php');
							$resource_type = 'zip_package';
						} 						
					
					}
					?>
				</div>
				<?php
			}
		}
	}
	}
	if(is_front_page()){ ?>
		</div>
	<?php
	}
}
function get_course_content_block_data($attributes){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$course_id=$attributes['lx_course_selection'];
	$need_login=$attributes['lx_need_login'];
	$open_in=$attributes['lx_content_open_in'];
	if( !is_user_logged_in() && $need_login=='yes' ){
	}else{
		$args=array(
			'post_type' => 'lx_lessons', 
			'posts_per_page' => -1,	
			'post_status'=>'publish',
			'meta_query' => array(
			   array(
				   'key' => 'course_id',
				   'value' => $course_id,
				   'compare' => '='
			   )
			),
			'orderby'=>'menu_order',
			'order'=>'ASC'
		);
		$course_content=get_posts($args);
		if(!empty($course_content)){
			$course=get_post($course_id);
			/* if(is_front_page()){ ?>
				<div class="lx_home_main">
			<?php
			} */
			?>
			<div class="<?php echo $attributes['className']; ?>">
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_innr1 standarized_tab_innr_course">
						<span class="">
							<<?php echo $page_devider['style'];?>>
							<?php echo $course->post_title; ?>
							</<?php echo $page_devider['style'];?>>
						</span>
					</div>
				</div>
				<div class="row front_page_info">
					<?php 
						foreach ($course_content as $content) {
							global $lx_plugin_paths;
							if(isset($open_in) && $open_in=='lightbox'){
								include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/content_in_lightbox.php');
							} else {
								include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/content_in_page.php');
							}
						} 
					?>
				</div>
			<?php
			/* if(is_front_page()){ */ ?>
				</div>
			<?php
			/* } */
		} else{
			echo "<div class='selection_msg' style='display:none'>Course Content not available.</div>";
		}
	}
}

function get_fliprecordings($fliprecording_info){
	global $tiles_style,$lx_plugin_paths;
	$fliplist_id=$fliprecording_info['lx_fliprecording_selection'];
	$fliplist_title=get_post($fliplist_id)->post_title;
	$args=array(
		'post_type'=>'flip_recording',
		'posts_per_page'=>-1,
		'post_status'=>'publish',
		'meta_query'=>array(
			array(
				'key'=>'total_fliplist',
				'value'=>$fliplist_id,
				'compare'=>'LIKE'
			)
		)	
	);
	$all_recordings=get_posts($args);
	if(!empty($all_recordings)){
		?>
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1">
				<span><h4 class="head_h4"><?php echo $fliplist_title; ?></h4></span>
			</div>
		</div>
		<div class="row front_page_info">
			<?php foreach( $all_recordings as $flip_recording ) {
				$post_id=$flip_recording->ID;
				if(!empty($tiles_style['fl1p_topic_tile'])){
					include $tiles_style['fl1p_topic_tile'];
				}else{
					include $lx_plugin_paths['lx_lms_lite'].'template/tiles/fliplistrecording/style_1_ui.php';
				}
			} ?>
		</div>
	<?php
	}else{
		?>
		<div class="row hide_in_front">
			<div class="col-md-12">Fl1p Recordings are not created in this Fl1plist</div>
		</div>
		<?php
	}
}

function get_fl1plist_content_block_data($attributes){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$course_id=$attributes['lx_course_selection'];
	$need_login=$attributes['lx_need_login'];
	$open_in=$attributes['lx_content_open_in'];
	if( !is_user_logged_in() && $need_login=='yes' ){
	}else{
		$args=array(
			'post_type' => 'lx_lessons', 
			'posts_per_page' => -1,	
			'post_status'=>'publish',
			'meta_query' => array(
			   array(
				   'key' => 'course_id',
				   'value' => $course_id,
				   'compare' => '='
			   )
			),
			'orderby'=>'menu_order',
			'order'=>'ASC'
		);
		$course_content=get_posts($args);
		if(!empty($course_content)){
			$course=get_post($course_id);
			/* if(is_front_page()){ ?>
				<div class="lx_home_main">
			<?php
			} */
			?>
			<div class="<?php echo $attributes['className']; ?>">
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_innr1 standarized_tab_innr_course">
						<span class="">
							<<?php echo $page_devider['style'];?>>
							<?php echo $course->post_title; ?>
							</<?php echo $page_devider['style'];?>>
						</span>
					</div>
				</div>
				<div class="row front_page_info">
					<?php 
						foreach ($course_content as $content) {
							global $lx_plugin_paths;
							if(isset($open_in) && $open_in=='lightbox'){
								include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/content_in_lightbox.php');
							} else {
								include($lx_plugin_paths['lx_lms_lite'].'/template/tiles/content_in_page.php');
							}
						} 
					?>
				</div>
			<?php
			/* if(is_front_page()){ */ ?>
				</div>
			<?php
			/* } */
		} else{
			echo "<div class='selection_msg' style='display:none'>Course Content not available.</div>";
		}
	}
}

function get_fl1plist_content($attributes){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$id = $attributes['lx_category_selection'];
	$view_selection = $attributes['lx_view_selection'];
	$fl1plist_status = $attributes['lx_fl1plist_status'];
	$fl1plist_access = $attributes['lx_fl1plist_access'];
	$lx_section_title = $attributes['lx_section_title'];
	$temp_fl1plist=$wpdb->get_results("select * from ".$wpdb->prefix."posts where post_title='temp-fl1plist' and post_type='lx_fl1plist'");
	$temp_fl1plist_id = array();
	foreach($temp_fl1plist as $info){
		$temp_fl1plist_id[] = $info->ID;
	}
	$parent_cat_id = get_term_by('slug', 'content-category', 'category')->term_id;
	$fl1plist_taxonomy_info = get_terms( array(
		'taxonomy' => 'category',
		'hide_empty' => false,
		 'parent' => $parent_cat_id
	) );
	$term_id = array();
	foreach($fl1plist_taxonomy_info as $info){
		$term_id[] = $info->term_id;
	}
	$posts=get_posts(
		array(
			'post_type' => 'lx_fl1plist',
			'post_status' => $fl1plist_status,
			'post__not_in'=> $temp_fl1plist_id,
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'community_id',
					'compare' => 'NOT EXISTS'
				),
			),
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $term_id,
					'operator' => 'NOT IN',
				),
			), 
		)
	);
	 /* echo "<pre>";print_r($contcat); */
	$total_fl1plist=count($posts);
	$count_fl1plist = 0;
	if( $total_fl1plist > 0 ){
		foreach($posts as $post){
			$cost = get_post_meta( $post->ID,'lx_fl1plist_cost',true );
			if (in_array("paid", explode(",",$fl1plist_access)) && in_array("free", explode(",",$fl1plist_access))) {
				$count_fl1plist++;
			} else if(in_array("paid", explode(",",$fl1plist_access))){
				if($cost != 0 || $cost != ''){
					$count_fl1plist++;
				}
			} else if(in_array("free", explode(",",$fl1plist_access))){
				if($cost == 0 || $cost == ''){
					$count_fl1plist++;
				}
			}
		}
	}
	?>
	<?php
	if( $count_fl1plist > 0 ){
		/* if(is_front_page()){ ?>
			<div class="lx_home_main">
		<?php
		} */ ?>
		<div class="<?php echo $attributes['className']; ?>">
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1 standarized_tab_innr_fl1plist">
				<span>
					<<?php echo $page_devider['style'];?>>
					<?php echo $lx_section_title;?>
					</<?php echo $page_devider['style'];?>>
				</span>
			</div>
		</div>
		<div class="vw_bg_lwhite home_fl1plist_main front_page_info">
			<div class="load_here">
				<?php if(isset($page_style['content_tile']) && function_exists('consolidaide_fl1plist_view')){
					foreach($posts as $post){
						$cost = get_post_meta( $post->ID,'lx_fl1plist_cost',true );
						if (in_array("paid", explode(",",$fl1plist_access)) && in_array("free", explode(",",$fl1plist_access))) {
							consolidaide_fl1plist_view($post);
						} else if(in_array("paid", explode(",",$fl1plist_access))){
							if($cost != 0 || $cost != ''){
								consolidaide_fl1plist_view($post);
							}
						} else if(in_array("free", explode(",",$fl1plist_access))){
							if($cost == 0 || $cost == ''){
								consolidaide_fl1plist_view($post);
							}
						}
					}
				}else{
				?>
					<div class="row front_page_info">
					<?php 
						foreach($posts as $post){
							$cost = get_post_meta( $post->ID,'lx_fl1plist_cost',true );
							if (in_array("paid", explode(",",$fl1plist_access)) && in_array("free", explode(",",$fl1plist_access))) {
								get_fl1plist($post->ID);
							} else if(in_array("paid", explode(",",$fl1plist_access))){
								if($cost != 0 || $cost != ''){
									get_fl1plist($post->ID);
								}
							} else if(in_array("free", explode(",",$fl1plist_access))){
								if($cost == 0 || $cost == ''){
									get_fl1plist($post->ID);
								}
							}
						}
					?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php
	/* if(is_front_page()){ */ ?>
		</div>
	<?php
	/* } */
	
	}
}



function get_category_content_fliplist($attributes,$view_selection){
	global $wpdb,$color_palette,$breakpoint,$page_devider,$page_style;
	$id = $attributes['lx_category_selection'];
	$fl1plist_status = $attributes['lx_fl1plist_status'];
	$term_ids=explode(',',$id);
	if( count($term_ids) == 1 ){ ?>
	<style>
		.row_tab {
			width:100% !important;
		}
	</style>
	<?php }
	?>
	<style>
		.row_tab{
			width: 70% !important;
			margin: 0 auto !important;
			text-align: center;
		}
		.tab_bottom {
			cursor: pointer;
			border-bottom: 2px solid <?php echo $color_palette['hyperlinks']; ?> !important;
		}
		.tabcontent {
			display:none;
		}
	</style>
	<?php
	/* if(is_front_page()){ ?>
		<div class='lx_home_main'>
	<?php
	} */
	?>
	<div class="<?php echo $attributes['className']; ?>">
	<?php
	if( $view_selection == 'Tab' ){
		$termsidsarr = array();
		foreach( $term_ids as $td ){
			$wterm =  get_term_by('id',$td,'category');
			if(is_super_admin()){
				$termsidsarr[] = $td;
			}else{
				if( $wterm->slug != 'test' ){
					$termsidsarr[] = $td;
				}
			}
			
		}
		$term_ids = $termsidsarr;
	?>
		<div class="fl1plist_tab_row mt-3">
			<div class="row row_tab" style="<?php if( count($term_ids) == '1' ){ ?>width:100% !important;<?php } ?>">
			<?php
			
				foreach($term_ids as $key => $term_id)
				{
					$term=get_term_by('slug',$term_id,'category');
					$name=$term->name;
					if($name=='Sponsored'){
						$name='Public Articles';
					}
					?>
						<div class="col fl1plist_category_info_<?php echo $key; ?> <?php if($key == 0 ){ echo 'tab_bottom';} ?>">
							<a class="tablinks" onclick="opentabinfo_fl1plist(event, 'fl1plist_category_<?php echo $key; ?>','fl1plist_category_info_<?php echo $key; ?>')" style="cursor: pointer;"><?php echo strtoupper($name);?></a>
						</div>	
							
					<?php
				}
			?>
			</div>
			<?php 
				foreach($term_ids as $key => $term_id){
			?>
					<div class="tab_fl1plist_content pub_lib_forum fl1plist_category_<?php echo $key; ?> tabcontent home_fl1plist_main" style="<?php if($key== 0 ){ ?>display:block;<?php } ?>" id="fl1plist_category_<?php echo $key; ?>">
						<?php
							$term=get_term_by('slug',$term_id,'category');
							$name=$term->name;
							$term_id=$term->term_id;
							$get_fl1plist_id = $wpdb->get_results("select * from ".$wpdb->prefix."term_relationships where term_taxonomy_id='".$term_id."'");
							$posts=get_posts(
								array(
									'post_type' => 'flip_list',
									'post_status' => $fl1plist_status,
									'posts_per_page' => -1,
									'category'=>$term_id
								)
							);
							if(isset($page_style['content_tile']) && function_exists('consolidaide_fl1plist_view')){
								foreach($posts as $post){
									if($fl1plist_status == 'publish'){
										consolidaide_fl1plist_view($post);
									}
								}
							}else{
							?>
							<div class="row">
							<?php
								$total_fl1plist = count($posts);
								$count_fl1plist = 0;
								if( $total_fl1plist > 0 ){
									foreach($posts as $post){
										if($fl1plist_status == 'publish'){
											$count_fl1plist++;
										}else if($fl1plist_status == 'draft'){
											$count_fl1plist++;
										}
									}
								}
								if( $count_fl1plist > 0 ){
									foreach($posts as $post){
										if($fl1plist_status == 'publish'){
											get_fl1plist($post->ID);
										} else {
											get_fl1plist($post->ID);
										}
									}
								} else{
									?><div class="col-md-12" style="text-align: center;">This category doesn't have any content yet.</div><?php
								}
							?>
							</div>
						<?php
							}
						?>
					</div>
			<?php				
				}
			?>
		</div>
	<?php	
	} else if( $view_selection == 'List' ){
		
		$termsidsarr = array();
		foreach( $term_ids as $td ){
			$wterm =  get_term_by('id',$td,'category');
			if(is_super_admin()){
				$termsidsarr[] = $td;
			}else{
				if( $wterm->slug != 'test' ){
					$termsidsarr[] = $td;
				}
			}
			
		}
		$term_ids = $termsidsarr;
		
		foreach($term_ids as $key => $term_id) {
			$term=get_term_by('slug',$term_id,'category');
			$name=$term->name;
			$term_id=$term->term_id;
			if($name=='Sponsored'){
				$name='Public Articles';
			}
			$posts=get_posts(
				array(
					'post_type' => 'flip_list',
					'post_status' => $fl1plist_status,
					'posts_per_page' => -1,
					'category'=>$term_id
				)
			);
			$total_fl1plist=count($posts);
			$count_fl1plist = 0;
			if( $total_fl1plist > 0 ){
				foreach($posts as $post){
					if($fl1plist_status == 'publish'){
						$count_fl1plist++;
					}else {
						$count_fl1plist++;
					}
				}
			}
			if( $count_fl1plist > 0 ){
				?>
				<div class="mt-2 standarized_tab">
					<div class="standarized_tab_innr1">
						<span><<?php echo $page_devider['style'];?> class="head_<?php echo $page_devider['style'];?>"><?php echo $name;?></<?php echo $page_devider['style'];?>></span>
					</div>
				</div>
				<div class="vw_bg_lwhite home_fl1plist_main front_page_info">
					<div class="load_here">
						<?php if(isset($page_style['content_tile']) && function_exists('consolidaide_fl1plist_view')){
							foreach($posts as $post){
								if($fl1plist_status == 'publish'){
									consolidaide_fl1plist_view($post);
								}else{
									consolidaide_fl1plist_view($post);
								}
							}
						}else{
						?>
							<div class="row front_page_info">
							<?php 
								foreach($posts as $post){
									if($fl1plist_status == 'publish'){
										get_fl1plist($post->ID);
									}else {
										get_fl1plist($post->ID);
									}
								}
							?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
			}
		}
	}
	/* if(is_front_page()){ */ ?>
		</div>
	<?php
	/* } */
}

function get_fl1plist($fliplist_id)
{
	global $color_palette,$tiles_style,$breakpoint;
	$user_id=get_current_user_id();
	$fliplist=get_post($fliplist_id);
	$post_title=$fliplist->post_title;
	$post_description = $fliplist->post_content;
	$post_type=$fliplist->post_type;
	$fliplist_length = wp_strip_all_tags($fliplist->post_content);
	$url=get_permalink($fliplist_id);
	$post_id = $fliplist_id;
	$thumbnail_image = get_post_meta($fliplist_id,'fliplist_cropped_thumb',true);
	$info = "fliplist_info";
	$sub_title=get_post_meta($fliplist_id,'fliplist_subtitle',true);
	$bg=$progress['background'];
	$bg_tile = $color_palette['black'];
	$status=$progress['status'];
	$btn_name=$progress['btn_text'];
	$author_id = $fliplist->post_author;
	if(!empty($tiles_style['fl1p_forum_tile'])){
		include ($tiles_style['fl1p_forum_tile'] );
	}else{
		global $lx_plugin_paths;
		include ($lx_plugin_paths['lx_lms_lite'].'template/tiles/tiles_style_2_ui.php');
	} 
	return;
}