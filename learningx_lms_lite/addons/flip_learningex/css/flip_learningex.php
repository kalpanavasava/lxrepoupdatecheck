<?php global $color_palette;?>
<style>
body {
    width: 100%;
    height: 95vh;
    position: relative;
    max-width: 100%;
    max-height: 100vh;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
}
 #wpadminbar {
    position: fixed !important;
}

.ld-focus-sidebar{
    width: 25% !important
}
.ld-course-navigation-heading{
    width: 100% !important;
}
.ld-content-action{
    display: none !important;
}
.ld-focus-header .ld-content-action{
    display: block !important;
}
.ld-focus-content{
    padding: unset !important;
}
.learndash-wrapper .ld-breadcrumbs .ld-breadcrumbs-segments .content_title {
     color:<?php echo $color_palette['charcoal'];?> !important;
     pointer-events: none !important;
}
.learndash-wrapper .ld-breadcrumbs .ld-breadcrumbs-segments .top_course_title {
     font-size:1.2em;
}
.learndash-wrapper .ld-breadcrumbs .progress_status {
     background-color:<?php echo $color_palette['custom1'];?> !important;
}
.ld-focus-content h1{
    display: none !important;
}
.ld-breadcrumbs{
    position: fixed !important;
    width: 75% !important;
    left: 25% !important;
    top: 83px !important;
}
.ld-focus-sidebar-collapsed .ld-breadcrumbs{
    position: fixed !important;
    width: 98% !important;
    left: 50px!important;
    top: 83px !important;
}
.flip_content .play_load_here{
    width: 75% !important;
    left:25% !important;
}
.ld-focus-sidebar-collapsed .flip_content .play_load_here{
    width: 95% !important;
    left:5% !important;
}
.flip_content .reply_tab .btn{
    color: <?php echo $color_palette['white'];?> !important
}
.flip_content .audio_response_tab
{
    flex: 0.55 !important;
}
.ld-focus-sidebar-collapsed .flip_content .information_tab,.ld-focus-sidebar-collapsed .flip_content .attachment_tab,.ld-focus-sidebar-collapsed .flip_content .slide_image_tab,.ld-focus-sidebar-collapsed .flip_content .slide_tab{
    top: 170px !important; 
    left: 50px!important;
    width: 100% !important;
    
} 
.ld-focus-sidebar-collapsed .flip_content .audio_response_up
{
    top: 125px !important;
    width: 100% !important;
    left: 50px!important;
}
.ld-focus-sidebar-collapsed .flip_content .play_load_here .row:first-child{
    margin-left: unset !important;
}
.ld-focus-sidebar-collapsed .flip_content .response_tab {
    left: 50px !important;
}
.flip_content .response_tab {
    height: 100% !important;
    bottom: -20px !important;
    position: fixed !important;
    left: 25% !important;
    top: 121px !important;
}
.flip_content .close_btn {
    top: 121px !important;
}
.ld-focus-sidebar-collapsed  .flip_content .close_btn {
    right: 43% !important;
    left: 53% !important;
}
.ld-focus-sidebar-collapsed .flip_content .close_tab_rep{
    left: 5% !important;
    top: 55% !important;
}
.ld-focus-sidebar-collapsed .flip_content .play_load_here .replyModal,.ld-focus-sidebar-collapsed .flip_content .play_load_here .replyEditModal {
    width: 96.6% !important;
    left: 3.6% !important;
}
.ld-focus-sidebar-collapsed .flip_content .min_audio_player .ap-wrapper {
    left: -2% !important;
}
.flip_content .load_reply_here .uploading_wav_file,.flip_content .load_reply_edit_here .uploading_wav_file{
   color:<?php echo $color_palette['white'];?> !important; 
}
.flip_content .replyModal-content,.flip_content .replyEditModal-content{
    width: 85% !important;
}
.flip_content .replyModal,.flip_content .replyEditModal
{
    padding-top: 8% !important;
}
.slick-dots{
    display: none !important;
}
.ld-progress .ld-progress-percentage{
    margin-right: 10px !important;
}
@media (max-width: 768px){
    .ld-focus-sidebar-collapsed .flip_content .close_btn {
        right: 0% !important;
        left: 95% !important;
        top: 140px !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .close_tab_rep {
        left: 47.5% !important;
        top: 55% !important;
    }
    .learndash-wrapper .ld-focus .ld-focus-sidebar .ld-course-navigation-heading h3{display: none !important;}
    .ld-focus-sidebar-collapsed .flip_content .response_tab {
        left: 0%!important;
        top: 140px !important;
    }
    .ld-focus-header{
         z-index: 1 !important;
    }
    .flip_content .audio_response_up{
        z-index: 2 !important;
        padding-left:unset !important;
    }
    .learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content, .learndash-wrapper .ld-focus.ld-focus-sidebar-collapsed .ld-focus-main .ld-focus-content {margin-top:-50px !important;}  
    .learndash-wrapper .ld-content-actions .ld-content-action {
    padding: unset !important;
    }
    .flip_content .forum_main_div{
    overflow-y: scroll !important;
    overflow-x:hidden !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .play_load_here{
        width: 100% !important;
        left: 0% !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .audio_response_up
    {
        top: 140px !important;
        width: 100% !important;
        left: 0% !important;
        height: 45px !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .information_tab,.ld-focus-sidebar-collapsed .flip_content .attachment_tab,.ld-focus-sidebar-collapsed .flip_content .slide_image_tab,.ld-focus-sidebar-collapsed .flip_content .slide_tab{
        top: 180px !important;
        left: 0% !important;
        width: 100% !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .play_load_here .replyModal,.ld-focus-sidebar-collapsed .flip_content .play_load_here .replyEditModal {
        width: 100% !important;
        left: unset !important;
        top:25px !important;
        z-index: 100 !important;
    }
}
@media (max-width: 640px){
  .learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content, .learndash-wrapper .ld-focus.ld-focus-sidebar-collapsed .ld-focus-main .ld-focus-content {margin:unset !important;} 
   .learndash-wrapper .sfwd-mark-complete {
    width: unset !important;  
  }
  .learndash-wrapper .ld-focus .ld-focus-header .ld-content-actions {
    flex-direction: column !important;
  }
}
@media (min-width: 679px)
{
    .learndash_post_sfwd-lessons{
        position: relative;
        top: 50px;
    }
    .flip_content .play_load_here{
        width: 75% !important;
        left: 25% !important;
    }
    .flip_content .audio_response_up
    {
        top: 125px !important;
        width: 75% !important;
        left: 25% !important;
        height: 45px !important;
    }
    .flip_content .information_tab,.flip_content .attachment_tab,.flip_content .slide_image_tab,.flip_content .slide_tab{
        top: 170px !important;
        left: 25% !important;
        width: 75% !important;
    } 
   .flip_content .close_btn {
        right: 25% !important;
        left: 72% !important;
        top: 121px !important;
    }
    .flip_content .play_load_here .replyModal,.flip_content .play_load_here .replyEditModal {
        width: 75% !important;
        left: unset !important;
    }
}
@media only screen and (width: 768px) {
    .ld-focus-sidebar-collapsed .flip_content .close_tab_rep {
        left: 28.5% !important;
        top: 55% !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .close_btn {
        right: 17% !important;
        left: 75% !important;
        top: 140px !important;
    }
    .ld-focus-sidebar-collapsed .flip_content .response_tab {
        left: 0%!important;
        width: 75% !important;
        top: 140px !important;
    }
}
@media (min-width: 768px){
    .flip_content .close_tab_rep {
        left: 23.5% !important;
        top: 55% !important;
    }
}
@media (max-width: 767px){
    .ld-progress .ld-progress-percentage{
        margin-right: 0px !important;
    }
}
</style>