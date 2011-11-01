--- 
layout: post
title: "Prezi: scalable, navigable presentations"
categories: tech
---
<strong>Edit:</strong>Prezi now has support for customizing colors / themes, and even documentation for the css! <a href="http://prezi.com/learn/color-wizard/?utm_source=MadMimi&utm_medium=email&utm_content=Holiday+features:+colors+and+fonts,+drag+and+drop&utm_campaign=Introducing+Colors,+Fonts,+and+Snap&utm_term=customize"> I'm happy to see official support for these features, but the layout problems are still a show-stopper for me.<strong>/Edit</strong>

I have been adopting a presentation style that diverges from the traditional bullet-point style promoted by Open Office and PowerPoint (although, PowerPoint 2007 diverges from pure bullets to more interesting shapes, using shading and encapsulation to show hierarchy.  It's a large improvement, but it still falls short of my ideal).  Instead of bullets and text, I try to make use of imagery and visual examples whenever possible.

My experience has reinforced what I've come across in the literature about balancing your audience's attention between the content on the wall and your narration.  Too much text or detail and you risk loosing your audience because they're overwhelmed or, if you're lucky, because they are focusing on the slide content instead of listening to your explanations.  It is also much easier to trigger emotional responses with visuals than it is with text, which explains some of the motivation for promotional/motivational presentations that are virtually devoid of text.  (<a href="http://www.sethgodin.com/">Seth Godin's</a> talks come to mind.  One way in which my presentations differ substantially from Seth's is that I generally talk about fairly technical topics.  The difficulties associated with finding high-quality, emotional, images to convey the intricate details of <tt>ptrace(2)</tt> is not the topic of this post, however.) 

A number of years back, I found a mention of using Scalable Vector Graphics (SVGs) for unconstrained presentations and that idea has stuck.  I've been developing slides in PowerPoint (OpenOffice has not yet reached the point where I can create professional-looking content), but I've never been happy with the traditional slide-based presentation style.  SVGs promise the ability to move between arbitrary locations, following a pre-defined path from "slide" to "slide".  Furthermore, since the content is scalable, you can literally zoom in to a portion of content to go into more detail, or zoom out to show context.  This presentation mode would also make it easy to diverge from your plan based on audience feedback.  This <em>can</em> be done with PowerPoint, but it is extremely difficult. 

<a href="http://prezi.com">Prezi</a> promises these benefits, so I spent the last few days building a presentation with Prezi at Galois: <a href="http://www.galois.com/blog/2010/09/30/tech-talk-enabling-portable-build-systems/">portable build systems</a>.  (The prezi presentation is near the bottom of this post.)  The rest of this entry discusses my experiences with Prezi.

## The Good, the Bad and the Ugly

I initially found the Prezi interface to be very intuitive.  The translation "zebra", a stripped round mult-function circle, appears whenever you select an object.  You then use the zebra to move, scale, rotate, or otherwise manipulate the selected object.  Other options are presented through a bubble menu that rotates and scales to show more detailed options as you select sub "bubbles".  It is well worth the few minutes it takes to sign up for a free account and try it out.  If you happen to be using 64-bit linux, you probably won't be able to use the flash app, however.  Prezi doesn't appear to work under that environment.  (if you can interact with the presentation embedded on this page, then you should be Ok.)  There is also an Adobe Air-based desktop app, which I used extensively.

I was off and brainstorming a presentation mind-map style after only a few minutes playing with the interface.  The freedom to create a few words of text, zoom in and flesh out more details, jump back out and pull in an image, all without concern for the layout of final form of the presentation was extremely motivating and liberating.  

I was able to be quite productive with Prezi until I began to consider the need for a unifying theme.  Two things stood in the way: 
<ol>
<li>Only eight options were provided for the overall look and feel of the presentation, and none were close enough to the Galois color scheme. There is also no way to add new look and feel options, and each option changes all the colors, fonts, backgrounds, and general style of the presentation.</li>
<li>The set of shapes and drawing tools is very limited. You can create: Thin free-hand lines, thick free-hand "highlighter" lines, circular rings (round frames), square brackets (square frames), gradient-filled rounded rectangles (roundrect frames), arrows, text in one of three fonts (optionally with bullets).
</ol>
None of the pre-defined colors can be changed through the user interface, aside from the eight styles mentioned above, which change <em>all</em> the colors / styles and fonts.  You can include arbitrary images, which helps with the limited set of shapes, however, you can only include pdfs if you are using the web-based client, the desktop client does not currently support pdf importing.

I stumbled across a solution to the limited selection of colors by unzipping the .pez file that holds a Prezi presentation on-disk and exploring the contents:
<code lang="bash">
prezi/
├── content.xml
├── preview.png
└── repo/
    ├── 13177749.png
    ├── 13177754.jpg
    ├── 13177758.png
    ├── 13177835.swf
    ├── codetree.png
    └── Personal_computer,_exploded_5.png
</code>
content.xml defines the SVG-like presentation content, and it ends with a set of css styles:
<code lang="html">
<style type="text/css"><![CDATA[
ZLabel.head
{
	fontFamily: head;
	color: #385d7c;
}

ZLabel.strong
{
	fontFamily: strong;
	color: #952b1d;
}
...
(and so on)
...
]]</style>
</code>
The colors in these styles can be adjusted, and you can even add new styles here (although you will need to manually insert them into the xml where you wish to use the new styles).  After editing the content.xml, zip up the presentation tree, taking care to maintain the correct hierarchy and no compression:
<code lang="bash">
$ ls
prezi/
$ zip -r -0 enabling-portable-build-systems-biuinv2vus9x.pez prezi/
</code>
One surprising benefit is that the updated styles are actually adopted by the UI widgets in the Prezi application, once you load a modified .pez file.

<a href="http://blog.ciscavate.org/wp-content/2010/10/prezi-text.png" style="text-align:center;" ><img src="http://blog.ciscavate.org/wp-content/2010/10/prezi-text.png" alt="The &quot;Title | Title | Body&quot; buttons change according to the css stylesheet in content.xml." title="prezi-text" width="300" style="margin-left:auto;margin-right:auto;"/></a>

These changes also persist across saves, loads, uploading to Prezi.com, and they appear to render properly when embedded, granting quite a lot of power, if you're able and willing to work with xml and css periodically.

Editing content.xml also proved to be the best way to spellcheck the presentation content, although the text that is actually <em>displayed</em> is in CDATA nodes, which your editor may skip over when running a spell checker.  Thankfully, the text is duplicated as plain text nodes, so you are still alerted to spelling errors when running ispell-buffer in emacs.  You can then fix the CDATA entry with a recursive edit.  (I suspect that the duplication is there to simplify text searching.)

I'm rather satisfied with these workarounds: The ugly aspects could be automated with some simple tools to update the content.xml as needed, and the hacks I found worked surprisingly well.

## Background images and "refactoring"

Unfortunately, I don't think Prezi is ready for prime-time, despite my success with css styles and spellchecking.  There are simply no facilities to precisely align or distribute objects with respect to each-other.  Further complicating this is the lack of a <a href="http://community.prezi.com/prezi/topics/grouping_as_in_cntrl_g">"group" option</a> to create aggregate objects.  You can select multiple objects by dragging a rectangle if you hold shift, but that isn't possible if the objects are on top of other objects -- the first click of a shift-drag must occur on the background of the Prezi, or you will simply select the lower object.  While this sounds a bit like a minor quibble, it is impossible to accurately position complex sets of objects if they are layered on top of other content (such as a background image).  I often need to add or remove "slides", and with Prezi, that can include a lot of object translations to provide or absorb space while fitting with the high-level overview of your presentation.  Without alignment tools, you also take the risk that a title will display askew with respect to the screen borders when you are mid-presentation.

I eventually adopted the following practice to help keep content square:
<ul>
<li>Press 'space' to enter "show" mode, and position the screen as it would be to show the "slide", then pres 'space' again to return to edit mode.</li>
<li>Create a roundrect frame, it will be square with the current view.</li>
<li>Use the borders of the roundrect as visual guides to make the slide content as square as possible.  I usually place the baseline of the title text with the top of the roundrect and then position it after the angle has been fixed.</li>
<li>Delete the roundrect</li>
</ul>
Now, never rotate any individual components of that slide again.  Use shift-clicking to select everything in the slide each time you need to rotate or move the slide.  If you need to add new content, first enter 'show' mode and click on the frame to make the camera rotate properly with respect to the slide.

## Summary

I'm excited to see how Prezi evolves, and I will be one of the first in line once the selection / alignment problems are fixed.  I hope that Prezi will motivate other implementations with similar capabilities, there is plenty of room for some healthy competition.

<div class="prezi-player"><style type="text/css" media="screen">.prezi-player { width: 550px; } .prezi-player-links { text-align: center; }</style><object id="prezi_biuinv2vus9x" name="prezi_biuinv2vus9x" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="550" height="400"><param name="movie" value="http://prezi.com/bin/preziloader.swf"/><param name="allowfullscreen" value="true"/><param name="allowscriptaccess" value="always"/><param name="bgcolor" value="#ffffff"/><param name="flashvars" value="prezi_id=biuinv2vus9x&amp;lock_to_path=0&amp;color=ffffff&amp;autoplay=no&amp;autohide_ctrls=0"/><embed id="preziEmbed_biuinv2vus9x" name="preziEmbed_biuinv2vus9x" src="http://prezi.com/bin/preziloader.swf" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="550" height="400" bgcolor="#ffffff" flashvars="prezi_id=biuinv2vus9x&amp;lock_to_path=0&amp;color=ffffff&amp;autoplay=no&amp;autohide_ctrls=0"></embed></object><div class="prezi-player-links"><p><a title="Galois is developing build system configuration capabilities to improve the portability of build systems." href="http://prezi.com/biuinv2vus9x/enabling-portable-build-systems/">Enabling Portable Build Systems</a> on <a href="http://prezi.com">Prezi</a></p></div></div>
