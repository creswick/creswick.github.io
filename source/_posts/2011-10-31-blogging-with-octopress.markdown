---
layout: post
title: "Blogging with Octopress"
date: 2011-10-31 12:14
comments: true
categories: [blogging, tech]
---

I heard about [Octopress](octopress.org) today, so I'm giving it a
shot.  It uses github pages to provide a blogging platform, which I've wanted for a while.

This post is just testing to see how Octopress works (I'm putting it through it's paces.)

``` bash Testing bash syntax highlighting http://www.haller.ws/logs/view.cgi/WhatAreShellsGoodFor haller's tips.
#  Works much like xargs, but don't forget the flexibility of inserting
#  {} in the ensuing expression for the $line location.
#
# Examples: http://www.haller.ws/logs/view.cgi/LearnToShootWithBash
each() { 
	local line="" 
	while read line; do # sub {} with $line and run it 
#		eval "${@/\{\}/${line}}" 
		eval "${@/\{\}/\"${line}\"}" # $@ =~ s/ {} / $line /
	done 
} 
```

Here's another code block, using Haskell:

``` haskell Does it understand Haskell?

-- Some random code from Newt:
import Test.HUnit      ( (@=?) )
import Test.Framework.Providers.HUnit
import Test.Framework ( testGroup, Test )

-- | Create a Test from a function, a description, an input, and an oracle:
genTest :: (Show a, Show b, Eq b) => (a -> b) -> (String, a, b) -> Test
genTest fn (descr, input, oracle) =
    testCase (descr++" input: "++show input) assert
        where assert = oracle @=? fn input

genTestIO :: (Show a, Show b, Eq b) => (a -> IO b) -> (String, a, b) -> Test
genTestIO fn (descr, input, oracle) =
    testCase (descr++" input: " ++show input) $ do
        res <- fn input
        oracle @=? res
```

There are more examples of including code here: http://octopress.org/docs/blogging/code/
