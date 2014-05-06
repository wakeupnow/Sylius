var $productPricesCollectionHolder;

jQuery(document).ready(function() {

    // Get the ul that holds the collection of tags
    $productPricesCollectionHolder = $('#product-multi-prices');

    if ($productPricesCollectionHolder.length) {

        // setup an "add a tag" link
        var $addTagLink = $('#product-multi-prices-add-link');
        var $newLinkDiv = $addTagLink.parent('div');

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $productPricesCollectionHolder.data('index', $productPricesCollectionHolder.find(':input').length);

        $addTagLink.on('click', function(e) {

            // add a new tag form (see next code block)
            addProductPricesCollectionItemForm($productPricesCollectionHolder, $newLinkDiv);
        });
    }
});

function addProductPricesCollectionItemForm($collectionHolder, $newLinkDiv) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div style="width:100%; border-bottom:1px solid gray; padding:15px 0;"></div>').append(newForm);
    $newLinkDiv.before($newFormLi);
}