--- 
layout: post
title: "The Linux Tablet: Wacom drivers"
categories: tech
---
Ubuntu 8.10 configured most everything properly, as mentioned in the <a href="http://blog.ciscavate.org/2009/01/the-path-to-a-linux-tablet.html">previous post</a> in this series, but it did not result in a functional pen.

The tablet screen is a wacom digitizer with a pen that has two buttons (eraser and a finger button), and the tablet can differentiate between touching and hovering.  The linux wacom driver & tools are necessary to get this all working.  While I didn't find a single page with instructions that worked flawlessly, I was able to figure it out from a collection of links:

   * The Linux Wacom project: 
      * <a href="http://linuxwacom.sourceforge.net/index.php/minihowto">http://linuxwacom.sourceforge.net/index.php/minihowto</a>
      * <a href="http://linuxwacom.sourceforge.net/index.php/howto/x11">http://linuxwacom.sourceforge.net/index.php/howto/x11</a>
   * The Aliencam blog:
      * <a href="http://blog.aliencam.net/articles/aliencams-customized-ubuntu-setup-guide/">http://blog.aliencam.net/articles/aliencams-customized-ubuntu-setup-guide/</a>

First off, you will need the latest version of the linux Wacom driver (8.2.1 at the time of this writing).  The driver versions seem to be tied to your kernel versions, so this is quite important.  The wacom-tools package that comes with Ubuntu is not sufficient (in fact, you'll want to uninstall it if you have it already).

Once you have the wacom package downloaded, follow the directions for installing it in the howto (linked above).  The wacom package uses a typical configure, make, make install process but there are a few kinks:

   * configure (almost?) always succeeds, regardless of the dependencies you have yet to fill.  The make step will simply not build all the things you need if this happens, but it won't fail visibly.
   * You'll need to copy the kernel module into the /lib/modules/`uname -r`/kernel/drivers/usb/input/ directory manually (creating subdirs if necessary), *before* running make install.  (This is outlined in the mini-howto.)

Once wacom is installed, you can begin working with the X.org configuration.  This is fairly clearly explained at the aliencam blog linked above, or you can use my xorg.conf here.  

[cc lang="bash"]
Section "Device"
	Identifier	"Configured Video Device"
EndSection

Section "Monitor"
	Identifier	"Configured Monitor"
EndSection

Section "Screen"
	Identifier	"Default Screen"
	Monitor		"Configured Monitor"
	Device		"Configured Video Device"
EndSection


#BEGIN TABLET SECTION
Section "InputDevice"
	Driver		"wacom"
	Identifier	"stylus"
	Option		"Device"	"/dev/ttyS0"	# serial ONLY
	Option		"Type"		"stylus"
	Option		"ForceDevice"	"ISDV4"		# Tablet PC ONLY
	Option		"Button2"	"3"
EndSection

Section "InputDevice"
	Driver		"wacom"
	Identifier	"eraser"
	Option		"Device"	"/dev/ttyS0"   # serial ONLY
	Option		"Type"          "eraser"
	Option		"ForceDevice"   "ISDV4"		# Tablet PC ONLY
	Option		"Button3"	"2"
EndSection

Section "InputDevice"
	Driver        "wacom"
	Identifier    "cursor"
	Option        "Device"		"/dev/ttyS0"	# serial ONLY
	Option        "Type"		"cursor"
	Option        "ForceDevice"	"ISDV4"		# Tablet PC ONLY
#	Option	      "Mode"            "Absolute"
EndSection

# This section is for the TabletPC that supports touch
#Section "InputDevice"
#  Driver        "wacom"
#  Identifier    "touch"
#  Option        "Device"        "/dev/input/wacom"  # USB ONLY
#  Option        "Type"          "touch"
#  Option        "ForceDevice"   "ISDV4"               # Tablet PC ONLY
#  Option        "USB"           "on"                  # USB ONLY
#EndSection
#END TABLET SECTION

Section "ServerLayout"
	Identifier	"Default Layout"
	Screen		"Default Screen"
#	InputDevice	"Synaptics Touchpad"

#added to get tablet working
	InputDevice     "stylus"	"SendCoreEvents"
	InputDevice     "cursor"	"SendCoreEvents"
	InputDevice     "eraser"	"SendCoreEvents"
#	InputDevice	"touch"		"SendCoreEvents"
EndSection
[/cc]

After doing that, you should be able to reboot and the pen should be working.  You can do things like configure the buttons with `xsetwacom` (and you'll need that when it comes time to rotate the screen), but I kept getting this error when I tried to run `xsetwacom`:

[cc lang="bash"]
$ xsetwacom 
xsetwacom: error while loading shared libraries: libwacomcfg.so.0: cannot open shared object file: no such file or directory.
[/cc]

I made a lucky guess, and fixed the problem with a quick ldconfig:

[cc lang="bash"]
$ sudo ldconfig  # that was a lucky guess.
[/cc]

*Update:* There were some issues with the wacom calibration after a sleep/resume cycle *if* the laptop screen had been rotated during that prior wake cycle (this happens a *lot* more than it seems, given how complex that description is.)  I've written up a workaround <a href="http://blog.ciscavate.org/2009/01/the-linux-tablet-wacom-rotations-waking-up-on-the-wrong-side.html">here</a>.
