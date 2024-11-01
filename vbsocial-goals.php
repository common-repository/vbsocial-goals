<?php
/**
 * Plugin Name: vBsocial Goals
 * Description: Add your goals and share on community.
 * Version: 2.0
 * Author: vbSocial Team
 */
require 'front.php';
require 'new-goal.php';
function gocl_enqueue_styles_scripts(){
	$plugin_url = plugins_url()."/vbsocial-goals/";
	wp_enqueue_style('mian-style', $plugin_url.'css/main.css' );
	wp_enqueue_style('entypo-style', $plugin_url.'css/entypo.css' );
	
	wp_enqueue_script('jquery','','','',true);
	wp_enqueue_script( 'jquery-ui-core','','','',true);
	wp_enqueue_script( 'jquery-ui-tabs','','','',true);
	wp_enqueue_script('fundify',$plugin_url.'js/fundify.js','','',true);
	wp_enqueue_script('masonary',$plugin_url.'js/masonry.pkgd.min.js','','',true);
	
}
add_action("wp_enqueue_scripts", "gocl_enqueue_styles_scripts" );
add_action( 'admin_enqueue_scripts', 'gocl_enqueue_styles_scripts' );

add_action( 'init', 'gocl_create_post_type' );
add_action( 'init', 'gocl_goals_cat_init' );
function gocl_create_post_type() {
	register_post_type( 'goals',
		array(
			'labels' => array(
				'name' => __( 'Goals' ),
				'singular_name' => __( 'Goal' )
				),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'goals'),
			'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
			)
	);
}
function gocl_goals_cat_init() {
	register_taxonomy(
		'goals-cat',
		'goals',
		array(
			'hierarchical' => true,
			'label' => __( 'Goal categories' ),
			'rewrite' => array( 'slug' => 'goals-cat' )
		)
	);
}
function gocl_goals_single_template($single_template) {
     global $post;

     if ($post->post_type == 'goals') {
          $single_template = dirname( __FILE__ ) . '/single-goals.php';
     }
     return $single_template;
}

function gocl_insert_attachment($file_handler,$post_id,$setthumb='false') {
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload( $file_handler, $post_id );
	 if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;

}

add_filter( 'single_template', 'gocl_goals_single_template' );

add_action('wp_ajax_incease_motivation','gocl_increase_motivation');
add_action('wp_ajax_nopriv_incease_motivation','gocl_increase_motivation');
function gocl_increase_motivation(){
	extract($_POST);
	$arr_count=get_post_meta($post_id,'motivation_counter',true);
	if(!$arr_count) $arr_count='';
	$arr_count.=get_current_user_id().",";
	update_post_meta($post_id,'motivation_counter',$arr_count);
	echo sizeof(explode(",",$arr_count));
	die();
	}
add_shortcode('goals_of_life','gocl_goals_of_life');
add_shortcode('create_edit_goal','gocl_create_edit_goal');

	//create dynamic pages at the time of plugin installation

	// Create post object			

	$pageindex = get_page_by_title( 'Create Goals' );

	if($pageindex=="")

	{

		$my_post6 = array(

		'post_title'    => 'Create Goals',

		'post_content'  => '[create_edit_goal]',

		'post_type'     => 'page',

		'post_status'   => 'publish',

		'post_author'   => 1,

		'post_category' => '',

		'comment_status' => 'closed',

		'ping_status'    => 'closed'

		);

		

		// Insert the post into the database

		$pageindex=wp_insert_post( $my_post6 );

	}


//page2

	$pageindex = get_page_by_title( 'Goals' );

	if($pageindex=="")

	{

		$my_post7 = array(

		'post_title'    => 'Goals',

		'post_content'  => '[goals_of_life]',

		'post_type'     => 'page',

		'post_status'   => 'publish',

		'post_author'   => 1,

		'post_category' => '',

		'comment_status' => 'closed',

		'ping_status'    => 'closed'

		);

		

		// Insert the post into the database

		$pageindex=wp_insert_post( $my_post7 );

	}

//end add pages






function gocl_loadposts(){
extract($_POST);
$wp_query = new WP_Query( array('post_type'	=> 'goals','post_status' => 'publish','offset'=>$offset,'posts_per_page' => $posts_per_page));
if ( $wp_query->have_posts()):
while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
$post_time=get_post_time('U');
$expiry_time=$post_time+60*60*24*30;
$motivators_str=get_post_meta(get_the_ID(),'motivation_counter',true);
$motivators=array();
$motivators=explode(",",$motivators_str);

$goal_video=get_post_meta(get_the_ID(),'goal_video',true);
$time_tot=$expiry_time-$post_time;
$time_elp=time()-$post_time;
$bar_width=$time_elp/$time_tot*100;
$days_remaining=30-round($bar_width/100*30);
$current_views=get_post_meta(get_the_ID(),'post_views', true);
if(!$current_views) $current_views=0; ?>        
<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> goals type-goals status-publish item">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
<?php 
if($goal_video) echo $goal_video;
elseif(has_post_thumbnail()) the_post_thumbnail('medium'); 
else echo '<img src="'.get_post_meta(get_the_ID(),'image_url',true).'" />';

?>
</a>

<h3 class="entry-title">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
</h3>

<p><?php echo substr(get_the_content(),0,120)."..."; ?></p>
<div class="digits">
    <div class="bar">
    	<span style="width:<?php echo $bar_width;?>%"></span>
    </div>
    <ul>
        <li><strong><?php echo sizeof($motivators); ?></strong>Motivator</li>
        <li><strong><?php echo $current_views; ?></strong> Views</li>
        <li><strong><?php echo $days_remaining; ?></strong> Days to Go</li>
    </ul>
</div>
</article>
<?php endwhile; else : echo 'no_more_posts'; endif;
			
	die();
	exit;
	}
add_action("wp_ajax_loadposts","gocl_loadposts");
add_action("wp_ajax_nopriv_loadposts","gocl_loadposts");

add_action('admin_menu', 'gocl_submenu_page');

function gocl_submenu_page() {
	add_submenu_page(
    'edit.php?post_type=goals',
    'Goals Configuration',
    'Goals Configuration',
    'manage_options', 
	'goals-configuration',
    'gocl_page_html'
);
}
function gocl_page_html(){
extract($_POST);
foreach($_POST as $k=>$v) update_option($k,$v);
?>
<div class="goals-admin-wrap">
<h2>Goals Pages Configuration</h2>
<?php if(!empty($_POST)) echo '<h4 style="color:green"> Updated Successfully</h4>';?>
<form action="" method="post" name="goals_config">
<label>Choose Main Goals Page</label>
<select name="gocl_mian_page" required="required">
<option value="">Please Choose a Page:</option>
<?php 
$wp_query = new WP_Query( array('post_type'	=> 'page','post_status' => 'publish','posts_per_page' => 1000));
if ( $wp_query->have_posts()):
while ( $wp_query->have_posts() ) : $wp_query->the_post();
$sel=get_option('gocl_mian_page')==get_the_ID()?'selected="selected"':'';
echo '<option value="'.get_the_ID().'" '.$sel.'>'.get_the_title().'</option>';
endwhile;endif;
?>
</select>
<br/><br/>
<label>Choose Goals Creation/Update Page</label>
<select name="gocl_create_update_page" required="required">
<option value="">Please Choose a Page:</option>
<?php 
$wp_query = new WP_Query( array('post_type'	=> 'page','post_status' => 'publish','posts_per_page' => 1000));
if ( $wp_query->have_posts()):
while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
$sel=get_option('gocl_create_update_page')==get_the_ID()?'selected="selected"':'';
echo '<option value="'.get_the_ID().'" '.$sel.'>'.get_the_title().'</option>';
endwhile;endif;
?>
</select>
<br/><br/>
<input type="submit" style="float:right;margin-right: 20px;" value="Update Settings" class="button button-primary button-large">
</form>
</div>

<div style=" background:#fff;width:40%; margin:20px 0; padding:10px">
<h3>Shortcodes:</h3>
Shortcode for goals page: [goals_of_life]<br /><br />
Shortcode for Create New goal page: [create_edit_goal]<br /><br />
</div>

<?php
	}
	
?>
