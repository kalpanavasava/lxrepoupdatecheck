<?php
function save_flip_content(){
ob_start();
if(is_user_logged_in() == true && (is_super_admin() || current_user_can('site_owner'))){
global $color_palette,$square_icon;
$course_id=$_POST['course_id'];
if(isset($_POST['lesson_id']))
{
    $lesson_id=$_POST['lesson_id'];
}
?>
<style>
    .form-group small {
        float: right;
    }
    .form-group .title_bottom {
        padding-bottom: 10px;
   		border-bottom: 2px solid <?php echo $color_palette['light_grey'];?>;
    }
    input[type="text"]{
    	background: <?php echo $color_palette['white'];?> !important;
    }
    #site-navigation3,.site-footer{
    	display: none;
    }
</style>
<div class="container">
        <div class="row">
            <div class="col-md-12 flip_container">
                <form id="add_fl1p_content">
                    <input type="hidden" name="course_id" value="<?php echo $course_id;?>">
                    <input type="hidden" id="lesson_id" name="lesson_id" value="<?php echo $lesson_id;?>">
                    <div class="form-group">
                        <div class="title_bottom">
                         	<div class="flip_canvas_close">&times;</div>
                            <?php 
                                if(!empty($lesson_id))
                                {
                                     ?>
                                    <div class="heading">Edit Content - Fl1p - Rich Audio Forum or Topic </div>
                                <?php
                                }else{
                                    ?>
                                    <div class="heading">Adding Content - Fl1p - Rich Audio Forum or Topic </div>
                                <?php 
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fl1p_title">Title (appears in the Course Module List)</label>
                         <?php 
                            if(!empty($lesson_id))
                            {
                                $flip_title=get_post($lesson_id)->post_title;
                            }
                        ?>
                        <input type="text" class="form-control" id="fl1p_title" name="fl1p_title" maxlength="50" aria-describedby="fl1pHelp" value="<?php echo $flip_title;?>">
                        <span class="error_flip_title" style="color: <?php echo $color_palette['red'];?>;display: none;">Title Already Exist.</span>
                        <small id="fl1pHelp" class="form-text text-muted"><span id="rchars">50</span> characters remaining</small>
                    </div> 
                    <div class="form-group">
                        <label for="fl1p_forum">Select a Forum you own in <a href="http://fl1p.com.au/" style="    text-decoration: underline;">Fl1p</a></label>
                        <select id="fl1p_forum" name="fl1p_forum" class="form-control fl1p_forum">
                            <option value="">Select</option>
                            <?php 
                                $current_user=wp_get_current_user();
                                $uemail=$current_user->user_email;
                                if (strpos($uemail, '+') !== false) {
                                    $email=str_replace('+','%2B',$uemail);
                                }
                                else{
                                    $email=$uemail;
                                }
                                $url='http://fl1p.com.au/wp-json/wp1/v1/fl1p_podcast_by_author?uemail="'.$email.'"';
                               
                                $response=wp_remote_get($url);
                                $responsebody=wp_remote_retrieve_body( $response );
                                if(is_wp_error($response)){
                                    $res=$response->get_error_message();
                                }else{
                                    $res=json_decode( $responsebody );
                                }
                                 if(!empty($lesson_id))
                                {
                                    $flip_forum_id=get_post_meta($lesson_id,'flip_forum_id',true);
                                }
                                if(!empty($res))
                                {
                                    foreach ($res as $flip_forum) {
                                        ?><option value="<?php echo $flip_forum->ID;?>" <?php if($flip_forum_id==$flip_forum->ID){echo "selected";}?>><?php echo $flip_forum->post_title;?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fl1p_topic">Select a Topic from the Forum</label>
                        <select id="fl1p_topic" name="fl1p_topic" class="form-control">
                             <option value="">Select</option>
                        </select>
                    </div>
                     
                    <div class="form-group">
                        <label><strong>NOTES:</strong></label>
                        <ul>
                            <li>
                                <span>We recommend checking on Fl1p to see if you Responses and Text Comments are
                                    enabled
                                    (if required)</span>
                            </li>
                            <li>
                                <span>A Forum-only is a good option for giving general access to a number of
                                    Topics.</span>
                            </li>
                            <li>
                                <span>A Topic selection is a more focused option,and is commonly used for a
                                    reflection</span>
                            </li>
                        </ul>
                    </div>
                    <div class="container">
                    	<center><a href="<?php echo get_permalink($course_id);?>" class="btn btn_dark_state">Cancel</a>
                    	<button class="btn btn_normal_state" id="fl1p_content_save"><i class="<?php echo $square_icon['save'];?>"></i>&nbsp;&nbsp;Save</button></center>
                    </div>
                 </form>
            </div>
        </div>

    </div>
    <script>
    	jQuery(document).on('click','.flip_canvas_close',function(){
    		window.history.back();
    	});
        jQuery(document).on('change','.fl1p_forum',function(){
            jQuery('#fl1p_topic').html('<option value="">Select</option>');
            var forum_id=jQuery(this).val();
            var post_data={'forum_id':forum_id,'action':'get_fl1p_topic'};
            jQuery.ajax({
                url  : my_ajax_object.ajax_anchor,  
                type: 'POST',
                data: post_data,
                dataType: 'html',                       
                success  : function(response) {
                  jQuery('#fl1p_topic').html(response);
                }
           });
        });
        jQuery(document).ready(function(){
            var maxLength = 50;
            jQuery('#fl1p_title').keyup(function () {
                var textlen = maxLength - $(this).val().length;
                $('#rchars').text(textlen + " " + "characters remaining");
            });
            if(jQuery('#fl1p_forum option:selected').val()!='')
            {
                jQuery('#fl1p_topic').html('<option value="">Select</option>');
                var forum_id=jQuery('#fl1p_forum option:selected').val();
                var lesson_id=jQuery('#lesson_id').val();
                var post_data={'forum_id':forum_id,'lesson_id':lesson_id,'action':'get_fl1p_topic'};
                jQuery.ajax({
                    url  : my_ajax_object.ajax_anchor,  
                    type: 'POST',
                    data: post_data,
                    dataType: 'html',                       
                    success  : function(response) {
                      jQuery('#fl1p_topic').html(response);
                    }
               });
            }
        });
    </script>
    <script type="text/javascript">
        var http_referer = {'back':"<?php echo $_SERVER['HTTP_REFERER'];?>"}  
        var current_user = {'user_id':"<?php echo get_current_user_id();?>"}  
    </script>
<?php
}else{
	echo "<div style='width:100%;color:red;text-align:center;padding:20px;'>You Don't have Access to this page.</div>";
}
$op=ob_get_clean();
return $op;
}
add_shortcode('save_fl1p_content','save_flip_content');
?>