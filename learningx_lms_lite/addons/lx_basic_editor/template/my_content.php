<div class="lx_editor_blog_page">
<?php
	global $page_devider,$lexicon;
	$get_blog_post=get_posts(
		array(
			'post_type'=>'post',
			'post_status'=>array('draft','publish'),
			'author'=> get_current_user_ID(),
			'meta_query'=>array(
				'relation'=>'AND',
				array(
					'key'=>'display_in',
					'value'=>'in_community',
					'compare'=>'='
				)
			)
		)
	);
	if(count($get_blog_post)>0)
	{
		?>
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1">
				<span style="position: relative;"><<?php echo $page_devider['style'];?>><?php echo $lexicon['lexicon_our_community']?></<?php echo $page_devider['style'];?>></span>
			</div>
		</div>
		<div class="row mt-2">
		<?php
		foreach($get_blog_post as $blog_post){
			$post_id = $blog_post->ID;
			$post_title = $blog_post->post_title;
			$post_author = $blog_post->post_author;
			$post_description = $blog_post->post_excerpt;
			$thumbnail_image = get_post_meta( $post_id , 'lxed_thumbnail_image' )[0];
			$post_status = $blog_post->post_status;
			$url=get_permalink($post_id);
			$category=get_the_terms($post_id,'category');
			/* echo "<pre>";print_r($category);echo "</pre>"; */
			include ( plugin_dir_path(__FILE__).'blog_post_list.php' );
		}
		?>
		</div>
		<?php
	}
	$lx_data=new lx_get_data();
	$pub_cat=$lx_data->vw_fn_lx_get_publib_cat();		
	foreach($pub_cat as $pub_cat_data){
		$term_id = $pub_cat_data->term_id;
		$name = $pub_cat_data->name;
		$slug = $pub_cat_data->slug;
		/* $get_postbyterm = lx_get_data::vw_fn_get_postby_termid($term_id,$slug); */
		
		$all_posts=array();
		
		$args = array(
			'post_type' => 'post',
			'author' => get_current_user_ID(),
			'category' => $term_id,
			'post_status' => array('publish', 'draft'),
		);
		$get_postbyterm = get_posts( $args );
		
		if(count($get_postbyterm) > 0){
		?>
		<div class="mt-2 standarized_tab">
			<div class="standarized_tab_innr1">
				<span style="position: relative;"><<?php echo $page_devider['style'];?>><?php echo $name;?></<?php echo $page_devider['style'];?>></span>
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
			$category=$pub_cat_data->name;
			include ( plugin_dir_path(__FILE__).'blog_post_list.php' );
			
		}
		?>
		</div>
		<?php
	}?>
	</div>
	
</div>
