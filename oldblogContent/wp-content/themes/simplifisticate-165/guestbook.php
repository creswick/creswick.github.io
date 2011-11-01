<?php
/*
Template Name: Guest Book
Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be
*/
?>

<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entrytext">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	<p class="postmetadata"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
		</div>
		<?php comments_template(); ?>
	  <?php endwhile; endif; ?>
	
	</div>

<?php get_footer(); ?>