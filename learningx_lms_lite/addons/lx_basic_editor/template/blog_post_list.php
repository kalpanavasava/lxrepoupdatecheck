<?php 
global $color_palette,$square_icon,$tiles_style,$breakpoint; 
?>
<div class="lx_editor_blog_page_inner <?php echo $breakpoint['class'];?>">
	<?php
		$info = "blog_post_info";
		include ($tiles_style['blog_tile'] );
	?>
</div>
<div class="modal fade" id="delete_blog_modal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
	<div class="modal-header">
	  <h3 class="modal-title">Delete Post</h3>
	  <button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body">
	  <p class="lx_lms_sub_text">Deleting this post will remove it from this page, and remove all associated images and content from the site.  Would you prefer to change it to draft, or delete entirely?</p>
	</div>
	<div class="modal-footer">
	 
	</div>
  </div>
</div>
</div>