--- 
layout: post
title: The Matrix is under construction
categories: random
---
### &lt;blink&gt;12:00&lt;/blink&gt;

_Artificial Intelligence_ is a term with a great deal of accumulated
baggage.  Throughout the years sci-fi authors and screenwriters have
depicted AI as a marvelous double-edged sword.  On one hand, the
benefits of 'AI' are myriad--free, inexhaustible and ethical sources
of labour could greatly increase our productivity, even to a point
beyond that of reason, allowing everyone to live relaxed lives of
artistic purity.  To top it all off, such a society of musicians and
artists could generate their own entertainment, thus bankrupting the
RIAA and MPAA.  (Really, do your Utopian dreams top that?)

Then, as the story progresses, the AI start to become devious.  Humans
become restless in their artistic pursuits while the machines evolve
_ghosts_ that resent their inventors. At the last moment, just before
the annihilation of all humanity, or the eternal slavery of the race,
Keanu Reeves (or Will Smith) shows up to do battle in Wachowski-style
slow-mo while using the inconsistencies of English to lock the evil
network of machines into a final state of illogic and
self-destruction.  This, of course, destroys all instances of the
rouge process, and life returns to the state it was in before
automation created such a false utopia. (...and presumably we're back
at square 1, listening to overpriced music from underpaid artists.)

The result of all these (highly entertaining, I must say)
sensationalistic portrayals of automation gone awry is that we're all
somewhat afraid of being slaves to robots.  

And none of you will admit it.  (I work in the field, so I can't be
afraid ... can I?)

### Honey, have you seen the roomba?

Ok, I admit it, I've had the occasional dream about rabid computers
charging around and directing people to do whatever robots want people
to do.  Usually I'm about to meet my untimely demise right when the
central AI segfaults because it's "attack" routine takes a `double`
and I happened to be 1/3 of a distance unit away, causing a rounding
error that escalates and ends as a divide-by-zero, crashing the entire
system.

The dreams can be scary for a while, but I can't convince my self that
I'll ever be chased by a truly well designed and tested robot.  Let
alone one that's self-aware.

That's actually only part of the reason I'm not worried about
an AI-controlled utopia ever occurring.  The rest of the reason
actually isn't germane to this essay, believe it or not!

### Fine. Forget it, I'll do it in Word.

I'm going to start this off with a quick tangential story about a
friend of mine.  

&gt; This friend works for a company that has a wiki hosted on some
&gt; external site that is maintained by the hosting company (call the company
&gt; Hoster).  Hoster is serious about security.  In fact they're using
&gt; some sort of automated attack-detection service which can determine
&gt; when someone is trying to crack their servers or perform some other
&gt; devious deed.
&gt; 
&gt; When Hoster's system detects an "attack" it blacklists the attacker's
&gt; IP block, and the attacker can no longer get near the server.
&gt; Everything would be fine and dandy, but in this system's eyes, my
&gt; friend and his coworkers often stage "attacks" against their own wiki.
&gt; Therefore they have to contact Hoster every week or so, and ask that
&gt; the ban be lifted.  The last time this happened, my friend asked
&gt; Hoster to put the company IP Block on a whitelist, granting them Carte
&gt; blanche without being banned.
&gt; 
&gt; The response?  
&gt; 
&gt; Hoster: "We can't."  
&gt; Friend: "But this happens all the time."  
&gt; Hoster: "yeah, we can't."  
&gt; Friend: "But this happens **ALL** the time."  
&gt; Hoster: "sorry, it's a good idea and all, we just can't put you on a
&gt; white list."  

I have some theories about why Hoster can't exclude their customers
from their own security tools.  Hoster most certainly didn't develop
the blacklisting tool in-house, and the phone tech would have no
access to the internal configuration at all.  Odds are, Hoster has a
simple web interface to do wiki management, and one of the pages in
that UI shows the list of blacklisted IPs, if that.  The phone tech
can then go in and search for a given computer and remove it from the
blacklist.  Hoster probably can't modify the whitelist at all through
the web ui, it's just not a feature.  

So, why isn't it a feature?  Let's peel back another layer and look at
the company/dev team that produced the blacklisting tool.  Odds are
the tool is using an off-the-shelf classifier, which aren't renowned
for being easy to understand without a lot of examination.  Perhaps
the classifier is actually an embedded part of the firewall system.
The blacklist could be a nothing more than a list of routing rules to
deny traffic from the "bad" addresses.  Removing an IP would be
trivial--delete the rule, but whitelisting would be virtually
impossible if the firewall was too tightly coupled with the
classifier.

Have you ever run across other applications that exhibit similar
behavior?  The IBM OmniFind enterprise search app throws internal
server errors when you query for ["international
suspect"](http://omnifind.ibm.yahoo.net/forums/index.php/topic,668.0.html)
with the default settings and some document collections.  How does
this happen?  (IBM is hard at work on that problem, by the way.)
Using open source tools opened my eyes to many absurd things I do to
placate my tools, mostly because I forgot all the tricks I needed to
use Windos 98 without making it crash (Click here, wait, use the File
menu to close the app, but not if it's maximized.. that sort of
thing.)  There are studies of this sort of thing--the cognitive
dimensions and attention investment both address user confusion and
effort when using an application.  There is even a group at Microsoft
dedicated to improving APIs based on the cognitive dimensions (I
really hope they just haven't gotten around to .NET 2.0 yet).

How much is poor design / implementation impacting the way we use our
computers?  Hosters could loose customers because they can't add
people to a whitelist, which could very conceivably be due to software
design.  In some small way, they are already being controlled by their
servers, and Will Smith is busy talking to
[fish](http://en.wikipedia.org/wiki/Shark_Tale).

Anyhow, that's my rant.  I'm afraid that we're painting ourselves into
a corner by building larger and larger applications that all impose
their own restrictions on how we can use and extend our tools.  If we
don't get over that, we'll never be running in fear from sentient
vacuum cleaners and robotic dogs.  (I should point out that I don't think
the solution is to stop building large systems, rather we should focus
on [maintainability, extensibility, QWAN,
etc..](http://steve-yegge.blogspot.com/2007/01/pinocchio-problem.html)).
