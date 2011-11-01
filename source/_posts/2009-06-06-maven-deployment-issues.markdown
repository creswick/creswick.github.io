--- 
layout: post
title: Maven deployment issues
categories: tech
---
I've been building / porting various projects to maven lately, and pushing them to our in-house maven server.  For a while, I was doing this from my laptop at home.  However, at work, I'm pushing to localhost (it's a temporary thing while we determine if maven will actually work long-term.) 

The following error had me stumped for a few days:
[cc lang="bash"]
[INFO] Error retrieving previous build number for artifact 'de.balokb:libreadline-java-i386-Linux-c23cxx6:jar': repository metadata for: 'snapshot de.balokb:libreadline-java-i386-Linux-c23cxx6:1.0-SNAPSHOT' could not be retrieved from repository: inhouse_snapshot due to an error: Exit code: 1 - Host key verification failed.
[/cc]

All the googling I did turned up people stumped with ssh public key problems, or users who had specified ssh: instead of extssh: ... etc.  It was fairly quick to elleminate those issues, or so I thought.  (`ssh localhost` right? No problem.)

I happened to look in more detail at my pom.xml:
[cc lang="xml"]

    <repository>
      <id>inhouse</id>
      <name>Inhouse Internal Release Repository</name>
      <url>scpexe://10.0.0.26/var/www/maven/inhouse</url>
    </repository>
[/cc]

hm... `10.0.0.26` I wonder... 

[cc]
$ ssh 10.0.0.26
The authenticity of host '10.0.0.26 (10.0.0.26)' can't be established.
RSA key fingerprint is a7:bf:36:4c:b9:c7:c2:f9:03:9a:3a:a7:4f:10:e5:ba.
Are you sure you want to continue connecting (yes/no)?
[/cc]

Ah ha!  I clearly can't use a pom.xml that lists "localhost" in the server section -- I'd only be able to push from one place.  However, since I'd never ssh'd to `10.0.0.26` from localhost, the fingerprint was unknown, and that was causing maven to error out with the problem I saw initially.

"Fingerprint ID failed" would have been a nicer error message, but I don'tk now that that is possible.
