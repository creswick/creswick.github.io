--- 
layout: post
title: Wrestling Python
categories: tech
---
With the launch of the <a href="http://beta.stackoverflow.com">StackOverflow beta</a> I posed a question about python static analysis tools, as I have been playing with python and django recently for some side projects.  The responses at Stack Overflow quickly pointed to <a href="http://pychecker.sf.net">PyChecker</a>, <a href="http://divmod.org/trac/wiki/DivmodPyflakes">PyFlakes</a> and <a href="http://www.logilab.org/857">PyLint</a>.

Over all, it was a disappointing experience.  My experiences are outlined below, and they (more or less) reflect this more <a href="http://www.doughellmann.com/articles/CompletelyDifferent-2008-03-linters/index.html ">extensive review by Doug Hellman</a>.

Here are my first impressions of pyflakes, pychecker and pylint:

* **pychecker**: It crashes frequently, most of the runs I tried resulted in Errors that originated in the pychecker code (eg: AttributeError or IndexError: list index out of range were the most common).  For some reason I had to set the DJANGO_SETTINGS_MODULE environment variable before it would even run on any of the app code, and the documentation is very sparse.

* **pyflakes**: 'pyflakes --help' throws a TypeError -- erm... Documentation is also very sparse, and pyflakes is very forgiving (as far as I can tell, it only reports compile errors, warnings, redefinitions, and some concerns about imports--such as unused and wildcards).  pyflakes also seems to repeat itself:
> eventlist/views.py:4: 'Http404' imported but unused<br>
>     eventlist/views.py:4: 'Http404' imported but unused<br>
>     eventlist/views.py:5: 'from eventlist.models import *' used; unable to detect undefined names
>     eventlist/views.py:59: 'authenticate' imported but unused<br>
>     eventlist/views.py:61: redefinition of unused 'login' from
> line 59<br>
>     eventlist/views.py:5: 'from eventlist.models import *' used;
> unable to detect undefined names <br>
>    eventlist/views.py:4: 'Http404' imported but unused

* **pylint**: This seems to be the most capable of the tools suggested.  It has the best documentation.  LogiLab provides a tutorial, pylint has a help screen, and there is a (broken) link to a user manual, which would be extremely helpful.  There are some issues with applying pylint to django, since pylint doesn't know about the django classes (such as models.Model).  This means that a fair number of otherwise valuable errors are generated about missing class fields.  eg:
> `E:105: get_events_by_tag: Class 'Tag' has no 'objects' member`<br>

 Parsing these out automatically will be very difficult without some additional knowledge of the classes in use.  I'm not sure adding that is feasible, but it does seem likely that pylint is capable of dealing with this in the "right" way.  (I probably just need to point it to the django source, but there are no command line params that look likely, and, as mentioned earlier, the user manual is inaccessible.)

For the moment, I'm still looking into pylint -- pychecker and pyflakes need better documentation and they need to become more robust.
