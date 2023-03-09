<?php
class lx_get_data{
	
	public function __construct() {
		/* add_action('lx_getall_posts', array($this,'fn_lx_get_posts')); */
    }
	public function fn_lx_get_posts( $filter_by ){
		
		if(!empty($filter_by)){
			
			$args = array(
			  'numberposts' => -1,
			  'post_type' => 'post',
			  'orderby'  => 'title',
			  'order'     => 'ASC',
			  'post_status' => array('publish','draft'),
			);
		}else{
			$args = array(
			  'numberposts' => -1,
			  'post_type' => 'post',
			  'post_status' => array('publish','draft'),
			);
		}
		
		
		$latest_posts = get_posts( $args );
		
		return $latest_posts;
	}  
	
	public function vw_fn_lx_get_all_categories(){
		
		$lxed_all_categories = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC'
		) );
		
		return $lxed_all_categories;	
	}
	public function vw_fn_lx_get_publib_cat(){
		$all_public_lib_cat = get_terms( 'category',array( 'name' => 'Public library' , 'hide_empty' => false ))[0]->term_id;
				
		$all_pub_lib_term = get_terms( array(
		  'taxonomy' => 'category',
		  'include' => get_term_children($all_public_lib_cat,'category'),
		  'exclude'=>array(1),
		  'hide_empty'  => false, 
		  'orderby'  => 'term_id',
		  'order' => 'desc'
		) );
		
		return $all_pub_lib_term;
	}
	public function vw_fn_get_postby_termid($term_ids=null,$slug=null){
		global $wpdb;
		$all_posts=array();
		$args = array(
			'post_type' => 'post',
			'category' => $term_ids,
			'post_status' => array('publish', 'draft')
		);
		$all_posts = get_posts( $args );
		return $all_posts;
	}
}