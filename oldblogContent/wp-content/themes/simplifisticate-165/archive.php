<?php get_header();
/* Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be */
?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>				
		<div class="post"><h2>Archive for the '<?php echo single_cat_title(); ?>' Category</h2></div>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<div class="post"><h2>Archive for <?php the_time('F jS, Y'); ?></h2></div>
		
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<div class="post"><h2>Archive for <?php the_time('F, Y'); ?></h2></div>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<div class="post"><h2>Archive for <?php the_time('Y'); ?></h2></div>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<div class="post"><h2>Search Results</h2></div>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<div class="post"><h2>Author Archive</h2></div>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<div class="post"><h2>Blog Archives</h2></div>

		<?php } ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
				
				<div class="alt">
					
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

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_footer(); ?>