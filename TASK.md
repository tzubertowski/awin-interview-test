Affiliate Window Candidate Task
===============================

### Objective

To demonstrate your OOP and unit testing skills.

### Task

Create a simple report that shows transactions for a merchant id specified as command line argument.

The data.csv file contains dummy data in different currencies, the report should be in GBP.

Assume that data changes and comes from a database, csv file is just for simplicity, 
feel free to replace with sqlite if that helps.

Please add code, unit tests and documentation (docblocks, comments). You do not need to connect to a real currency webservice, a dummy webservice client that returns random or static values is fine.

Provided code is just an indication, do not feel the need to use them if you don't want to. If something is not clear, improvise.

Use any 3rd party framework or components as you see fit. Please use composer where possible if depending on 3rd party code.

### Assessment

Your task will be assessed on your use of OOP, dependency injection, unit testing and commenting against the level of the position for which you have applied.

Points will be deducted for leaving any redundant files in your code (e.g. left overs from framework skeleton app creation).

The task itself is not complicated at first sight, but it matters very much to us HOW you do it. We want to see your best programming skills, regardless of how easy the task seems to you. You should be showcasing your best technical skills (not how fast you can come up with a working solution).

Below are some of the things that we like ( and/or don't like ):

* we love spagetti but only in our meals. separation of concerns and SOLID is the way to go
* we believe that an IOC container is a must in any php application nowadays. we like the dependency inversion principle, however, we hate it when only the service locator pattern is understood and implemented
* we love exceptions and good error handling in general
* we love the data mapper pattern and frown upon active record
* we prefer phpspec for unit tests ( but you will not get points deducted if you use phpunit for the unit tests if that's your preference )
* we love it when our candidates do the right thing and throw away our placeholder code
* we love the practical test pyramid, and we expect to see it ( it's okay if you only show us the bottom of the pyramid for this exercise, but it's not okay if you only show us the top of it )
* we like symfony ( but we don't mind if you show us your skills with another framework, or even your own take on a framework if you think it's worth the effort )
* we believe globals should never exist and that statics are evil. that being said, there's a bit of evil in most of us and we're fine with that ( think named constructors )
* we don't like it when the right mouse button is used too much. we know that London's weather is not the greatest most of the times, but we still love it DRY
* if you go with a DDD approach you get bonus cookie points. no DDD? that's fine, we think we know some things about it, and we can share them with you if you are hired
* we like coins more than bills when money are involved. we don't like it when money are floating around, otherwise they can't multiply properly!
* we love it when our candidates read and understand all the requirements, and don't just scan the first lines
