--- 
layout: post
title: Treat your mailing lists like reference documents, please.
categories: tech
---
I desperately needed to find out why the tutorials I've been following for an Eclipse PDE task today kept referencing a startup.jar file that I could not locate.

A couple google searches later turned up this link:

<a href="http://dev.eclipse.org/newslists/news.eclipse.platform/msg62159.html">http://dev.eclipse.org/newslists/news.eclipse.platform/msg62159.html</a>

The poster in that thread had the same problem (back in Feb. 2007), and found the answer, but none of the content in that thread makes it trivial to locate the answer again.

The responder (with the answer) simply included a link to another mailing list:

<a href="http://dev.eclipse.org/mhonarc/lists/cross-project-issues-dev/maillist.html">http://dev.eclipse.org/mhonarc/lists/cross-project-issues-dev/maillist.html</a>

Notice that that page is *not* constant.  Today, it shows the most recent posts as of October 31st, 2008.  In order to figure out what had happened to startup.jar, I had to take into account the OP's response ("Ok so this is *very* recent."), the timestamp on the messages (Mon, 12 Feb 2007) and then navigate the mailing list archives to find that time period, and start reading.

Please don't put people through this sort of crap.  It's generally not difficult to find permlinks to a given email, or include a quick note with the actual answer.  I have the answer now (<a href="http://dev.eclipse.org/mhonarc/lists/cross-project-issues-dev/msg00873.html">startup.jar was replaced with org.eclipse.equinox.launcher in 3.3</a>), but there is no way that I can tie that answer to the conversation I've linked to above.

For the purposes of Google:

If you're having this problem:

<blockquote>
I'm trying to do some automation, but I'm running into a problem with the 3.3 integration build.<br /><br />

java -cp plugins\org.eclipse.platform_3.2.100.v20070126\startup.jar org.eclipse.core.launcher.Main<br /><br />

doesn't do anything. It doesn't say anything. The only information I'm getting is an exit status of 13. </blockquote>

Then you need to use "java -jar plugins/org.eclipse.equinox.launcher_1.0.0.v20070207.jar" (adjusting the version numbers for your installation).
