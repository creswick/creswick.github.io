--- 
layout: post
title: Blog migrations
categories: tech
---
I've moved [Bitwise Evolution](http://blog.ciscavate.org) to yet another blog -- this time I've moved from WordPress to MovableType.    The motivating factor was that WordPress made it extremely difficult to post correctly formatted code along with other content.  WordPress also doesn't store a non-html version of each post, so you can't easily edit old content without hacking auto-generated html.

Movable Type proved to be slightly more difficult to install, but it is much more configurable, and has a huge set of varied and useful plugins that actually do what they describe (*gasp*).  Some of the things I've enabled include:

   * [Markdown](http://daringfireball.net/projects/markdown/) for wiki-like markup
   * [SmartyPants](http://daringfireball.net/projects/smartypants/) for smart quotes.
   * [GeSHi](http://qbnz.com/highlighter/) for syntax highlighting.  (This required a couple additional plugins)
      * [Transcode](http://periodic-kingdom.org/ben/) To hook MovableType up to GeSHi
      * [MTMacro](http://bradchoate.com/weblog/2002/08/12/mtmacros) Needed to make the transcode syntax bearable.
      * [MTRegex](http://bradchoate.com/weblog/2002/07/27/mtregex) To add conditional behavior to the macros.
   * [Acronym](http://gemal.dk/mt/acronym.html) Used to enable mouse-over acronym expansion (so you can easily find out what DTD, XHTML, PCMCIA and etc. stand for, and it's all automatic.)
   * [LivePreview](http://plugins.movalog.com/livepreview/) because none of the stuff above (except for Markdown and Smartypants) render correctly in the default preview view.

Here's the macro used to turn '&lt;pre lang="java"&gt; .... &lt;/pre&gt;' into the proper format for transcode:

     &lt;pre&gt;&lt;code&gt;transcode-language: java
           ...
     &lt;/code&gt;&lt;/pre&gt;

Macro:

     
     <pre>``` 
 transcode-language: 
      
```</pre>
     

       
     <pre></pre>
     
     

Sooner or later I'll probably take another look at blogging from emacs.
