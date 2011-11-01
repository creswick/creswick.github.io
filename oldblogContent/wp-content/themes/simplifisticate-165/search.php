<?php get_header();
/*Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be */
?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2>Search Results</h2>
		
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
  			<div class="alt" id="post-<?php the_ID(); ?>">
				
				<h2 class="archivelist" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<div class="metadata" align="right">
					
						<?php the_time('j F Y') ?> | 
						<?php the_time('G:i') ?> | 
						<?php the_category(', ') ?> | 
						<?php comments_popup_link('no reply', '1 reply', '% replies'); ?>
						<?php if (function_exists('show_post_count')) {echo ' | ', show_post_count($post->ID, $before="", $after=" views"); } ?>

				</div>		
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
				
			</div>

<br />
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>
	
	<?php else : ?>

		<h2>Not Found</h2><br />

			<div class="entrytext">I couldn't what you were looking for, maybe you should try again with some other terms?</div>

		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>


<?php get_sidebar(); ?>

<?php get_footer(); ?>