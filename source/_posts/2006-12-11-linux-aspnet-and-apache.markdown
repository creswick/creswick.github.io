--- 
layout: post
title: Linux, ASP.Net and Apache
categories: tech
---
The mono project, which aims to provide an OSS alternative to the .Net framework, is capable of serving ASP.Net pages (amongst other things).  On Friday I sat down to do this, and realized that while there are many pages that describe the process, none that I could find, covered all the info needed to actually get up and running.  (I've built a Google Notebook of the better links I visited -- look [here](http://www.google.com/notebook/public/07937799986237074011/BDRQYIwoQi-HOhPQh) for those.)

## The Webserver ##

ASP.Net pages are served up by a web server called XSP (or XSP2).  XSP is a stand alone web server, however it doesn't have much of the functionality of Apache.  XSP is great for testing, and would work well on a dev machine, but it's not something you'd use directly for a live sever.  Generally, you'll want to run Apache with mod_mono, which is essentially a wrapper around XSP[2]. 

XSP vs. XSP2 -- XSP2 is capable of serving up ASP.Net 2.0 pages, while XSP is only 1.1 capable.  

## Packages ##

I work under Ubuntu, but the packages needed should be fairly easy to translate to other distros:
(I already had mono installed -- that step was trivial `apt-get install mono` or something similar.  If you don't have mono running, do that first.)

   * apache2
   * apache2-common
   * apache2-mpm-worker
   * apache2-utils
   * asp.net2-examples
   * mono-xsp2
   * mono-xsp2-base
   * mono-apache-server2
   * libapache2-mod-mono

Installing mod_mono will tell you to force-reload apache:

<pre>
 $ sudo /etc/init.d/apache2 force-reload
 * Forcing reload of apache 2.0 web server... 
apache2: could not open document config file /etc/mono-server/mono-server-hosts.conf   [fail]</pre>

In Ubuntu, at least, the default `mod_mono.conf` is not setup for XSP2.  If you see the failure above, then just pop open `/etc/apache2/mods-enabled/mod_mono.conf` and swap the commented lines to point to the correct mono-server directory.  `/etc/mono-server2/mono-server2-hosts.conf`.

## Configuration ##

(The Ubuntu documentation has the best description of this process I've found.  Look [here](https://help.ubuntu.com/community/ModMono) for their steps.  I've included this section anyway because I still had difficulty connecting the problems I had with the solution posted on the Ubuntu page.)

I'll assume you've been able to install and load the `mod_mono` module.  From this point, we need to set the ASP handler, and define mono web applications.  The first step is straightforward, at least if you're familiar with Apache configuration:

     # Enable ASP in /usr/share/asp.net2-demos
     Alias /samples "/usr/share/asp.net2-demos"
     
          SetHandler mono
     

The second step is new to me -- apparently mono needs an application root of some sort defined in addition to the handler configured above.  Most pages suggest using the line:

     MonoApplications "/samples:/usr/share/asp.net2-demos/"

However, that caused 'mod_mono' to segfault continuously (the apache logs were horrible:

     Another mod-mono-server with the same arguments is already running
     Another mod-mono-server with the same arguments is already running
     [notice] child pid 7371 exit signal Segmentation fault (11)
     [notice] child pid 7372 exit signal Segmentation fault (11)
     [notice] child pid 7373 exit signal Segmentation fault (11)
     [notice] child pid 7374 exit signal Segmentation fault (11)
     ....
     # (about 1 / second)

It turns out that there is another way to accomplish the same thing.  `/etc/mono-server2/` can contain `.webapp` files which define essentially the same thing.  The format for these files can be found in 'man xsp2':

     
        
           {appname}
           {virtual host for application}
           {port for application}
           {virtual directory in apache}
           {physical path to aspx files}
            is true by default --&gt;
           {true|false}
        
     

For the asp.net2 samples, I used this webapp config:

     
        
           samples
           localhost
           80
           /samples
           /usr/share/asp.net2-demos
        
     

After that, starting up apache worked without error and pointing a browser at http://localhost/samples popped up the Mono-project ASP.Net sample page.
