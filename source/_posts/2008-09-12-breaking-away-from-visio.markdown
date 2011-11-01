--- 
layout: post
title: Breaking away from Visio
categories: tech
---
The 'proper' way to do user interface design is hotly contested in the OSS software development world, and the discussions usually boil down to three suggestions:
   
   1. "Just write it -- it's not that hard"
   2. "Use [glade|qt designer|netbeans|...] -- all the widgets are there"
   3. "Just use pencil/pen/whiteboard/etc -- it's faster"

I don't agree with any of these -- (1) is completely unreasonable.  Some people may be able to hack out a UI in their favorite language quickly, but when you suddenly need to move half the UI into a new dialog, or out of a dialog and into the main window, *and* change the tabs into a check list, with sample data, you're screwed.  Once you finish manhandling your code to account for that change, you'll need to add a component that is shaped like a septahedron with 7 distinct clickable areas and a tooltip that includes the latest stock quotes, and that tooltip needs to be scrollable.  The widget set places unreasonable restrictions on the design phase of your project.

Option (2) suffers from the same issues as (1) -- you're constrained by the widgets available, although this is less of an issue because it's generally easier to add images, and the images can look like the widgets you're missing.  However, since GUI UI development tools are, well, for development, they require you to do lots of irrelevant (at this stage) tasks, like specifying how objects will behave when they're resized, and dealing with layout managers.  

(3) is the closest fit for my needs, and I *do* do lots of paper/whiteboard prototyping, but eventually, I need to show something that looks *real*, and sketches don't cut it.  There simply isn't enough resolution there to convey everything that needs to be included in the mock-ups I create.  

Hm.. perhaps I should go into what I *do* need, since my needs may be pretty esoteric.  If you've made it this far, you're probably seething with anger, or you've got some idea of where I'm coming from.  I'm frequently in need of electronic versions of UI prototypes for remote collaboration, <a href="http://www.usabilitynet.org/tools/wizard.htm">"wizard of oz" testing</a>, or for inclusion in presentations and reports.  These mock-ups need to look "real" or the is a substantial risk of biasing any experiments, and there is an expectation of polish that can't be reached with hand-drawn interfaces.  Since a lot of what I create is to solve novel problems in (at times) esoteric domains, we often need to use a mix of existing and novel widgets.

Generally, we use Visio to create these interfaces.  It offers a good balance between vector drawing capabilities and shape templates for common UI widgets / forms / etc. You are also able to import images, which is fairly critical when updating or adding to the UI of an existing tool.  (It's easy to take a screenshot, clear out the details with the [Gimp][1], and import as a background layer in Visio.)

Unfortunately, I've been unable to find any OSS tools that can fill this niche as well as visio.  There are a few, as recent posts from [slashdot][2] and the old [Joel on Software forums][3] show:

   * [DENIM][4]: Lets you sketch out interfaces with a tablet / mouse and create navigable web sites from those sketches.  Lacks in the "polish" area.
   * [Pencil][5]: Firefox Plugin.  Peformance has been poor, in my experience. There are very few widgets (currently) available, and no image import capabilities (this is a huge flaw, IMHO).  Pencil could turn into something great, though.
   * [DIA][6]: Last release was in March, 2007, but the svn repo does show some activity.  DIA lets you create things like network diagrams, UML, and flow charts, much like Visio, however, there are no UI stencils.  Instructions for creating new stencils ('shapes') [exist][8], but the svg support for shapes is very limited (no gradients, no rounded rectangles, etc..) and the documentation is even worse.
   * [Kivio][7]: Much like dia, with essentially the same failings.
   * QT Designer | Glade | etc.: see above comments about GUI development tools.
   * [Inkscape][9]: Nominally a vector drawing tool, much like Adobe Illustrator, Inkscape has an active community, good documentation, and it is quite stable.  Unfortunately, it is not possible to customize the pallets / shapes available, and there is not much community support to make it a good UI design tool (aside from what can be done with any vector drawing app of this quality).
   * [Yahoo! UI Stencils][10] (YUI): Not really a tool, but rather a collection of svg images of common interface widgets.  

None of these, on their own, do the job.  However, with nothing else looking bright, I've been digging into [Inkscape][9] more over the last few days, and I think I've figured out a workflow that will do.

First off, the [YUI][10] stencils are critical -- but they are not in a format that can be easily imported and used as "widgets".  Ideally, Inkscape would let me define custom shapes, complete with constraints on the sub-components of those shapes to influence resize and translation behaviors, but that isn't yet available (to my knowledge).  You *can* get around this, somewhat, by using the open dialog as a pallet of sorts:

<blockquote>"If you have a number of small SVG files whose contents you often reuse in other documents, you can conveniently use the Open dialog as a palette. Add the directory with your SVG sources into the bookmarks list so you can open it quickly. Then browse that directory looking at the previews. Once you found the file you need, simply drag it to the canvas and it will be imported into your current document." (From the *Tips and Tricks* tutorial in Inkscape)</blockquote>

This would work reasonably well, if the open dialog were not modal! (Ranting about modal dialog is another post, or two, at least.)  Thankfully, you *can* drag from the dialog into an inkscape instance even if they are running on different processes :).  Therefore, you can start up two inkscape processes (NOT via the "new document" option on the toolbar or file menu -- you have to actually start up two instances separately or the dialog's modality will still interfere with your work).  Once you have the processes going, and two inkscape windows, open the open dialog on one of them, go to the directory with your widgets, minimize the (now useless) inkscape window you opened the dialog from, and rock on with the YUI stencils & whatever other tools you need to hack out your UI in the other inkscape instance.

There are a couple of things to keep in mind:

   * Inkscape supports layers, so you can create stub data in a separate layer from the UI structure, and set the background content in another layer, etc.. so you don't have to worry (as much) about grabbing the wrong thing and moving it out of place.
   * The drag-and-drop action from the open dialog will include everything in the dragged svg file -- so the YUI stencils (or any custom shapes you make) need to be broken out into separate files. (I've done this for some of the components, and you can download those files here: (<a id="p45" rel="attachment" href="http://blog.ciscavate.org/2008/09/breaking-away-from-visio.html/broken-out-yui-stencils/" title="Broken out YUI stencils">Broken out YUI stencils</a>).  They are released under a [Creative Commons Attribution 2.5 License][11].

   Pencil (or one of the other options) may work better for you -- many people have complained that their clients think an app is nearly finished because the UI looks "real", and there are numerous ways to address that.  (eg: <a href="http://napkinlaf.sourceforge.net/">NapkinLAF</a> for Swing apps.) I haven't had this problem, and something like NapkinLAF doesn't address the problems I have, which are all related to pre-coding UI design.

[1]: http://www.gimp.org/
[2]: http://ask.slashdot.org/article.pl?sid=05/11/19/2234228
[3]: http://discuss.joelonsoftware.com/default.asp?joel.3.218003.15
[4]: http://dub.washington.edu:2007/denim/
[5]: http://www.evolus.vn/Pencil/Home.html
[6]: http://www.gnome.org/projects/dia/
[7]: http://www.koffice.org/kivio/
[8]: http://www.togaware.com/linux/survivor/Walkthrough_Creating0.html
[9]: http://www.inkscape.org/
[10]: http://developer.yahoo.com/ypatterns/wireframes/
[11]: http://creativecommons.org/licenses/by/2.5/
