# Sprout Identity
A package that helps you determine the identity of objects in an array. The Sprout Framework almost exclusively works with arrays of objects and it wants / needs to have an unique handle for each object, as well as a "group identity" readily available at all times.

## Use Cases

#### You generate output from a lot of objects, but instead of doing it on every request, you just get that output from the database.
You have about 50-60 objects, for example, our `SuggestionsModule` allows developers to register their own suggestions to be made to whoever is using a theme. Each suggestion has to do a few checks which might be heavy or not, then generate output. Imagine if this happens on a shared server, on every request. As you can see, this module will initially compute the identity of the said collection of objects, keep track of it, re-compute it on every request **but never** re-execute the heavy code.

If it detectes that a new object was added to the collection, it re-builds both the indentity and it lets the code run.

This works amazing with our other module, `SproutCache`.
