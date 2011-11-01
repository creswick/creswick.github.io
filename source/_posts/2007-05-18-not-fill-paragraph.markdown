--- 
layout: post
title: (not (fill-paragraph))
categories: emacs
---
I use emacs as much as possible, today being no exception.  Currently,
I'm doing a fair bit of writing at work, and unfortunately that means
Word (or Open Office at best, depending on what OS I'm in).  Neither
program supports much in the way of emacs compatibility modes, so if
I'm generating new content (as opposed to editing an existing doc.) I
tend to write in Emacs, and paste into Word when I'm finished.  This
works pretty well, considering.

There is one very annoying issue though: when in emacs, I use
`auto-fill-mode` to keep the content on screen as I type.  The problem
is that `auto-fill-mode` breaks lines with literal newline characters,
while the word wrapping in Word / OpenOffice just wraps the content
without additional characters.  As a result each line ends up as its
own paragraph when I paste content from emacs into Word. The solution,
of course, is to extend emacs with a simple function to undo
`auto-fill`.

## Merging lines

The first problem, as I saw it, was to find a function that would
merge two adjacent lines, and leave them separated by a single space.
Unfortunately, such a thing doesn't seem to exist.  No problem, we
need to go to the end of the current line (`end-of-line`), search
backwards for the first non-whitespace character (`[^ \t]`), erase
the rest of the line, including the end line (`kill-line`), and insert
a space (`(insert " ")`).

<pre>
    (defun mergelines(&amp;optional backward)
      "Merges the following line with this line, or merges this line
      with the previous line if a prefix argument is provided.
      Removes any whitespace between lines, replacing it with a
      single space."
      (interactive "P")
      (if backward 
          (previous-line))
      (end-of-line)
      (re-search-backward "[^ \t]")
      (forward-char)
      (kill-line)
      (insert " "))
</pre>

To make it more useful, I added a parameter that determines if the
line below, or line above should be merged.  This made the rest of the
`unfill` function much easier to write.

## Un-filling a region

Now that we can merge lines, lets address the problem of unfilling a
*bunch* of lines.  Since I know there is a function `mark-paragraph`
already, lets just deal with arbitrary regions for now.

<pre>
    (defun unfill-region(rstart rend)
      (interactive "r")
      ;; get to the end of the region:
      (goto-char rend) 
      ;; if the region ends on the first char. of a line, move up a line.
      ;; this makes it easier to select a paragraph and apply the function.
      (if (= (point) (line-beginning-position))
          (previous-line))
       ;; loop while the point isn't on the starting line:
      (while (not (= (line-number-at-pos (point))
    		 (line-number-at-pos rstart)))
        ;; merge with previous line.
        (mergelines t)))
</pre>

I've tried to comment well, so it should be relatively straight
forward, but here's an overview of the algorithm anyway:

1. `(interactive "r")` just means that the current region's start and
end locations are stored in the parameters `rstart` and `rend`.
2. We need to merge from the bottom up, because if we merge from the
top down we need to keep track of the lines merged, and things
generally become more complex (we might end up merging to many lines
if we loose count.).  Because of this, we first move to the end of the
region.
3. Since you (well, I) generally select from the first column, and
move one line past the last line I need (try it if you don't
understand what I mean), I needed a special case to keep from merging
the empty line between paragraphs.
4. Now, we merge each line with the line above, which moves the point
up a line too. When the point is on the same line as the start of the
region, we stop.

I haven't merged it with `mark-paragraph` yet, but it would be trivial
to do so.  More importantly, I want to make it skip blank lines, so it
will be possible to mark an entire document, and call `unfill-region`
(and therefore, write `unfill-buffer`).  As it is now, if you do that
the entire document ends up on one line, which is not usually ideal :)
