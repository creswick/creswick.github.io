--- 
layout: post
title: "The Linux Tablet: Wacom rotations - waking up on the wrong side"
categories: tech
---
<strong>Update: updated the script with improved (functional) error output.  added notes about xhost.</strong>

There is an annoying bug in the sequence of code that manages the wacom rotation / sleep / resume and stylus calibration right now. (Where "right now" is Ubuntu Intrepid, with the <a href="http://linuxwacom.sourceforge.net/">0.8.2-1 wacom drivers</a>.) 

This is a document bug over at the <a href="https://bugs.launchpad.net/ubuntu/+source/wacom-tools/+bug/295292">ubuntu launchpad</a>, and the poster there does a fine job of describing the intricacies of reproducing the bug, so I'll only give a brief explanation here to help get indexed.  

If you rotate the screen any amount, even returning to the original rotation, and then sleep the machine, when it wakes up, the stylus will not be calibrated properly -- the cursor will be off to the side of the stylus point.  It doesn't seem to matter how it was calibrated when the machine slept, nor does it matter what rotation you're in when you put the machine to sleep.  

There is one straightforward workaround:  When you wake the machine, run wacomcpl, click on stylus, click calibrate (the mouse should now be under the stylus again), and exit wacomcpl.  This is incredibly cumbersome, but at least it's better than restarting X, which is what I have been doing.

Further inspection (based largely on the thread of comments on that launchpad bug) reveals that the problem is actually related to bad values for the TopX, TopY, BottomX and BottomY settings on the wacom devices after a resume.  By resetting these to their proper values for the current rotation, we can reestablish the proper calibration.  First off, we need to know the proper values, and the easiest way to get them is with `xsetwacom`:

[cc lang="bash"]
#!/bin/bash
# wacomSettings

echo "TopX=" `xsetwacom get stylus TopX`
echo "TopY=" `xsetwacom get stylus TopY`
echo "BottomX=" `xsetwacom get stylus BottomX`
echo "BottomY=" `xsetwacom get stylus BottomY`
[/cc]

Now, we'll run this for each rotation, and save the results.  You should end up with something like the following:

[cc lang="bash"]
 |rogue on bach |AC 70% | @ 00:02:26 ~|
 $ xrotate 1 && wacomSettings
xrandr to left, xsetwacom to 2
TopX= -46
TopY= -3
BottomX= 18605
BottomY= 24518
 |rogue on bach |AC 70% | @ 00:02:28 ~|
 $ xrotate 2 && wacomSettings
xrandr to inverted, xsetwacom to 3
TopX= 58
TopY= -46
BottomX= 24579
BottomY= 18605
 |rogue on bach |AC 70% | @ 00:02:35 ~|
 $ xrotate 3 && wacomSettings
xrandr to right, xsetwacom to 1
TopX= -173
TopY= 58
BottomX= 18478
BottomY= 24579
 |rogue on bach |AC 70% | @ 00:02:41 ~|
 $ xrotate 0 && wacomSettings
xrandr to normal, xsetwacom to 0
TopX= -3
TopY= -173
BottomX= 24518
BottomY= 18478
[/cc]

(Note that my bash prompt looks like & command lines above are indented, and the output is left-aligned)

That gives us enough information to script the calibration when we resume.  For example, when resuming to a "normal" rotation, I need to run:

[cc lang="bash"]
xsetwacom set stylus TopX -3
xsetwacom set stylus TopY -173
xsetwacom set stylus BottomX 24518
xsetwacom set stylus BottomY 18478
[/cc]
(Wrap that in a bash script and give it a shot!)

Here's the full script that gets the current orientation and then calibrates the common wacom devices:

[cc lang="bash"]
#!/bin/bash
#
# waCalibrate.sh: recalibrates the wacom stylus
#
# Author: Rogan Creswick
# License: just be nice

# Set LOG to something reasonable: 
# (The file does not need to exist, but the *directory* does)
LOG=/home/rogue/calibration.out
XSETWACOM=/usr/local/bin/xsetwacom


#
# Calibrates the wacom devices {stylus, eraser, cursor} with the 
# given offsets:
#
#  Usage:
#     calibrate <topx> <topy> <bottomx> <bottomy>
#
function calibrate {
	${XSETWACOM} --display :0.0 set stylus TopX $1 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set stylus TopY $2 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set stylus BottomX $3 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set stylus BottomY $4 >> ${LOG} 2>&1

	${XSETWACOM} --display :0.0 set eraser TopX $1 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set eraser TopY $2 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set eraser BottomX $3 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set eraser BottomY $4 >> ${LOG} 2>&1

	${XSETWACOM} --display :0.0 set cursor TopX $1 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set cursor TopY $2 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set cursor BottomX $3 >> ${LOG} 2>&1
	${XSETWACOM} --display :0.0 set cursor BottomY $4 >> ${LOG} 2>&1
}


function fixCalibration {
    # get the current orientation:
    ORIENTATION=`xrandr --verbose --query | grep " connected" | awk '{print $5}'`
    echo "Orientation: ${ORIENTATION}" >> ${LOG}
    
    case "${ORIENTATION}" in
	normal)
	    calibrate -3 -173 24518 18478	
	    ;;
	left)
	    calibrate -46 -3 18605 24518
	    ;;
	right)
	    calibrate -173 58 18478 24579
	    ;;
	inverted)
	    calibrate 58 -46 24579 18605
	    ;;
	*)
	    calibrate -3 -173 24518 18478
	    echo "ERROR!! unknown orientation! ${ORIENTATION}" >> ${LOG}
	    ;;
    esac
}

case "$1" in
    resume|thaw)
	date >> ${LOG}
	fixCalibration 
	whoami >> ${LOG} 
        ;;
    *)
	echo "not a resum|thaw event: $1" >> ${LOG}
        ;;
esac
[/cc]

Stick that in `/etc/pm/sleep.d/40wacomCalibrate` (or some similarly named file), make it executable by all (`chmod a+x /etc/pm/sleep.d/40wacomCalibrate`) and it should be run when the system resumes.  

<strong>Update:</strong> I found that the logging of the old script didn't work, so I've updated the script to reflect that.  There were also some problems with how I was testing the first script, and the actions I was taking didn't actually trigger the bug.  (The bug seems to be quite state-dependent, and markovian assumption was wrong.)  To get this to work, root will need to have access to the display that xsetwacom uses.  The simplest way to do this is to add `xhost +` to you x startup.  (I put it in my ~/.xsession just before `exec enlightenment-start`).
</bottomy></bottomx></topy></topx>
