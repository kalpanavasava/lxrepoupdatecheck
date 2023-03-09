<?php

/**** for design lx login page ****/ 
function fn_lx_login_page($atts){
	ob_start();
	global $color_palette,$frontend_icon;
   $a=shortcode_atts(
    array(
      'display' => '',
  ), $atts);
?>
<style>
body * {
  transition: all 0.5s;
}
.container-fluid {
    background: radial-gradient(ellipse at top, <?php echo $color_palette['charcoal'];?>, rgba(51,51,51,0.9)),
            radial-gradient(ellipse at bottom, <?php echo $color_palette['blue'];?>,<?php echo $color_palette['blue'];?>);
}

.box {
  width: 300px;
  height: 250px;
  margin-top:0px;
  margin-bottom:65px;
  padding: 15px;
  border: 1px solid <?php echo $color_palette['border'];?>;
  box-sizing: border-box;
  display: inline-block;
  position: relative;
  overflow: hidden;
  box-shadow: 0 0 5px rgba(0,0,0,0.4);
  cursor: pointer;
  z-index:inherit;
}

.box .icon-cont {
  border: 6px solid <?php echo $color_palette['border'].'4d';?>;
  border-radius: 50%;
  width: 75px;
  height: 75px;
  margin: 20px auto;
  display: block; 
  text-align: center;
  
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  z-index: 5;
  
  box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);
}
.box .icon-cont .svg-inline--fa {
  color: <?php echo $color_palette['white'];?>;
  opacity: 0.6;
  font-size: 2.5em;
  line-height: 75px;
  padding-top: 10px;
}
.box:hover .icon-cont {
  animation: shady 4s linear infinite;
}

@keyframes shady {
  0% {box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);}
  20% {box-shadow: 0 0 0 100px rgba(255,255,255,0), 0 0 0 0px rgba(3, 108, 129, 0);}
  20.1% {box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);}
  50% {box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);}
  70% {box-shadow: 0 0 0 100px rgba(255,255,255,0), 0 0 0 0px rgba(3, 108, 129, 0);}
  70.1% {box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);}
  100% {box-shadow: 0 0 0 0px rgba(255,255,255,0.5), 0 0 0 0px rgba(3, 108, 129, 0.5);}
}

.box h3 {
  color: <?php echo $color_palette['white'];?>;
  font-family: 'Open Sans', Arial, sans-serif;
  font-weight: 300;
  font-size: 24px;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 2px;
  padding: 15px;
  position: absolute;
  top: 125px;
  width: 70%;
  left: 15%;
  z-index: inherit;
}
.box ul {
  text-align:left;
  font-family: 'Nunito Sans', Arial, sans-serif;
  color: <?php echo $color_palette['white'];?>;
  font-size: 13px;
  line-height: 1.8em;
  text-indent: 0px;
  margin: 25px;
  margin-top: 380px;
  list-style-type: disc;
}

.box ul.hidden {
  opacity: 0;
}

.box a.expand {
  width: 35px;
  height: 35px;
  background: <?php echo $color_palette['black'].'1a';?>;
  font-weight: 700;
  color: <?php echo $color_palette['white'];?>;
  display: block;
  margin: 15px auto 25px;
  text-align: center;
  line-height: 35px;
  border: 1px solid <?php echo $color_palette['border'];?>;
  border-radius:5px;
  cursor: pointer;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 10px;
  
}
.box a.expand span.minus {
  opacity: 0;
}
.box a.expand span.plus {
  opacity: 1;
  padding-left: 8px;
}
.box.selected a.expand {
  display: block;
  position: absolute;
  left: 225px;
  right: -54px;
  bottom: -41px;
  width: 80px;
  height: 50px;
  background: <?php echo $color_palette['black'].'1a';?>;
  color: <?php echo $color_palette['white'];?>;
  border: 2px solid <?php echo $color_palette['border'];?>;
  transform: rotate(-45deg);
}
.box.selected a.expand span {
  display: block;
  position: absolute;
  top: -4px;
  left: 38px;
  transform: rotate(45deg);
  font-size: 24px;
}
.box.selected a.expand span.minus {
  opacity: 1;
}
.box.selected a.expand span.plus {
  opacity: 0;
}
.box.selected .icon-cont {
  transform: scale(1.5,1.5);
  opacity: 0.3;
  position: absolute;
  top: -20px;
  left: -5px;
  right: 180px;
}
.box.selected:hover .icon-cont {
  animation: none;
}
.box.selected h3 {
  padding: 32px 15px 15px 15px;
  border-bottom: 1px solid rgba(255,255,255,0.3);
  width: 70%;
  top: 16px;
  left: 10%;
}
.box.selected ul.hidden {
  opacity: 1;
  margin-top: 95px;
}
.home_content{
	display:<?php echo $val; ?>
}
</style>
<div class="home_content lx_banner">
<script src="https://kit.fontawesome.com/08f28fd42b.js" crossorigin="anonymous"></script>
<?php 
 if($a['display']=="before_login" && is_user_logged_in())
 {
    $display="none";
 }else if($a['display']=="after_login" && !is_user_logged_in()){
    $display="none";
 }else{
  $display="block";
 }

?>
<div class="container-fluid" style="display: <?php echo $display;?>">
  <center>
    <h1 class="color_palette_white" style="font-size:1.2em; padding-top:20px; padding-bottom:5px;">"Ensure inclusive and equitable quality education and promote lifelong learning opportunities for all"</h1>
    <p class="color_palette_white" style="font-size:0.8em;">- United Nations Sustainability Goal (SDG-4)</p>
  <div class="box first color_palette_charcoal_bg">
    <span class="icon-cont"><i class="<?php echo $frontend_icon['connect']; ?>"></i></span>
    
    <h3>Connect</h3>
    
    <ul class="hidden">
      <li>Join a Community</li>
      <li>Learn from experts</li>
      <li>Share knowledge & ideas</li>
      <li>Showcase what you've learnt</li>
    </ul>
        
    <a class="expand"><span class="plus">+</span><span class="minus">-</span></a>
  </div>
  
  <div class="box second color_palette_blue_bg">
    <span class="icon-cont"><i class="<?php echo $frontend_icon['learn']; ?>"></i></span>
    
    <h3>Learn</h3>
    
    <ul class="hidden">
      <li>Read a wide range of articles</li>
      <li>Earn micro-credentials</li>
      <li>Complete courses</li>
      <li>Listen to podcast forums</li>
    </ul>
        
    <a class="expand"><span class="plus">+</span><span class="minus">-</span></a>
  </div>
  
  <div class="box third color_palette_green_bg">
    <span class="icon-cont"><i class="<?php  echo $frontend_icon['grow']; ?>"></i></span>
    
    <h3>Grow</h3>
    
    <ul class="hidden">
      <li>Find and join other Communities</li>
      <li>Find new areas of interest</li>
      <li>Learn from others in the field</li>
    </ul>
        
    <a class="expand"><span class="plus">+</span><span class="minus">-</span></a>
  </div>
  
  <div class="box fourth color_palette_purple_bg">
    <span class="icon-cont"><i class="<?php echo $frontend_icon['create'];?>"></i></span>
    
    <h3>Create</h3>
    
    <ul class="hidden">
      <li>Build your own Community</li>
      <li>Start a Podcast Forum</li>
      <li>Write Articles</li>
      <li>Share on Social Media</li>
    </ul>
        
    <a class="expand"><span class="plus">+</span><span class="minus">-</span></a>
  </div>
 
  </center>
   </div>
	<script>
		jQuery('.box').click(function() {
		  jQuery(this).toggleClass('selected');
		});
	</script>
	</div>
	<?php
	$op = ob_get_clean();
	return $op;
}
add_shortcode('lx_login_page','fn_lx_login_page');

/**** for include edit profile ui ****/ 
function edit_profile(){
  ob_start();
  global $lx_plugin_paths;
  include($lx_plugin_paths['lx_lms_lite'].'template/my_account.php');
  $op = ob_get_clean();
  return $op;
}
add_shortcode('user_profile','edit_profile');
?>