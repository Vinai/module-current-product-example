This is an example module showing how to retrieve and render the current product on a
product detail page in Magento without referencing deprecated code like the global registry.
 
# Process

The product instance takes the following path until it reaches the template:  

`Product Helper -> Event -> Observer -> Custom Registry Object -> View Model -> Template`


1. The product is loaded by `\Magento\Catalog\Helper\Product::initProduct`.
   This method dispatches the event `catalog_controller_product_init_after`.
   
2. In the event observer `RegisterCurrentProductObserver` the product is set on a shared instance of
   the class `\VinaiKopp\CurrentProductExample\Registry\CurrentProduct`.
   
3. A new template block is added to the product detail page with layout XML.
   In the XML the block is configured to receive a view model,
   an instance of the class `\VinaiKopp\CurrentProductExample\ViewModel\CurrentProductExampleViewModel`.
   
4. The view model uses the shared `Registry\CurrentProduct` instance to
   retrieve the current product. This makes it a registry but without
   the downsides of the global core registry.
   
5. The template retrieves the view model from the block and renders the required product values.


# Questions and Notes:

## Why an event observer and not a plugin?

Instead of an event observer, the current product also could have been set
on the `CurrentProduct` instance with a plugin. But since `\Magento\Catalog\Helper\Product::initProduct` is not
blessed with the `@api` annotation, a plugin would add a patch level dependency on the catalog module.
By using the event only a major version dependency is created. 


## Isn't relying on an event fragile?

Events are part of the stable Magento API. According to the
[Magento backward compatible development guidelines](https://devdocs.magento.com/guides/v2.3/contributor-guide/backward-compatible-development/) removing or renaming an event
requires a major version bump of the package.  
When relying on core code we can't get more stable than that, since with a major version
bump anything could change.

For example, HTTP query variable names are not covered, so relying on getting
the current product ID that way and loading it ourselves should probably be
considered less stable. The query variable name might be changed in a patch release.


## What are the benefits of a custom registry object over the core registry?

* No potential key name clashes in the global registry namespace
* A custom registry object makes it easy to track where a value is set and where it is used.
  The core registry is like a global variable in that regard - hard to track what is going on.
* Expressiveness - the class name `CurrentProduct` is more descriptive about what it contains 
  compared to a generic class name like `Registry`.
* The core registry was deprecated in Magento 2.3


## Isn't there an easier way?

Sure, just use deprecated code - it probably will continue to work for years to come.


## Why not use `Registry\CurrentProduct` directly as the view model?

That would be nice, but this doesn't work for Magento versions under 2.3.2, because all object block arguments
are newly instantiated. They are not shared instances (via `ObjectManager::get()`).
This makes it impossible to use the view model directly, as the custom registry object
only works because it is a shared instance.
If we tried, a new `CurrentProduct` instance would be passed to the block class,
and it wouldn't contain the current product value which would have been set on the different 
shared instance of the class.
The only way to hack around this I'm aware of would be to use a static property, but
then we might as well use a global variable already...


## Is this the right way to access the current product?

No, this is just an example how to do it without accessing deprecated code.
The right way to do it depends on many factors.


## I access the current product differently!

Great!
