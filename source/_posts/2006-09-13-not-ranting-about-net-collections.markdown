--- 
layout: post
title: (not?) Ranting about .NET collections...
categories: tech
---
The .NET collections continually frustrate me with the obvious ommisions, even in .NET 2.0.  Coming from a Java / Lisp background, I really expect two things out of a data structures API:
<ul>
	<li>Lots of collections to choose from.</li>
	<li>and; Easy manipulation of the structures you have available.</li>
</ul>
.NET doesn't fill either of these requirements very well.  At least we have generics now (which, admittedly, is a step above what's available in Lisp -- with regard to types, anyway).

Today I ran into (yet another) annoyance with .NET collections -- sorting arrays elegantly.  Given an array, you can sort it in accending order (according to the default comparer) with Arrays.Sort(..).

<pre>
// build &amp; populate the array. 
double[] values = source.ToArray(); 

// destructively!! sorts values, returns void, of course.
Array.Sort(values); 
</pre>

That's nice. Now, sort it in reverse:

<pre>
// build &amp; populate the array. 
double[] values = source.ToArray(); 

Array.Sort(values); 
// reverse the array.. adds O(n) ops.
Array.Reverse(values);
</pre>

or...

<pre>
// build &amp; populate the array. 
double[] values = source.ToArray(); 

Array.Sort(values, Double.ReverseComparer); 
</pre>

Oh, wait. There is no ReverseComparer on Double.. actually, there's no Comparer on Double either, but there is for most objects... so in general I could just wrap the comparer in a delegate or an anon class (to invert it) and use that.

Wait again.. c# doesn't have anon classes, and Sort doesn't take a delegate under any incantation. So, we could do this:

<pre>
private class ReverseDoubleComparer : IComparer&lt;double&gt;{
    public int Compare(double x, double y){
        return y.CompareTo(x);
    }
}

/* 
intervening code...
*/
// build &amp; populate the array. 
double[] values = source.ToArray(); 

Array.Sort(values, new ReverseDoubleComparer()); 
</pre>

That will work, but wow... for every type, I'll need to create a new class, and I can only deal with classes that implement IComparable.CompareTo(..).  Thankfully, I can use generics and some constructor overloading to deal with both situations:

<pre>
public class BackwardsComparer&lt;T&gt; : IComparer&lt;T&gt;{
   public BackwardsComparer(IComparer&lt;T&gt; c){
     _comparer = c;
   }

   public int Compare(T x, T y){
       return _comparer.Compare(y,x);
   }

   private IComparer&lt;T&gt; _comparer = null;
}
</pre>

Now, we just need to do the following:

<pre>
string[] strs = strSource.ToArray();

// sort strs in reverse alphabetical order:
Array.Sort(strs, 
   new BackwardsComparer&lt;T&gt;(StringComparer.CurrentCulture));
</pre>

And there we have it -- reverse array sorting without the additional cost of a Reverse() call, and avoiding the ugliness of case-specific classes floating around.  (The complete listing for BackwardsComparer and test suite are here: <a href="http://www.ciscavate.org/data/BackwardsComparer.cs">BackwardsComparer.cs</a> and <a href="http://www.ciscavate.org/data/BackwardsComparerTest.cs">BackwardsComparerTest.cs</a>
