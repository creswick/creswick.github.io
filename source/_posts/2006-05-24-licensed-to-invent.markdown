--- 
layout: post
title: Licensed to invent?
categories: tech
---
My background in software development was built up on a strong belief that software should be freely available.  This belief led me to start using GNU/Linux and various GPL'd projects as an undergrad at Oregon State University.  Changing from the norm was painful - I had previously been on a window-only operating system diet, and while I could use Emacs, I was not yet zealous about it.   Numerous times I tried to go back to Windows, but the 2-4 week reinstall cycle that I had convinced myself was required (and may have been... this was in the early Win 98 days) drove me back to open solutions.

I eventually came to love the ability to customize <em>everything</em>.  I have always been a "power user", and I spent many hours crawling through the NT registry when I was in High school.  Linux, with the countless window managers and themeing sites drew me in like WinHack never could.  As I became more skilled in software development, I began customizing apps to my liking, hacking out bug fixes and adding features as I wanted them.  (Find a new game that looks cool, but can't stand playing it with the keyboard? Add joystick support!) All of this was  made possible, or at least heavily benefitted from, open source licenses (Particularly the GPL).

The intricacies of the various licenses were generally opaque to me, but I understood the gist of it:
<ul>
	<li>The GPL let you release source code that was free but could not be made non-free by anyone but the author.</li>
	<li>BSD-like licenses were less restrictive.</li>
</ul>
That was about all I knew, or cared.  I was happy with the GPL, and I've scoffed at the complaint that <a title="Viral Licenses" href="http://en.wikipedia.org/wiki/Viral_license">Viral licenses</a> are evil.
Recently, I started developing an application to assist with photograph management (back to the: <em>customize everything</em> point above... there are now to many applications to find exactly what I want, so I'm building my own--great solution, right?).  I settled on Java for the programming language, and intended to use the <a title="SWT" href="http://www.eclipse.org/swt/">SWT</a> (released under the <a title="Eclipse Public License" href="http://www.eclipse.org/org/documents/epl-v10.php">Eclipse Public License</a>) as the widget toolkit, since it is a visually attractive cross-platform solution.  However, I also want to make use of some <a title="GPL" href="http://www.gnu.org/copyleft/gpl.html">GPL</a> libraries.  If you've read through the mentioned licenses, you probably see the problem already.  It is not at all clear whether or not the SWT can be used with GPL applications.  <a href="http://azureus.sourceforge.net/">Azureus</a> seems to be doing this, and releasing their code under the GPL.  However, no one I've talked to can clearly state whether this is ok or not, and reference the relevant portions of legalese to support the claim.
All this confusion has meant that the only "safe" route to either not release my program at all (I consider this unacceptable), or to settle on one of the two licenses above and only use compatible code, which means the GPL, simply because there is more GPL'd content available than EPL'd content.  The depressing end is that the viral nature of the GPL is the reason there was a conflict, because the SWT cannot be re-released under an SWT-incompatible license (and it is not clear that I can do this and meet the GPL requirements that all source code be released as well.).

I doubt that either the Gnu foundation or IBM would chase me down for voiding a license for my personal photo manager, but the open source movement relies on the copyleft licenses to stay afloat, to a certain degree.  Without respecting those licenses we become hypocrits.

I wonder if OCaml would work...
