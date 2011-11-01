--- 
layout: post
title: "Cracking down on application clutter (or: my ${HOME} is my castle!)"
categories: tech
---
There was once a time when your home directory was treated as a nearly sacred place, a safe haven where you had near complete control.  This trust was only breached for very special reasons: user specific settings and background storage for applications could go in "dot-files"--the hidden files or directories that begin with a "." and therefore don't show up in normal directory listings.

Unfortunately, things began to change. I don't know what kicked it off, but soon there was a Desktop (or desktop) folder.  It was glaring--many XFree86 window managers don't even have the *concept* of a desktop, but the defaults environments were (and still are) often set to Desktop Managers.  Web browsers took after the DM's, and soon we all had these glaring "Desktop" directories hanging out whether we wanted them or not.  I've managed to tolerate this infraction for years, and aside from the occasional frustration (eg: Ecilpse and NetBeans, with their request for a ~/workspace and ~/NetBeansProjects directories).

However, today things changed.

<code lang="bash">
$ ls ~
bin/              PDF/		 
Desktop/          Pictures/	 
development/      Public/		 
documents/        src/		 
Documents/        shared/		 
downloads/	      Templates/	 
Mail/             Videos/		 
Music/            virtualMachines/ 
myapps/           workspace/       
</code>

Documents? (Ok, I can sort of understand that one.) Music? Pictures? Templates, PDF, Public, and Videos?! Did I suddenly become a master of multimedia? Keep in mind here, I'm a java hacker on a Linux box--this isn't exactly a fine-tuned rendering/desktop publishing platform.   And of course, every one of those directories is empty.  Thankfully, I checked before deleting `documents` vs. `Documents` (I've been bitten there before--on a mac due to case conflation--but that's another story).  

Why would I want a directory called PDF? I can understand (possibly) wanting to *tag* files with "PDF", but as part of a single-dimensional sorting criteria? (Hey, lets store all my .h files in ~/H/ and all my .cpp files in ~/CPP/! It'll be great!)

Needless to say, I've removed the offending directories, and this time I'm ready:

<code lang="bash">
$ kernel-filesystem-monitor-daemon-cat -v  watch ${HOME} | 
perl -ne '{
   if( /^CREATE/ ) { # only report create events
      s|.*URL:\./||g; 
      if ( !/^\./ ) { # don't report new dot-files
         print "$_ created @ "; 
         print `date`; 
      }
   }
}' > ~/whenCrapWentDown.txt
</code>
(newlines and comments introduced to improve clarity -- if you're pasting this into a shell, you'll need to either add \'s or remove newlines.)

<a href="http://freshmeat.net/projects/kfsmd/">KFSMD (kernel-filesystem-monitor-daemon)</a> is an app that does exactly what it's 32-character name says. Whenever a filesystem change occurs, it knows about it.  The `-cat` part just tells it to print to stdout, and the hunk of perl does some minor processing, and introduces time stamps.

I'm actually running this in a sticky terminal that's pinned to my E17 desktop, so if/when something starts building an empire in my home directory, I'll be able to compare with what apps are running, and hopefully track it down.  (It would be nice to collect the PIDs of the process that actually issued the system call to touch the file system, but this is good enough for now.)

<img id="image37" src="http://blog.ciscavate.org/wp-content/uploads/2008/07/fsWatcher.png" alt="fsWatcher.png" width="474"/>

Now we wait...

(<a href="http://www.linux.com/feature/124903">This article</a> got me going with KFSMD.)
