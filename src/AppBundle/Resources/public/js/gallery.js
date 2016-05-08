$(document).ready(function(){
    
    // Mandatory one checkbox checked ******************************************
    // and only one checkbox ticked at a time when selecting primary photo        
    $("input[type='checkbox']").on("click", function(){  
        $(this).attr("checked", "checked");
        $(this).prop("checked", true); 
        $(this).val(1);
        
        $("input[type='checkbox']").not(this).prop("checked", false);               
        $("input[type='checkbox']").not(this).removeAttr("checked");               
        $("input[type='checkbox']").not(this).val(0);               

        // Put back original border css and add "highlight" css for selected photo
        $("input[type='checkbox']").not(this).closest(".photo-actions").prev(".photo-frame").find(".primary").css("opacity", "0");                
        $(this).closest(".photo-actions").prev(".photo-frame").find(".primary").css("opacity", "1");               
    });
    
    // Highlight selected photo at doc ready ***********************************
    $("input[type='checkbox']:checked").closest(".photo-actions").prev(".photo-frame").find(".primary").css("opacity", "1");
    
    // Adjust photo-frame height for existing photos and "add photo" ***********
    var width = $(".photo-frame").width();
    $(".photo-frame").height(width);
    $("a.add-photo").height(width);

    // Adjust photo placement with ratio at doc ready **************************
    $("#photo-list .photo-frame").find("img").each(function(){
        var imgClass = (this.width/this.height > 1) ? 'wide' : 'tall';
        $(this).addClass(imgClass);
    });
    
    // Colorbox for full sized image *******************************************
    $("a.gallery").colorbox({
        maxHeight: "90%",
        maxWidth: "90%",
        onLoad: function(){
            $('#cboxClose').html('&times;'); // Replace the close button
        }
    });
});

