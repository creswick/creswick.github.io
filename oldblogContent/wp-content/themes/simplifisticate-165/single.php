<?php get_header();
/* Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be */
?>

	<div id="content" class="narrowcolumn">
		
		<div class="spacer"></div>
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php if (function_exists('add_count')) {if($id > 0) { add_count($id);}}?>
  
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
		
	<?php comments_template(); ?>

	<?php endwhile; else: ?>
	
		<p>Sorry, no posts matched your criteria.</p>
	
<?php endif; ?>
	
	</div>


<?php get_footer(); ?>
