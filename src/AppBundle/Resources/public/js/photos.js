var collectionHolder;
        
var addPhotoLink = $('<a href="#" class="add-photo">Add photo</a>');
var newLiAddPhoto = $('<li class="col-md-4"></li>').append(addPhotoLink);

$(document).ready(function(){
    collectionHolder = $('#photo-list');
        
    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addPhotoFormDeleteLink($(this));
    });

    $('#photo-list .row').last().append(newLiAddPhoto); // Append to last row of collectionHolder

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(":input[type='file']").length);

    addPhotoLink.on('click', function(e) {            
        e.preventDefault();  
        
        var index = collectionHolder.data('index');

        // add a new Photo form (see next code block)
        if (index < 5) {
            addPhotoForm(collectionHolder, newLiAddPhoto);
            $("#appbundle_prospect_photos_" + (index - 1));
        }
    });
});

function addPhotoForm(collectionHolder, newLiAddPhoto)
{
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');
    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a photo" link li
    var photoFrame = "<div class='photo-frame'><img class='tall' src='/bundles/app/images/prospect_no_photo.jpg' alt='No photo' /></div>";
    var photoActions = "<div class='photo-actions'><div class='row'><div class='col-md-8'>"+ newForm +"</div><div class='col-md-4 delete-photo'></div></div></div>";
    
    var newFormLi = $("<li class='col-md-4 new-form'>" + photoFrame + photoActions + "</li>");
    
    newLiAddPhoto.before(newFormLi);

    addPhotoFormDeleteLinkWithIndexChange(newFormLi, collectionHolder);
}    

function addPhotoFormDeleteLink(photoFormLi)
{
    var removeForm =  $("<a href='#'><i class='fa fa-trash-o'></i></a>");
    photoFormLi.find('.photo-actions .delete-photo').append(removeForm);

    removeForm.click(function(event){
        event.preventDefault();        
                
        photoFormLi.remove();
    });
}

function addPhotoFormDeleteLinkWithIndexChange(photoFormLi, collectionHolder)
{
    var removeForm =  $("<a href='#'><i class='fa fa-trash-o'></i></a>");
    photoFormLi.find('.photo-actions .delete-photo').append(removeForm);

    removeForm.click({collectionHolder: collectionHolder}, function(event){
        event.preventDefault();
        
        collectionHolder = event.data.collectionHolder;
        // get the new index
        var index = collectionHolder.data('index');
        
        photoFormLi.remove();
        collectionHolder.data('index', index-1);
    });
}