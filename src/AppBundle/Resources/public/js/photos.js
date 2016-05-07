var collectionHolder;
       
var addPhotoLink = $('<a href="#" class="add-photo">Add photo</a>');
var newLiAddPhoto = $('<li class="col-md-4"></li>').append(addPhotoLink);


function addPhotoForm(collectionHolder, newLiAddPhoto, imgDir)
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
    var photoFrame = "<div class='photo-frame'><img class='tall' src='"+imgDir+"prospect_no_photo.jpg' alt='No photo' /></div>";
    var photoActions = "<div class='photo-actions'><div><div class='file-selector pull-left'>"+ newForm +"</div><div class='delete-photo pull-right'></div></div></div>";   
    
    var newFormLi = $("<li class='col-md-4 new-form'>" + photoFrame + photoActions + "</li>");
    
    newLiAddPhoto.before(newFormLi);

    addPhotoFormDeleteLinkWithIndexChange(newFormLi, collectionHolder);
}    

function addPhotoFormDeleteLink(photoFormLi)
{
    var removeForm =  $("<a href='#' title='Delete'><i class='icon ion-ios-trash-outline'></i></a>");
    photoFormLi.find('.photo-actions .delete-photo').append(removeForm);

    removeForm.click(function(event){
        event.preventDefault();        
                
        photoFormLi.remove();
    });
}

function addPhotoFormDeleteLinkWithIndexChange(photoFormLi, collectionHolder)
{
    var removeForm =  $("<a href='#' title='Delete'><i class='icon ion-ios-trash-outline'></i></a>");
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