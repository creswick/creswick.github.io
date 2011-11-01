--- 
layout: post
title: Test-Driven XML Schema dev with xmlstarlet
categories: tech
---
Just to document how I do this:

*Problem:* I need a schema for FooTask

*Solution:* 

   * Create a 'tests' directory.
   * populate said directory with simple example xml files.
   * Name those files `valid-foo.xml` or `invalid-bar.xml` (I use numbers for foo and bar).
   * Create your xsd file in the same directory as 'tests'. Lets call it `foo.xsd`
   *  Copy the following Makefile into the same location.

[cc lang="bash"]
XSD=foo.xsd
# run xmlstarlet with -e to see verbose error.

test:
	@for file in `ls -1 tests/valid*.xml`; do if xmlstarlet val -q --xsd ${XSD} $${file}; then echo "pass"; else echo "fail: $${file}"; fi; done
	@for file in `ls -1 tests/invalid*.xml`; do if ! xmlstarlet val -q --xsd ${XSD} $${file}; then echo "pass"; else echo "fail: $${file}"; fi; done
[/cc]

Now, run make, and if anything fails you can manually run `xmlstarlet val -e --xsd foo.xsh [failing file.xml]` to see the details.
