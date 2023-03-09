<style>
	.entry-content {
		margin-top: unset !important;
	}
</style>
<?php if(!is_user_logged_in()){?>
<div class="row tab_section" style="position: relative;margin-top: 55px;">
<?php }else{
?><div class="row tab_section"?><?php
}?>
	<div class="col-md-12">
		<nav>
			<div class="nav justify-content-center" id="nav-tab" role="tablist">
				<?php
					$pub_cat=lx_get_data::vw_fn_lx_get_publib_cat();
					$i=1;
					foreach($pub_cat as $pub_cat_data){
						$term_id = $pub_cat_data->term_id;
						$name = $pub_cat_data->name;
						$slug = $pub_cat_data->slug;
						if(!is_user_logged_in()){
							if($slug=='sponsered')
							{
						
				?>
				<a class="nav-item nav-link pl-5 pr-5 <?php if($i==1){echo "active show";}?> get_category_blog" id="get_category_blog" data-toggle="tab" href="#nav-<?php echo $slug?>" role="tab" aria-controls="nav-<?php echo $slug?>" aria-selected="true" data-term_id="<?php echo $term_id;?>"><?php echo strtoupper($name); ?></a>
				<?php 
							}
						}else{
							?><a class="nav-item nav-link pl-5 pr-5 <?php if($i==1){echo "active show";}?> get_category_blog" id="get_category_blog" data-toggle="tab" href="#nav-<?php echo $slug?>" role="tab" aria-controls="nav-<?php echo $slug?>" aria-selected="true" data-term_id="<?php echo $term_id;?>"><?php echo strtoupper($name); ?></a><?php
						}
					$i++;
				} ?>
			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
			
			<div class="tab-pane fade show active load_blog" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				
			</div>
			 
		</div>
	</div>
</div>