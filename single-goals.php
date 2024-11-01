<?php get_header(); the_post(); 
$post_time=get_post_time('U');
$expiry_time=$post_time+60*60*24*30;
$motivators_str=get_post_meta(get_the_ID(),'motivation_counter',true);
$motivators=explode(",",$motivators_str);
$time_tot=$expiry_time-$post_time;
$time_elp=time()-$post_time;
$bar_width=$time_elp/$time_tot*100;
$goal_video=get_post_meta(get_the_ID(),'goal_video',true);
$current_views=get_post_meta(get_the_ID(),'post_views', true);
$goal_creator=get_post_meta(get_the_ID(),'goal_creator',true);
if(!$current_views) $current_views=0;
update_post_meta(get_the_ID(),'post_views',++$current_views);
?>
 <div class="title  pattern-3">
        <div class="container" >
            <h1><span itemprop="name"><?php the_title(); ?></span></h1>
        </div>
    </div>
    <div id="content" class="post-details">
        <div class="container goals-container">
            <div class="sort-tabs campaign">
                <ul>
                    <li><a href="<?php bloginfo('url'); ?>" class="tabber">Home</a>
                    </li>
                    <li><a href="#backers" class="tabber">Motivators</a>
                    </li>
                    <?php if(get_current_user_id()==$goal_creator) echo '<li><a href="'.get_bloginfo('url').'/?p='.get_option('gocl_create_update_page').'&goalch='.base64_encode(get_the_ID()).'">Update Goal</a></li>';?>
                    <li><a href="<?php echo get_bloginfo('url').'/?p='.get_option('gocl_create_update_page'); ?>" class="tabber">Do this goal</a>
                    </li>
                    <li><a title="" "send=" " to=" " facebook"="" href="#" onclick="
    window.open(
      'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 
      'facebook-share-dialog', 
      'width=626,height=436'); 
    return false;" class="tabber">Challenge a Friend</a>
                    </li>
                </ul>
            </div>
            <article class="project-details">
                <div class="image">
     <?php if($goal_video) echo $goal_video;
	 elseif ( has_post_thumbnail() ) {the_post_thumbnail('full'); } else
	  echo '<img src="'.get_post_meta(get_the_ID(),'image_url',true).'" />'; ?>
                </div>
                <div class="right-side">
                    <ul class="campaign-stats">
                        <li class="progress">
                            <h3>Goal Stats</h3>
                            <p>Success Meter</p>
                            <div class="bar"><span style="width:<?php echo $bar_width;?>%"></span>
                            </div>
                        </li>
                        <li class="backer-count" style="margin-bottom:0px;">
                            <h3 id="num_of_motiv"><?php echo sizeof($motivators); ?></h3>
                            <p>Motivator</p>
                        </li>
                        <li class="backer-count" style="margin-bottom:0px;">
                            <h3> <?php echo $current_views; ?></h3>
                            <p style="font-size:14px; display:block;">Views</p>
                        </li>
                        <li class="days-remaining">
                            <script type="text/javascript">
                                window.onload = function () {
                                    new CountDown('<?php echo gmdate('F d, Y',($expiry_time)); ?>', 'counter');
                                }
                            </script>
                            <p style="font-size:18px;display:block;">Time to Go</p>
                            <div id="counter" class="days_remain_right"></div>   
                        </li>
                    </ul>
                    <div class="contribute-now">
                          <input type="submit" class="btn-green" id="regular_goal_motivater" value="Motivate Now">
                    </div>
                    <p class="fund">All pledges will be collected automatically until January 9, 2014.</p>
                </div>
            </article>
            <aside id="sidebar">
                <div class="widget widget-bio">
                    <h3>About the Author</h3>
                    <?php echo get_avatar(get_the_author_meta('ID'), $size = '40');  ?>
                    <div class="author-bio"> <strong><?php the_author_posts_link(); ?></strong>
                        <br> <small>
			Has posted <?php 
			$author_counter=0;
			$postss = new WP_Query(array('post_type'=>'goals','posts_per_page'=>1000,'author'=>get_the_author_meta('ID'))); 
			if($postss->have_posts()){
			while($postss->have_posts()){
			$postss->the_post();
			$author_counter++;
			}
			}
			echo $author_counter;
			wp_reset_query();
			?> Goals 
			
	</small>
                    </div><small>

	<ul class="author-bio-links">
     <?php if(get_post_meta(get_the_ID(),'original_permalink',true)) { ?>
		<a href="<?php echo get_post_meta(get_the_ID(),'original_permalink',true); ?>" target="_blank">Original Goal Page</a>
     <?php } ?>
	</ul>

	<div class="author-bio-desc">
			</div>



</small>
                </div><small>
					<div id="contribute-now" class="single-reward-levels">
							<!--dynamic-cached-content-->
	<form id="edd_purchase_819" class="edd_download_purchase_form" method="post">

			<div class="edd_price_options active">
		<ul>
																
                    <div class="clear">
						<h3><label for="edd_price_option_819_0"><input type="radio" name="edd_options[price_id][]" id="edd_price_option_819_0" class="edd_price_option_819 edd_price_options_input" value="0"> <p style="color:red;"> <span class="pledge-verb">If unsuccessful, I will...</span> </p></label></h3>
						<p>&nbsp;</p>
						<div class="backers">
							
													</div>
					</div>
                    </ul>
	</div><!--end .edd_price_options-->
		<div class="edd_purchase_submit_wrapper">
			<a href="#" class="edd-add-to-cart button blue " data-action="edd_add_to_cart" data-download-id="819" data-variable-price="yes" data-price-mode="multi"><span class="edd-add-to-cart-label">Motivate Now</span> <span class="edd-loading"><i class="edd-icon-spinner edd-icon-spin"></i></span></a><input type="submit" class="edd-add-to-cart edd-no-js button blue " name="edd_purchase_download" value="Motivate Now" data-action="edd_add_to_cart" data-download-id="819" data-variable-price="yes" data-price-mode="multi"><a href="http://gochangelife.com/checkout/" class="edd_go_to_checkout button blue " style="display:none;">Checkout</a>
							<span class="edd-cart-ajax-alert">
					<span class="edd-cart-added-alert" style="display: none;">
						<i class="edd-icon-ok"></i> Added to cart					</span>
				</span>
								</div><!--end .edd_purchase_submit_wrapper-->

		<input type="hidden" name="download_id" value="819">
					<input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart">
		
		
	</form><!--end #edd_purchase_819-->
	<!--/dynamic-cached-content-->
					
					</div>
				</small>
            </aside><small>
				<div id="main-content">			
<div class="post-meta campaign-meta">
	
	<div class="date">
		<i class="icon-calendar"></i>
		Launched: <?php the_date();  ?></div>

		<div class="funding-ends">
		<i class="icon-clock"></i>
		Goal Ends: <?php echo gmdate('F d, Y',$post_time+60*60*24*30); ?></div>
	</div>					
					<div class="entry-content inner campaign-tabs">
						<div id="description" style="display: block;">
							<div itemscope="" itemtype="http://schema.org/Product" itemprop="description">
                            <p>
								<?php the_content(); ?>
                            </p>
</div>						</div>
					
<span id="backers" style="display:block">
<?php if(sizeof($motivators)>0) { echo '<h3>Motivators of this goal</h3>';
foreach($motivators as $mtv) { 
if ($mtv==0) $unm="Guest";
else {$user_info = get_userdata($mtv);
$unm=$user_info->user_login;
}
?>
	<div style="float:left; text-align:center; margin:5px;"><span class="motivator-img" style="display:block; border-radius:100%;overflow:hidden;height: 60px;"><?php echo get_avatar($mtv, $size = '60'); ?></span>
   <?php echo $unm; ?>
   </div>
		<?php } 
	if(sizeof($motivators)>20) echo '<br /><a href="#" style="">view all</a>';
		} else {?>
        	<p>No Motivators yet. Be the first!</p>
<?php }?>
</span>
</div>

	<div id="comments" class="comments-area logged-in">

		<input type="hidden" name="comment_parent" id="comment_parent" value="">

		
</div><!-- #comments .comments-area -->

				</div>

			</small>
        </div><small>
		</small>
    </div> 
    <small>
<!-- / footer -->       
<div id="contribute-modal-wrap" class="modal">
		<!--dynamic-cached-content-->
	<form id="edd_purchase_819" class="edd_download_purchase_form" method="post">

			<div class="edd_price_options active">
		<ul>
																
                    <div class="clear">
						<h3><label for="edd_price_option_819_0"><input type="radio" name="edd_options[price_id][]" id="edd_price_option_819_0" class="edd_price_option_819 edd_price_options_input" value="0"> <p style="color:red;"> <span class="pledge-verb">If unsuccessful, I will...</span> </p></label></h3>
						<p>&nbsp;</p>
						<div class="backers">
							</div>
					</div>
					</ul>
	</div><!--end .edd_price_options-->

		<!--end .edd_purchase_submit_wrapper-->		
	</form><!--end #edd_purchase_819-->
	<!--/dynamic-cached-content-->
   
</div>	
</small>
<script>
url='<?php echo admin_url('admin-ajax.php');?>';
post_id='<?php echo get_the_ID();?>';
jq=jQuery;
jq(function(){
	jq("#regular_goal_motivater").click(function(){
		 jq("#num_of_motiv").html('<img src="<?php echo plugins_url('/vbsocial-goals/img/ajax_loader_gray_48.gif');?>" />');
		jq.post(url,{action:'incease_motivation',post_id:post_id},function(resp){
			jq("#num_of_motiv").html(resp);
			});
		return false;
		});	
		jq(".image iframe").attr("width",614).attr("height",400);
});

</script>
<?php get_footer(); ?>