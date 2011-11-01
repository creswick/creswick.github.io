--- 
layout: post
title: Home is where .emacs is...
categories: tech
---
I finally found a way to quickly navigate to my home directory in windows today.  Being a long-time (well, 8-10 years) Linux user, when I started working in windows 40 hours a week, I had to adapt a bit, but most of that adaptation meant installing cygwin utilities, bblean, and emacs.  Unfortunately, it's most natural to put all the configuration files for these apps in my home directory -- a concept that is <em>almost</em> completely alien to a windows system.  As you probably know, in Win XP you do have a home dir, conveniently located at <tt>c:Documents and Settingsusername</tt> which is not extremely easy to navigate to, and there are no simple shortcuts to get there as there are in Linux / unix environments.

This has been annoying me for some time.  Everything goes into that directory -- I've moved firefox downloads, Visual Studio projects, symlinked <tt>My Documents</tt> to there, etc... Now before you shout out that I brought this upon my self, consider that:
<ul>
<li>I needed everything to be in the same location, for what should be obvious reasons. (but if the reason's arent obvious, try backing up all your crap from a multi-year old windows machine where you <b>didn't</b> keep everything in one place)</li>
<li>More things were already using this location than were not (remember, most of what I use is cygwin).</li>
<li>Cygwin makes it mildly painful to access things that don't fit nicely into the cygwin virtual filesystem thing.</li>
</ul>
Today, however, I found a solution.  Oddly enough, the integration between IE and Windows is why this works.
<ol>
<li>Open the Windows Explorer</li>
<li>Select View-Toolbars-customize</li>
<li>Add the "Home" button to the toolbar</li>
<li>Click on it. (This changes the Explorer "mode" to web-browser, and allows access to configure that button.)</li>
<li>Select Tools-Internet Options</li>
<li>Set your IE home page to <tt>c:Documents and Settingsusername</tt></li>
<li>Voila! Click on the home button again, and there you are :)</li>
</ol>
