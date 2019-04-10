This is an example module showing how to retrieve and render the current product on a
product detail page in Magento without referencing deprecated code like the global registry.
 
# Process

1. The product is loaded by `\Magento\Catalog\Helper\Product::initProduct`.
   This method dispatches the event `catalog_controller_product_init_after`.
   
2. In the event observer `RegisterCurrentProductObserver` the product is set on a shared instance of
   the class `\VinaiKopp\CurrentProductExample\Registry\CurrentProduct`.
   
3. A new template block is added to the product detail page with layout XML.
   In the XML the block is configured to receive a view model:
   an instance of the class `\VinaiKopp\CurrentProductExample\ViewModel\CurrentProductExampleViewModel`.
   
4. The view model uses the shared `Registry\CurrentProduct` instance to
   retrieve the current product. This makes it a registry but without
   the downsides of the global core registry.
   
5. The template retrieves the view model from the block and renderrs the required product details.


# Questions and Notes:

## Why an event observer and not a plugin?

instead of an event observer, the current product also could have been set
on the `CurrentProduct` instance with a plugin. But since `\Magento\Catalog\Helper\Product::initProduct` is not
blessed with the `@api` annotation, a plugin would add a patch level dependency on the catalog module.
By using the event only a major version dependency is created. 

## Isn't there an easier way?

Sure, just use deprecated code - it probably will continue to work for years to come.

## Why not use `Registry\CurrentProduct` directly as the view model?

This doesn't work because all object block arguments are newly instantiated.
Shared instances can not be used as block arguments. This makes it impossible to
use the object to pass data from the event into the view model, because the new instance
does not have the product set on it.
The only way to hack around this I'm aware of would be to use a static property, but
then we might as well use a global variable alreay...

## Is this the right way to access the current product?

No, this is just an example how to do it without accessing deprecated code.
The right way to do it depends on many factors.

## I access the current product differently!

Great!
