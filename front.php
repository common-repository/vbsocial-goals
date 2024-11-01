<?php 
function gocl_goals_of_life(){ ?>
<div id="tabs">
  <ul>
    <li style="border-right:2px solid #000; padding-right:35px"><a href="#tabs-1">Goals</a></li>
   
  </ul>
  <div id="tabs-1">
   <div id="content">
    <div class="container">
        <div id="projects" class="projects">
            <section>
            
			</section>
        </div>
    </div><!-- / container -->
</div> <!-- / content -->
  </div>
 

<?php }?>
</section>
        </div>
    </div><!-- / container -->
</div> <!-- / content -->
  </div>
</div>
<script>
jq=jQuery;
ajax_url='<?php echo admin_url('admin-ajax.php'); ?>';
localStorage.offset=0;
localStorage.page=0;
posts_per_page=8;
loader='<center class="posts-loader"><img src="<?php echo plugins_url();?>/vbsocial-goals/img/turningArrow.gif"></center>';
jq(function(){
	load_live_data();
	jq(window).scroll(function(){
		scrltp=jq(window).scrollTop();
		docht= jq(document).height();
		winht=jq(window).height();
		if(scrltp==docht-winht) load_live_data();
     });
	 
	 jq("#tabs").tabs();
});

function load_live_data(){
	jq("#projects section").append(loader);
	jq.post(ajax_url,{action:'loadposts',offset:localStorage.offset,posts_per_page:posts_per_page},function(data){
		if(data!="no_more_posts") {
		jq("#projects section").append(data);
			localStorage.offset=parseInt(localStorage.offset)+posts_per_page;
			jq(".posts-loader").remove();
			}
			else{
				jq(".posts-loader").remove();
				jq(".site-footer").show();
				}
		});
		jq("iframe").each(function(){jq(this).attr("width",252).attr("height",180);});
	}
function apply_masonry(){
	jq("#projects section").masonry({itemSelector: '.item'});
	}
</script>
<?php  ?>