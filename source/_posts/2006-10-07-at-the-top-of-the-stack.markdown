--- 
layout: post
title: At the Top of the Stack...
categories: tech
---
As is the case with many geek-endeavors, the things I'm currently working on have nothing to do with the goal I set out to achieve.  At the moment I'm trying to find a way to convert xhtml into <a href="http://www.mwolson.org/projects/MuseMode.html">muse markup</a>.

Why? Because your average Java programmer Just Doesn't Get It when it comes to building a UI with Swing.  Obviously.

Frustration with Swing UIs led to the idea that I should throw together a tutorial on building a GUI with swing while paying attention to separation of concerns re: layout, manipulation, threading and data.  Blogging seemed like a prime medium to present such a tutorial, since each post could be tagged with a meaningful tag (eg: swing_tutorial) and I could post in sections.

This, of course, necessitates a blog (which I have, obviously) but which does emphatically <strong>not</strong> have any input mechanisms worth using for an extended period of time.  The wordpress on-line editors are, in a word, pathetic.  They may work great if you just want to stream your consciousness out to the world where it can pollute everyone's Google results with poor spelling and meaningless chatter, but the editors available simply can't handle source code.

It <strong>is</strong> possible to feed the blog pure html, which is (unfortunately) a step up from the rich editor, but which also isn't going to cut it, because it could be so much better.

Seriously, look at Mediawiki, or twiki, or any of the millions of wiki engines out there.  They <strong>ALL</strong> support better input mechanisms than wordpress.  So why am I using wordpress at all? Because for everything else -- user support, rss feeds, tags, data-base backed storage, plugins etc... it works great (as far as I know, come back in a week when I've resolved the editor issue to hear what else sucks. That should be enough time for me to find it.).
### Solutions
I hope to get around this pain-in-the-ass that is the wordpress editor by using emacs to post content via worpress's xml-rpc support. Therefore I need to find / enable or create support in emacs for the following things:
	<li>wiki-like markup, with support for code tags that can be interpreted by the geshi plugin on wordpress.</li>
	<li>a translator that converts wiki-like markup to xhtml, and back</li>
	<li>xml-rpc support, and the ability to retrieve and submit blog posts.</li>
	<li>Multiple Major Mode support for the wiki-like text mode, so that the aforementioned code tags use the correct font-lock mode</li>
	<li>A preview capability, so the blog posts can be converted, fed to a w3-el buffer and viewed, then edited again prior to posting and publishing.</li>
Most of these are possible in some fashion or another, but currently I'm stuck on the "translator for xhtml to wiki-like markup". Stay tuned for improvements, and news as I pop things off the stack.

Someday maybe I'll get around to talking about java.
