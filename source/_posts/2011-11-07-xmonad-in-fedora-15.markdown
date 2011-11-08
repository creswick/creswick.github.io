---
layout: post
title: "Installing custom XSessions in Fedora 15"
date: 2011-11-07 17:19
comments: true
categories: [tech, xmonad]
---

I realized today that Fedora 15 doesn't expose a UI for selecting
another xsession by default -- you can only log into Gnome 3.
Thankfully, once you install another window manager, then the
selection widget does appear; however, it was not clear how to add a
WM that wasn't packaged with Fedora.

In my case, I wanted to run the latest development version of
[xmonad](http://xmonad.org).  (Queue about an hour of fruitless
Googling.)

Eventually, I broke down and `yum install fluxbox`'d to get an
example.  After that, a `repoquery --list fluxbox` gave a list of the
files installed, and pointed me to `/usr/share/xsessions`, which
contains the list of WMs that the Fedora greeter uses to present
options.

Adding a new option is as simple as creating a new desktop file in
that directory, and pointing the `Exec` field to the binary of your
WM.

eg:

```bash
$ cd /usr/share/xsessions/
$ cat xmonad.desktop
[Desktop Entry]
Name=XMonad
Comment=Tiling window manager
Exec=/home/creswick/development/xmonad/cabal-dev/bin/xmonad
Type=Application
```