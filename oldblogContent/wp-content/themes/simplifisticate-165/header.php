<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<meta name="description" content="Damn.be; fiddling with Windows" />
<meta name="robots" content="noarchive" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<base href="<?php echo get_settings('home'); ?>/" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php
/* Random header code */
$randheader = rand(1,5);
?>
<?php wp_head(); ?>
</head>
<body>
<div id="page">
<?php
$string = get_bloginfo('name');
$first = substr($string, 0, 1);
$firstlower = strtolower($first);
?>
<div id="header">
	<h1 id="blogTitle"><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
	<div class="description"><?php bloginfo('description'); ?></div>
</div>
<div class="headerlinks">
	<a href="?panel">nav</a>
</div>
<div class="google">
<script type="text/javascript"><!--
google_ad_client = "pub-2917584502194995";
/* 468x60, created 6/23/08 */
google_ad_slot = "6260235072";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
