--- 
layout: post
title: The path to a Linux Tablet
categories: tech
---
I finally broke down and bought a Lenovo X61 tablet (with SXGA+ screen!), and it arrived this week.  This is the first of a series of posts about getting it up and running with Linux.

First off, some specs:

   * Lenovo X61 Tablet PC with XSGA+ (1400x1050) screen (not multi-touch)
   * 4 gigs of ram
   * 200gb SATA hard disk
   * WIFI (Intel PRO/Wireless 4965 AG or AGN)
   * Gigabit Ethernet (Intel 82566MM)
   * Bluetooth 
   * Wide-area networking card (3G)
   * Fingerprint reader
   * Integrated SD card reader (Richoh R5C822 SD/SDIO/MMC/MS/MSPro)
   * Intel Audio (82801H ICH8 Family audio controller)
   * 1 PCMCIA (type-I?) slot
   * 4-cell battery
   * Ultrabay Slim (which will be holding my Ultrabay CD-RW / DVD drive from my old T42p)
   * Intel Mobile GM965/GL960 video controller. (256mb video ram?)

I'll flesh that list out more as I can find the details (eg: wireless chipset, video, etc..)

First off, I blew some time poking around in Vista of course :).  The handwriting input app is phenomenal in a lot of ways.  It works very well, training is well integrated, and it has worked with every input area I've tried.  It *could* be better if it had contextual clues, and could tie into things like Eclipse's intellisense.  Overall, though, it is amazing how simple it is to use, and how aesthetically pleasing the handwriting actually is.  There is a lot to be said for using a couple extra pixels to make the strokes taper off as you pull the pen away.  It has QWAN.

That done, I started to move on to installing Linux.  I'm giving Ubuntu 8.10 the first chance, and I thought I'd try using a USB-based install so I wouldn't have to monkey around with the Ultrabase & drive.  If you have an 8.10 system already, you can easily create a bootable usb ubuntu drive with `usb-creator` and an ubuntu iso.  This takes perhaps 45min - 1 hour.

Booting was as simple as going into the ibm bios-like page (by hitting the ThinkVantage button on boot) and telling it to boot from another device, then selecting the usb drive (that I had already inserted).  I split the existing 200gb partition in two with the ubuntu installer, keeping Vista in it's 100 gig sandbox, and leaving the remaining ~100 gigs for Ubuntu to partition further (which it did, as two partitions: one for / and one for swap.  /dev/sda5 and /dev/sda6).

I do wish it had said how much space was being allocated to each of those partitions though.  The installer didn't give any indication.

Installation from booting the installer from usb to booting into the installed system took right about 30min.  I'm impressed :)

Out of the box:

   * The screen is the proper res
   * Wireless looks like it might be working (I have to AP to verify)
   * Sound works
   * the pen does *not*
   * Screen rotation does not work
   * closing the lid shuts off the screen, but does not put the laptop to sleep.
      * This was easily fixed in the gnome power-management settings, and hey, it resumes too!
   * putting the laptop in tablet mode seems to have no effect (at least it doesn't shut off the screen ;)
   * Some power management is clearly working (screen dims when unplugged)
   * bluetooth was detected, but I have to way to test it.
   * Dual-booting seems to work just fine, although there are two entries for Vista in the grub menu, and the first boots into the Rescue and Recovery system.  Vista also had to do a chkdsk, and reboot before it would load.

More information as I figure it out :)
