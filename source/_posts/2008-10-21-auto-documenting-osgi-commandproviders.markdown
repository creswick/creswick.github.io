--- 
layout: post
title: Auto-documenting OSGi CommandProviders
categories: eclipse
---
(**Edit:** If you're reading this after OSGi R4.2, then there is almost certainly a better way to accomplish the same thing)

I've been digging into OSGi a bit over the last week or so inorder to
create some Eclipse plugins that will automatically discover
eachother, and I've been generally impressed with the framework on the
whole.  The documentation is a bit lacking, but there are some good
blog posts about it.  (Specifically [Neil Bartlett's introduction to
OSGi][intro].)

One thing that bugged me is the repetition needed when you implement
the CommandProvider interface to add commands to the OSGi console.
CommandProvider defines one method you must supply:

[cc lang="java"]
    public String getHelp()
[/cc]

OSGi then uses reflection to extract each of the methods that starts
with an underscore, and supplies those methods to the command environment as
new commands.  (The underscore is trimmed, and the name of the method becomes
the command name.)  General practice is to include the name of the
method in the return value of `getHelp()`, along with a description of
what the method does, eg:


[cc lang="java"]
public class SampleCommandProvider implements CommandProvider {

   public synchronized void _run(CommandInterpreter ci) {
      // do stuff.
   }
        
   public String getHelp() {
      return "\trun - execute a Runnable service";
   }
}[/cc]

This seems like a pain to maintain, so I took a quick look at
annotations, and propose a new syntax:

[cc lang="java"]
public class SampleCommandProvider extends
   DescriptiveCommandProvider {

   @CmdDescr(description="execute a Runnable service")
   public synchronized void _run(CommandInterpreter ci) {
      // do stuff.
   }
}[/cc]

Here we've extracted the `getHelp()` method into a new superclass, so
our SampleCommandProvider now extends an abstract class instead of
implementing an interface.  It also makes use of an Annotation, which
we need to define:

[cc lang="java"]
import java.lang.annotation.ElementType;
import java.lang.annotation.Retention;
import java.lang.annotation.RetentionPolicy;
import java.lang.annotation.Target;
    
@Retention(RetentionPolicy.RUNTIME)
@Target(ElementType.METHOD)
public @interface CmdDescr {
   String description();
}[/cc]

Finally, we just need to define the superclass that implements
`getHelp()`:

[cc lang="java"]
import java.lang.reflect.Method;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.eclipse.osgi.framework.console.CommandProvider;

public abstract class DescriptiveCommandProvider implements CommandProvider {
   
   private static final Pattern CMD_PATTERN = Pattern.compile("^_(.*)");
   private String help = null;
   
   public String getHelp() {
      if (null == help){
         help = buildHelp();
      }
      return help;
   }

   private String buildHelp() {
      StringBuilder helpBuff = new StringBuilder();
      
      for (Method m : this.getClass().getMethods()){
         if (methodIsCmd(m)){         
            if (0 != helpBuff.length()){
               helpBuff.append("\n");
            }
            helpBuff.append(getDocumentation(m));            
         }
      }
      return helpBuff.toString();
   }

   private boolean methodIsCmd(Method m) {
      return CMD_PATTERN.matcher(m.getName()).matches();
   }

   private String getDocumentation(Method m) {
      StringBuilder methodHelp = new StringBuilder();
      
      Matcher matcher = CMD_PATTERN.matcher(m.getName());
      if(matcher.matches()){
         methodHelp.append("\t"+matcher.group(1));
         
         CmdDescr description = m.getAnnotation(CmdDescr.class);
         
         if (null != description){
            methodHelp.append(" - "+description.description());
         }
      }
      return methodHelp.toString();
   }
}
[/cc]

Note that the actual reflection on the class only happens once -- all
subsequent calls to `getHelp()` use a cached copy of the documentation.

   [intro]: http://neilbartlett.name/blog/osgi-articles/<u style=display:none>
