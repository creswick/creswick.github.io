--- 
layout: post
title: Polymorphic Generics in C#
categories: tech
---
Generics are great for adding some level of type safety to C#, but you may run into problems when using Generic classes with objects that aren't of the exact Class or Interface indicated by the generic type template.  Enter Generic Constraints.

Generic Constraints let you restrict the number of types a type variable can apply to.  For example, Assume you have three classes:

<pre>  
class Aclass{/*...*/}  
class Bclass : Aclass{/*..*/}  
class Cclass : Aclass{/*..*/}  </pre>   

If you have a method that takes a list of Aclass, you may want to be able to call it with a list of Bclass or Cclass as well.  The naive approach doesn't work however: 

<pre> 
public void foo(List&lt;Aclass&gt; myList){ /* ... */ }</pre>

When you call foo with a List or List, the compiler will complain that the types don't match. (unless you provide overrides of foo).  Instead, make foo a generic method, and specify a constraint on the type:

<pre> 
public void foo&lt;T&gt;(List&lt;T&gt; myList) 
    where T : Aclass 
{ 
  /* now you can treat
      myList as a List&lt;Aclass&gt;*/ 
}</pre>

This link goes over generics in c# in detail:

<a href="http://msdn.microsoft.com/library/default.asp?url=/library/en-us/dnvs05/html/csharp_generics.asp">MSDN on Generics</a>
