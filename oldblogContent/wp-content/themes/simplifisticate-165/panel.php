<?php /* Simplifisticate 1.4 (c) 2006 selder - http://www.damn.be */ ?>

<div id="accesspanel">

<div id="content" class="narrowcolumn">
	
	<div class="post">
	
		<h2>Access panel</h2><br />
	
		<div class="entry">
	
				<?php bloginfo('name'); ?>'s access panel.  Browse the most recent posts, search for posts, browse the archives by category or date, read the pages or use any of the meta thingies.

		</div>
		
		<br />

	
	<div class="container">

			<div class="arch-right"> <!--latest 10 posts-->
				<h2>Latest 10 posts</h2>

 <!--BEGIN code for 10 posts-->

<ul>
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
						<?php

$shorttitle = substr(the_title('', '', FALSE), 0, 30);
if (strlen($shorttitle) > 28) $shorttitle = $shorttitle . ("...");

					?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php echo $shorttitle; ?></a></li>

		<?php endwhile; ?>
		<?php endif; ?>
</ul>

    <!--END code for 10 posts-->

			</div>
			
			<div class="arch-right"><!-- archives categories -->

				<h2>Archives by Category</h2>

  			<ul>
     			<?php /* wp_list_cats(); */ ?>
					<?php wp_list_cats(0, '', 'name', 'asc', '', 1, 0, 0, 1, 1, 1,0,'','','','','', 1) ?>
  			</ul>

			</div>
			
      <div class="arch-right"><!--archives month-->

				<h2>Archives by Month</h2>

  			<ul>
    			<?php wp_get_archives('type=monthly'); ?>
  			</ul>

			</div>
			


			
			<div class="arch-left"><!--search-->
<h2>Search</h2>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
			<div class="arch-left"> <!--pages-->

<h2>Pages</h2>
<ul>
<?php wp_list_pages('title_li=' ); ?>
</ul>
			</div>

<!--links-->

<?php 

$displink = get_links ('-1', '', '', '', FALSE, 'id', FALSE, FALSE, '-1', FALSE, FALSE);

if ($displink != "")
{
echo "<div class=\"arch-left\"><h2>links</h2> <ul>";
get_links('-1', '<li>', '</li>', '<br />', FALSE, 'id', TRUE, TRUE, -1, TRUE);
echo " </ul> </div>"; 
};
?>
			
			<div class="arch-left"><!-- meta -->

			<h2>Meta</h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
				<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
				<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
				<li><a href="http://www.damn.be/weblog/index.php/2006/05/18/wordpress-theme-simplifisticate/" title="Simplifisticate">Simplifisticate Visual Style</a></li>
				<?php wp_meta(); ?>
			</ul>

			</div>


	</div>
</div>
</div>
</div>	
