--- 
layout: post
title: foreach(What?)
categories: tech
---
I've been adapting to Java 1.5 and c# (and c#, with .NET 2.0), all of which feature a new construct: the <tt>foreach</tt> loop.  The syntax is relatively similar to the construct in numerous other languages, such as perl's:

``` 
 
foreach $var (@list){
    # ...
}
 
```

In c# (or java, the syntax is the same), to loop over an array or IEnumerable collection, you just do:

``` 
 
foreach(int x in indices){
   // ....
}
 
```

Unfortunately, as I found today, the c# version shares something else with the Perl version: An absence of type checking.  Despite the explicit types in the loop construct, and the presence of generics (although these are missing in .NET foreach</tt> in c# is not type safe.  The end result is that you can do fun things like this with out the slightest hint of a warning:

``` 
 
double[] values = new double[]{....};
/* snip */
foreach(int v in values){
   // guess what? v == Math.Floor(values[i]) !
}
 
```

I find this particularly vexing because if you simply re-write the foreach to be a standard for loop, then the type checker will jump in and complain about the loss of precision:

``` 
 
for(int i=0; i 

With collections this becomes slightly more complex, and in .NET pre-2.0, Enumerators were not typed (they would simply return Objects, making it impossible to perform compile time type checking), with .NET 2.0, however these constructs could be parametrized, eg:

 
`````` 
 
foreach(T id in IEnumerable){
   // body
}
 
```

Why this isn't done is a mystery to me.  At the very least a rewrite rule could be used to turn each foreach into an equivalent for loop.  (There are plenty of ways around any performance problems this would cause at run time, and I'm happy to pay a compile-time penalty if it prevents run-time bugs!)

<em>Edit: Just for completeness, Java 1.5 does not exhibit this behavior, either when itterating over generic collections or arrays of basic data types:</em>
``` 
 
double[] values = new double[]{0.5, 0.6, 0.7};

for (int v : values){ // causes compile time error.
   System.out.println("v="+v);
}
 
```
<em>Note that it is actually an <b>error</b> in java, not a warning even.  I would assume this has something to do with the requirements Sun placed on backwards compatability with older JREs -- much, if not all, of the java Generics changes are simply rewrite rules.  C#, however, has no such constraints and can take advantage of a number of performance improvements that are not available to the java compiler.  I still don't see that as an excuse for discarding type saftey. --ERC</em>
