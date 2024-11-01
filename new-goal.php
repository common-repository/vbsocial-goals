<?php 
function gocl_create_edit_goal(){ 
if(!empty($_POST)) {
extract($_POST);
$new_post = array(
					'post_title'    =>  $goal_title,
					'post_content'  =>  $goal_descrip,
					'post_status'   =>  'publish',
					'post_type' 	=>  'goals',
					'post_date' => $goal_date,
					'post_author'    => $goal_author
				);
if($is_update=="no"){
	$pid = wp_insert_post($new_post);}
elseif($is_update=="yes"){
	$pid=$post_old_id;
	$new_post['ID']=$pid;
	 wp_update_post( $new_post );
	}
update_post_meta($pid ,'panalities',$panalities);
update_post_meta($pid ,'goal_video',$goal_video);
update_post_meta($pid ,'goal_creator',get_current_user_id());
update_post_meta($pid ,'post_views',$goal_views);
if ($_FILES) {
		foreach ($_FILES as $file => $array) {
		$newupload = gocl_insert_attachment($file,$pid);
		$attachement_url=wp_get_attachment_url($newupload );
	}
}
?>
<script>
<?php if($is_update=="no"){
$original_permalink=get_permalink($pid); ?>
jQuery.post("http://gochangelife.com/wp-admin/admin-ajax.php",{action:"save_external_goals",post_title:'<?php echo $goal_title; ?>',post_content:'<?php echo $goal_descrip; ?>',image_url:'<?php echo $attachement_url; ?>',goal_video:'<?php echo $goal_video; ?>',panalities:'<?php echo $panalities; ?>',original_permalink:'<?php echo $original_permalink; ?>',site_url:'<?php echo get_bloginfo('url'); ?>'},function(){
	window.location="<?php echo get_permalink($pid); ?>";
	});
<?php } else { ?>
window.location="<?php echo get_permalink($pid);?>";
<?php }?>
</script>
<?php
exit;
}
$goal_data=NULL;
if(isset($_GET['goalch'])){
$goalch=$_GET['goalch'];
	$goal_id=base64_decode($goalch);
$goal_data=get_post($goal_id);
$goal_meta_data=get_post_meta($goal_id);
}
if(!is_user_logged_in()) echo '<script>window.location="'.get_bloginfo('url').'";</script>';
?>
<div id="content">
    <div class="container">
   
<form action="" method="post" class="atcf-submit-campaign" enctype="multipart/form-data">
<h3 class="atcf-submit-section campaign-information">Goal Information</h3>
<p class="atcf-submit-campaign">
	<label for="shipping"><input type="radio" id="regular_goal" name="goal_type" value="regular" checked="checked"> Regular Goal</label>
</p>

<p class="atcf-submit-title">
	<input type="hidden" name="is_update" value="<?php echo $goal_data?'yes':'no';?>" />
    <input type="hidden" name="post_old_id" value="<?php echo $goal_data?$goal_data->ID:'';?>" />
    <label for="title">Title</label>
    <input type="text" name="goal_title" id="goal_title" class="valid" required="required" 
    value="<?php echo $goal_data?$goal_data->post_title:'';?>" />
</p>

<p class="atcf-submit-campaign-length">
    <label for="length">Days</label>
    <input type="number" min="30" max="30" step="1" name="length" id="length" value="30" readonly="readonly" class="valid">
</p>

<div class="clear"></div>

	
<input type="hidden" name="campaign_type" value="donation">
	<p class="atcf-submit-campaign-category">
		<label for="category">Category</label>
	</p>
 
<ul class="atcf-multi-select">
<?php $categories=array('Adventure', 'Art Business' ,'Eating Excercise' ,'Green' ,'Group', 'Habits', 'Music', 'Other', 'Relationships', 'School', 'Technology' ,'Work');
foreach($categories as $category) {
?>		
<li class="popular-category">
    <label class="selectit">
    <input type="checkbox" name="goal_cats[]" value="<?php echo $category; ?>"> <?php echo $category; ?></label>
</li>
<?php } ?>
 
</ul>

<div class="atcf-submit-campaign-description" style="width:100%; margin:auto">
	<label for="description">Description</label>
    <?php wp_editor($goal_data?$goal_data->post_content:'','goal_descrip',  $settings = array('media_buttons'=>false) ); ?>
</div>


<p class="atcf-submit-campaign-images">
    <label for="image">Featured Image</label>
    <input type="file" name="goal_image" id="goal_image">
</p>

<p class="atcf-submit-campaign-video">
    <label for="video">Featured Video Embed Code (Youtube or Vimeo iframe code)</label>
    <textarea name="goal_video" id="goal_video" style="width:350px; height:150px;" placeholder="Please keep width='252' and height='180'"><?php echo isset($goal_meta_data)?$goal_meta_data['goal_video'][0]:'';?></textarea>
</p>


<h3 class="atcf-submit-section backer-rewards">What happens when you slip or not complete your goal?</h3>
<p class="atcf-submit-campaign-shipping" style="display: none;">
	<label for="shipping"><input type="checkbox" id="shipping" name="shipping" value="1"> Collect shipping information on checkout.
    </label>
</p>

<p class="atcf-submit-campaign-norewards">
	<label for="norewards"><input type="checkbox" id="norewards" name="norewards" value="1"> No penalties for failing.</label>
</p>


<div class="atcf-submit-campaign-rewards" style="display: block;">
<div class="atcf-submit-campaign-reward">

<p class="atcf-submit-campaign-reward-description">
    <label for="panalities">Penalties for failing, slipping up</label>

    <input class="description" type="text" name="panalities" id="panalities" rows="3" placeholder="Example: Tell everyone on Facebook you failed, 100 push ups, start all over, pay a friend 10 dollars...">

</p>
		</div>
	</div>
	<h3 class="atcf-submit-section payment-information" style="display: none;">Your Information</h3>
	<p class="atcf-submit-campaign-submit">
			<button type="submit" name="submit" value="submit" class="button">
				Submit Goal
			</button>
	</p>
</form>
</div>
    <!-- / container -->
</div> <!-- / content -->	
<?php } ?>