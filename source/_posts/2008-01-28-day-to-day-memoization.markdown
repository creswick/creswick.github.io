--- 
layout: post
title: Day to day Memoization
categories: java
---
Memoization (not **memorization**) is the process of remembering the
results of a computation for use later.  (I think of it as "making a
memo" to look back on later.)  Memoization is the core to any dynamic
programming implementation, and allows many simple algorithms to run
in linear or polynomial time when they would otherwise take an
exponential number of operations to complete.  This is most obvious in
the typical recursive Fibonacci example.  Consider the code:

[cc lang="java"]
public class Fib{
   public static void main(String[] args){
      System.out.println("done: fib of "+args[0]+"="+
      fib(Integer.parseInt(args[0])));
   }

   public static int fib(int n){
      int rval = 1;
      if (n &gt;= 2){
         rval = fib(n - 1) + fib(n - 2);
      }
      System.out.println("fib("+n+") = "+rval);
      return rval;
   }
}[/cc]
This is a straight-forward recursive implementation of fib.  When run
with `n=4`, we see this:
[cc lang="bash"]
$ javac Fib.java && java Fib 4
fib(1) = 1
fib(0) = 1
fib(2) = 2
fib(1) = 1
fib(3) = 3
fib(1) = 1
fib(0) = 1
fib(2) = 2
fib(4) = 5
done: fib of 4=5
[/cc]

**9** invocations of `fib(n)`, but only 5 **unique** invocations.  Lets
memoize the results, and try this again:

[cc lang="bash"]
$ javac Fib.java && java Fib 4
fib(1) = 1
fib(0) = 1
fib(2) = 2
fib(3) = 3
fib(4) = 5
done: fib of 4=5
[/cc]

**Much** better -- 5 invocations, 5 unique sets of parameters.

Here's the source with memoization:
[cc lang="java"]
public class Fib{
   static Map&lt;Integer, Integer&gt; memos = new HashMap(); // new

   public static void main(String[] args){
      System.out.println("done: fib of "+args[0]+"="+
      fib(Integer.parseInt(args[0])));
   }

   public static int fib(int n){
      if (memos.containsKey(n)) // new
         return memos.get(n);  // new

      int rval = 1;
      if (n &gt;= 2) {
         rval = fib(n - 1) + fib(n - 2);
      }
      System.out.println("fib("+n+") = "+rval);
      memos.put(n, rval);       // new
      return rval;
   }
}[/cc]
Notice that we only needed to add 4 new lines of code in order to
memoize the results.  When `fib(n)` is called, it simply checks to see
if it has previously been called with n, and if so, that result is
used again.  If the parameter has never been seen before, the method
continues as normal, storing the computed result before returning.
Memoization turns this naive (and exponential) implementation of `fib(n)`
into an efficient (linear) operation.

## Memoization in the real world ##

So, (un?)fortunately we don't spend all day implementing cool new ways
of computing ever increasing entries of the fibinocci sequence -- how
can memoization be put to use? After all, many algorithms are already
implemented in some fairly optimal fashion by the language APIs, and
you'd be a fool not to use those implementations.  What opportunity
will you have to memoize functions?

It turns out that you can memoize *anything*, as long as the function
is *pure* with respect to the memos (meaning: the function doesn't depend on any thing that is not used to key the hash of memos).  If the function is not pure, then you can still use memoization, but either the memo hash must key on all the state and parameters that can affect the results of the function.  On the other hand, if f depends on some state that changes very rarely, then it may make more sense to simply discard all the stored memos each time that aspect of state is altered.

Memoization is extremely handy when you have very common operations that are
fairly expensive.  I recently needed to optimize some code that
compares strings based on the case-insensitive stems of the words,
with stopwords removed.  So the strings "he wanted an apple" and "he
wants apples" should be equal. ("an" is a stopword, and ignored)

This meant doing many, many calls to a string stemmer, each of which
is a fairly expensive operation.  Fortunately, hashing strings as
extremely cheap (on the order of 1/4th the time it took to stem a
string of the same length), and I had plenty of memory to store the
parameters and the results in a `Map`.  Adding memos to
the two primary time-hoggers (the stemmer and a tokenizer) cut the
execution time of the application down from 2 hours to just over 7
minutes.

## Summary ##

You can memoize any function that only depends on it's parameters and
constant state (or near-constant state -- just don't forget to discard your
memos when the state changes!).  If the function is invoked multiple
times you will probably see a performance improvement.

If you need to memoize a function with multiple arguments, then you
just need to nest Maps, or create a unique key by combining the
parameters in some way.

Memoization is an extremely easy way to improve performance under
certain circumstances, particularly if you have a solid grasp on when
state changes outside of your methods / functions, or program in a
functional style.  It can be memory intensive, however.  If the
results of your functions are large, or maintain references to large
objects, then memoization may **penalize** performance if you run out of
memory and have to make use of swap space.
