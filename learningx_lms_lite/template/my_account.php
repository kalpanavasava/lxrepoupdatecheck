  <?php
/**** for my account ui ****/ 
$user_id = get_current_user_id();
$first_name = get_user_meta($user_id,'first_name')[0];
$last_name = get_user_meta($user_id,'last_name')[0];
$user_info = get_userdata($user_id);
$email = $user_info->user_email;
?>
<div class="standarized_tab_innr1 text-center">
  <h1 class="head_h1"><b>My Account</b></h1>
</div>
<div class="edit_my_profile">
<div class="mt-3 mb-3">
  <div class="form-group">
    <label class="vw_text" for="my_acc_firstname">First Name</label>
    <input type="text" class="form-control my_acc_firstname" id="my_acc_firstname" value="<?php if(!empty($first_name)){echo $first_name;}?>">
  </div>
  <div class="form-group">
    <label class="vw_text" for="my_acc_lastname">Last Name</label>
    <input type="text" class="form-control my_acc_lastname" id="my_acc_lastname" value="<?php if(!empty($last_name)){echo $last_name;}?>">
  </div>
  <div class="form-group">
    <label class="vw_text" for="my_acc_email">Email</label>
    <input type="text" class="form-control my_acc_email" id="my_acc_email" value="<?php if(!empty($email)){echo $email;}?>">
  </div>
  <button class="btn_normal_state save_my_acc_info">Save Settings</button>
</div>
</div>