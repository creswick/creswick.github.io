<?php get_header(); 
/* Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be */

if ( isset($_GET['panel']) ) {
	include('panel.php');
} else {

?>

<div id="content" class="narrowcolumn">
<div class="spacer"></div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="alt" id="post-<?php the_ID(); ?>">
	<!--		
	<h2 class="archivelist" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry">
			<?php the_excerpt() ?>
		</div> -->
		<div class="entry" id="post-<?php the_ID(); ?>">
		
			<h2 class="archivelist"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
				<div class="metadata" align="right">
					
						<?php the_time('j F Y') ?> | 
						<?php the_time('G:i') ?> | 
						<?php the_category(', ') ?>
						<?php if (function_exists('show_post_count')) {echo ' | ', show_post_count($post->ID, $before="", $after=" views"); } ?>

	
				</div>		
			
			<div class="entrytext">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
	</div>
	<br style="clear: both;"/>
	<?php endwhile; ?>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	</div>
<?php else : ?>
	<h2 class="center">Not Found</h2>
	<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
</div>
<?php }
get_footer(); ?>
