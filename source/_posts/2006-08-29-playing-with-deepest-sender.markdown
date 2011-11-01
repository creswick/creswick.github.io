--- 
layout: post
title: Playing with Deepest Sender
categories: random
---
I ran across <a href="https://addons.mozilla.org/firefox/1811/">Deepest Sender</a>, a firefox extension used for posting to a blog, today and thought I'd give it a shot.  It supports a small, but reasonable set of blog apps (Wordpress, LJ, ... two or three others that escape me at the moment, and I can't find the list right now..)   Setup was easy, and it wasn't difficult to connect to my wordpress install , but I don't see how to add multiple blogs, or choose a blog to post to that isn't the default.  I'm also a bit mystified at how it manages drafts (you can save to a local file, but that doesn't quite cut it -- I want to take advantage of the draft capabilities of the blog app, so I'm not tied to one machine). 

I wonder if it will let me use code tags in the rich editor..

``` 
 
-- haskell?
foo :: Int -&gt; Int
foo x = x * x
 
```

``` 
 
// Java test
public static int foo(int x){
    return x * x;
}
 
```

...not really... (although, there is a source view, and it's just a click of a tab to switch back and forth, which is how I entered the c# sample below, although it look horrible in the rich editor.) There are some interesting fields under the options menu, including a text area to enter a stylesheet, but no indication of what it does.  I may need to dig into the help docs later, but I'll probably look into emacs extensions first.  For now, the jury is out.  ``` 
  ///  /// Sample c# ///  public static int Foo(int x){   return x * x; }  
```


Ah, when posting, I discovered how the draft works.  There is a checkbox marked "draft" which publishes content as a draft, rather than to the site.  It would be much clearer to just have two buttons:  "Publish" and "Save as draft", it would take up the same amount of space, and require fewer clicks, but I suppose you could accidentally publish to the main site when you really wanted to click on draft.  In any case, it ruined the formatting on the code snippet, so for my purposes it will not work.
