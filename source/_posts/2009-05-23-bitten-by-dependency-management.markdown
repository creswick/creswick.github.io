--- 
layout: post
title: Bitten by dependency management
categories: java
---
<a href="http://blog.ciscavate.org/wp-content/2009/05/dependencies.png"><img src="http://blog.ciscavate.org/wp-content/2009/05/dependencies-small.png" alt="dependencies-small" title="dependencies-small" width="145" height="200" class="alignright size-full wp-image-106" /></a>I've started using Maven to manage my java projects, and overall I'm very happy with it.  It seems to be more mature than ivy, with better documentation, and the vast majority of tasks that I need "just work" (just don't ask me about jni--that's another post).

Today, (and yesterday, and a good portion of the night in-between) I ran into a nasty bug in a library that I didn't know my code depended on.  It isn't particularly important *what* I was working on, but just for context: I needed to strip a lot of text content out of nodes in the complete wikipedia revision history dump, so I was using Sax to parse the xml stream, filter out the stuff I wanted filtered out, and save the stuff that, well, I wanted saved.  Being that the input was all of wikipedia, there were a fair number of unicode characters in there.  As it turns out, the 2.6.2 xercesImpl has some sort of bug that allows xml with certain characters to be read without throwing exceptions, but when you try to write the chars that were actually read, you end up trying to write characters that aren't valid in xml.  Even if I'd known that in advance, my response would have been something like "ok, so what? I'm not using xercesImpl, and certainly not a version *that* old".

Well.

You see, in addition to using Maven, I've also been using the <a href="http://code.google.com/p/google-collections/">Google Collections</a> and <a href="http://code.google.com/p/jsr-305/">JSR305</a> libraries, so I just drop those `<dependency>` entries into the pom for all my new projects--I just assume that I'll need them, and I usually do.

Unfortunately, JSR305 1.3.8 depends on jaxen 1.1.1, which depends on xercesImpl 2.6.2 (jaxen also needs this dependency via xom 1.0, for what that's worth).  

Because that dependency was already present in my build path (via `mvn eclipse:eclipse`) and in the generated jar (via `<addClasspath>` and `<classpathPrefix>` in the `maven-jar-plugin`  configuration section), I never realized that my sax code actually had a *direct* dependency on xerces as well.  This all came to a head when, 3.53gb into my 2.8tb run, these rather unhelpful exceptions started popping up:

[cc lang="bash"]
java.io.IOException: The character '?' is an invalid XML character
       at org.apache.xml.serialize.BaseMarkupSerializer.characters(Unknown
Source)
       at com.stottlerhenke.tools.wikiparse.ContentStripper.characters(ContentStripper.java:195)
       at org.apache.xerces.parsers.AbstractSAXParser.characters(Unknown
Source)
       at org.apache.xerces.impl.XMLDocumentFragmentScannerImpl$FragmentContentDispatcher.dispatch(Unknown
Source)
       at org.apache.xerces.impl.XMLDocumentFragmentScannerImpl.scanDocument(Unknown
Source)
       at org.apache.xerces.parsers.XML11Configuration.parse(Unknown Source)
       at org.apache.xerces.parsers.XML11Configuration.parse(Unknown Source)
       at org.apache.xerces.parsers.XMLParser.parse(Unknown Source)
       at org.apache.xerces.parsers.AbstractSAXParser.parse(Unknown Source)
       at com.stottlerhenke.tools.wikiparse.ContentStripper.parse(ContentStripper.java:96)
       at com.stottlerhenke.tools.wikiparse.ContentStripper.main(ContentStripper.java:379)
[/cc]

`<rant>` "?" is not unicode -- it fits just fine in asci tables everywhere -- so please don't tell me that it's an invalid unicode character :) (0xd800 *is* an invalid unicode character, and that would have been _much_ more helpful) `</rant>`

Many hours later I was able to find a sample of the actual input that was causing these problems, and I was able to reproduce the issue with an input slightly smaller than 2.8tb.  Once that was done, I set out to make a minimal test case.  Rather than bother with a new maven project, I just hacked it out in emacs (not using google collections, etc. because, clearly, I wanted it minimal).  To my surprise, everything worked, and worked fantastically! But how? I didn't even supply an xml api on the classpath, yet it ran just fine!

In truth, I *did* supply an xml api -- xercesImpl.jar, and many other libraries -- via my environment's `$CLASSPATH`.  (Figuring that out was another adventure, but I digress.)  Once it became clear that I was indeed using a broken library it was simply a matter of explicitly specifying the dependency on a new version of xercesImpl, and rebuilding.

The moral?

Know your dependencies!  This should come along with knowing your language's built-in APIs well.  It wasn't clear to me that the SAX packages I was using were not part of the core java API, so it didn't strike me as odd that I didn't need to specify a classpath entry or a pom dependency before I could use sax.  

If you suspect something strange, you can see the dependency tree in the generated html documentation you get when running `mvn site`.  



