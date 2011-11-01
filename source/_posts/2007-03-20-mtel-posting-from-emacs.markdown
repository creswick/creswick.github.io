--- 
layout: post
title: "mt.el: posting from emacs"
categories: tech
---
MT + Emacs + Markdown &amp; Geshi?
------------------------------

Is it possible? We're here to find out :) I just got around to
installing `ml.el` in emacs, and this post is essentially a test to
see if markdown syntax will work (and round-trip to Movable Type and
back to emacs -- it seems to come *from* mt correctly...).


### Source code:

	transcode-language: java
	public class TestClass{

	   /**
	    * test
	    */
	    public static void main(String[] args){
	      // ...
	    }
	}

### Well, not quite.

Everything seems to work, aside from the &lt;pre ...&gt; tags I use for code
formatting with geshi.  I'll have to look into a way of incorporating
that with some existing markdown formatting trick.

Ah-ha! The MT Geshi plugin I'm using
([transcode](http://periodic-kingdom.org/ben/)) expects code blocks to
be in the following format:

      &lt;pre&gt;&lt;code&gt;transcode-language: language
       ....
      &lt;/code&gt;&lt;pre&gt;

Markdown turns all consistantly indented regions into
&lt;pre&gt;&lt;code&gt;..&lt;/code&gt;&lt;/pre&gt; blocks, so all you have to do is to start
each code block with the (somewhat ugly) transcode-language: lang
line.  It's taken out by transcode, so the source will show up w/out
it.  Next task: Add an emacs filter to turn &lt;code lang="*lang*"&gt;... into
the above mentioned indentation/transcode syntax.
