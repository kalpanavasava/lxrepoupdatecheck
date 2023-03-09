<?php global $color_palette;?>
<style>
body {
    width: 100%;
    height: 95vh;
    position: fixed;
    max-width: 100%;
    max-height: 100vh;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
}

.learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content h1{
    display:none !important;
}

.learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content {
    padding: 0 !important;
    margin: 0 auto !important;
    max-width: 100% !important;
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

.ld-progress .ld-progress-percentage{
    margin-right: 10px !important;
}
.content_link{
    display: flex;
}
.learndash-wrapper .ld-breadcrumbs .ld-breadcrumbs-segments {
    font-size: 1em !important;
}
.btn_brc_home{
    background-color: <?php echo $color_palette['hyperlinks'];?>;
    color:  <?php echo $color_palette['white'];?>;
    width: 80px;
    text-align: center;
    padding: 3px 15px;
    margin-right: 10px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 700;
}
.ld-lesson-status{
    margin-bottom: unset !important;
}
@media (max-width: 768px){
    .ld-progress .ld-progress-percentage{
        margin-right: 0px !important;
    }
    .ld-focus-sidebar-collapsed .ld-focus-content .ld-content-actions{
         width:100%;
    }
    .learndash-wrapper .ld-content-actions .ld-content-action .ld-course-step-back{
        padding: unset !important;
        margin:-10px;
    }
    .ld-focus-content .ld-content-actions{
        position: fixed;
        bottom: 0px;
        width:100%;
        background: #dadada;
        padding:unset;
        display: flex;
        flex-direction: row;
        height: 30px;
    }
    .ld-focus-content .ld-content-action:first-child{
        width: 100%
    }
    .ld-focus-content .ld-content-actions .ld-button{ display: none; }
    .ld-focus-sidebar-collapsed .ld-focus-content .ld-content-actions{
         width:100%;
    }
    .learndash-wrapper .ld-content-actions .ld-content-action .ld-course-step-back {
        font-size: 1em !important;
    }

}
@media (min-width: 769px){
    .learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content {
        padding-top: 50px !important;
    }
}
</style>