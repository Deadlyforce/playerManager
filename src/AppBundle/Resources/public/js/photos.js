var collectionHolder;
        
var addPhotoLink = $('<a href="#" class="add-photo">Add photo</a>');
var newLinkLi = $('<li class="col-md-4"></li>').append(addPhotoLink);

$(document).ready(function(){
    collectionHolder = $('#photo-list');
        
    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addPhotoFormDeleteLink($(this));
    });

    collectionHolder.append(newLinkLi);
//    collectionHolder.after(newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);

    addPhotoLink.on('click', function(e) {            
        e.preventDefault();       
        
        // add a new tag form (see next code block)
        addPhotoForm(collectionHolder, newLinkLi);
        $("#appbundle_prospect_photos_" + (collectionHolder.data('index') - 1));
    });
});

function addPhotoForm(collectionHolder, newLinkLi)
{
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');
    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var newFormLi = $("<li class='col-md-4'><div class='photo-frame'><img src='/bundles/app/images/prospect_no_photo.jpg' alt='No photo' /></div><div class='photo-actions'></div></li>").append(newForm);
    
    newLinkLi.before(newFormLi);

    addPhotoFormDeleteLinkWithIndexChange(newFormLi, collectionHolder);
}    

function addPhotoFormDeleteLink(photoFormLi)
{
    var removeForm =  $("<a href='#'>Delete photo</a>");
    photoFormLi.append(removeForm);

    removeForm.click(function(event){
        event.preventDefault();        
                
        photoFormLi.remove();
    });
}

function addPhotoFormDeleteLinkWithIndexChange(photoFormLi, collectionHolder)
{
    var removeForm =  $("<a href='#'>Delete photo</a>");
    photoFormLi.append(removeForm);

    removeForm.click({collectionHolder: collectionHolder}, function(event){
        event.preventDefault();
        
        collectionHolder = event.data.collectionHolder;
        // get the new index
        var index = collectionHolder.data('index');
        
        photoFormLi.remove();
        collectionHolder.data('index', index-1);
    });
}