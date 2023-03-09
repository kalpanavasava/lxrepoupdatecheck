<div class="lx_editor_blog_page">
	<!-- <h2> My Blog Posts </h2>
	<div class="row m-4">
		<div class="">
			<span>Sort by: </span><button class="btn btn-primary lxed_title_filter lxed_button">Title (A-Z)</button>
		</div>
		<div class="pl-4">
			<a target="_blank" href="<?php //echo site_url().'/create-blog-post/';?>"><button class="btn btn-primary lxed_button">Add New</button></a>
		</div>
	</div>
	<div class="lxed_main_page_listing"> -->
	<?php
	/*$pub_cat = $this->lx_get_datas->vw_fn_lx_get_publib_cat();*/
	$pub_cat=lx_get_data::vw_fn_lx_get_publib_cat();
		/* echo "<pre>";print_r($pub_cat); */
		
	foreach($pub_cat as $pub_cat_data){
		$term_id = $pub_cat_data->term_id;
		$name = $pub_cat_data->name;
		$slug = $pub_cat_data->slug;
		$get_postbyterm = lx_get_data::vw_fn_get_postby_termid($term_id,$slug);
		if(count($get_postbyterm) > 0){
		?>
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1">
				<span style="position: relative;"><?php echo $name;?></span>
			</div>
		</div>
		<?php } ?>
		<div class="row mt-2">
		<?php
		/* wp_get_post_terms */
		/* echo "<pre>";print_r($get_postbyterm);  */
		foreach( $get_postbyterm as $get_all_posts_data ){
			$post_id = $get_all_posts_data->ID;
			$post_title = $get_all_posts_data->post_title;
			$post_author = $get_all_posts_data->post_author;
			$post_description = $get_all_posts_data->post_excerpt;
			$thumbnail_image = get_post_meta( $post_id , 'lxed_thumbnail_image' )[0];
			$post_status = $get_all_posts_data->post_status;
			
			include ( plugin_dir_path(__FILE__).'blog_post_list.php' );
			
		}
		?>
		</div>
		<?php
	}?>
	</div>
	
</div>
