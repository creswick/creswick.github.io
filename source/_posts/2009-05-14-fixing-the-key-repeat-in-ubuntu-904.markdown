--- 
layout: post
title: Fixing the key repeat in Ubuntu 9.04
categories: tech
---
I just upgraded my workstation to Jaunty (Ubuntu 9.04) and the key repeat delay and speed dropped to a frustrating level.

gnome-control-center can be used to fix this, but it requires that the gnome-settings-daemon be running, which forces it's opinions on many other aspects of my environment (I run Enlightenment dr17).

Poking around a bit, and help from #e on freenode, revealed that `xset` can be used to fix the key repeat settings.

[cc lang="bash"]
# Look at the current settings:
$ xset q
Keyboard Control:
  auto repeat:  on    key click percent:  0    LED mask:  00000000
  auto repeat delay:  660    repeat rate:  25
  auto repeating keys:  00ffffffdffffbbf
                        fadfffefffedffff
                        9fffffffffffffff
                        fff7ffffffffffff
# lets speed things up a bit...
$ xset r rate 250 40
[/cc] 
