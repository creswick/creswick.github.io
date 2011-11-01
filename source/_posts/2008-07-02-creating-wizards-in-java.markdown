--- 
layout: post
title: Creating Wizards in Java
categories: java
---
A recent project at work required building a multi-step dialog to manage the interface between a user and an expert system (and some fairly advanced NLP to boot).  On the surface this looked like a fairly standard Wizard problem -- design a bunch of screens with questions, and then collect the answers as the user proceeded through the dialogs.  However, the Wizard APIs I found were either not very mature or (in the case of the <a href="http://wizard.dev.java.net">Java.net Wizards</a>) it was very difficult to create complex branching behaviors, and those branches were extremely resistant to change.  Both things are essentially show-stoppers when working with prototypes that frequently need modification.

In the end, I spent a weekend and a couple evenings building a new Wizard API for Java, called <a href="http://code.google.com/p/cjwizard">CJWizard</a>.  The library is released under the Apache V.2 license, so it should work for just about anything you want to use it for.  I would like to know if you're using it, and what you're using it for, just to sate my own curiosity :).  The project is hosted on code.google.com, so please submit issues, and feel free to contribute to the project.

<a href="http://code.google.com/p/cjwizard">CJWizard</a> provides the structure needed to quickly create simple dialogs by implementing an abstract class (WizardPage) for each page of the dialog, and adding them to a PageFactory that can generate pages on-demand, as they are required.  This puts the programmer in full control of how the wizard proceeds.  The CJWizard architecture also makes it easy to add a wizard to an existing application (either via an additional JDialog, or embedding in some other component), and/or insert custom wrapper widgets around the dialog pages--meaning that you can quickly add customized navigational controls aside from the standard Previous/Next/Finish/Cancel buttons.

Some aspects were taken from the Java.Net wizard API, such as auto-detecting named components, and automatically collecting the values from them, but CJWizard takes a much simpler approach (and in some ways, a less powerful one -- CJWizard does not listen to every key event, only collecting values when the user navigates away from a WizardPage). In most cases, you only need to name widgets prior to adding them to the WizardPage, and their values will be collected in a settings map automatically.

CJWizard was meant to provide a flexible way to generate professional-looking multi-step dialogs very quickly.
