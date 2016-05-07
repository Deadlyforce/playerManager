$(document).ready(function(){
    // Colorbox for full sized image *******************************************
    $("a.gallery").colorbox({
        maxHeight: "90%",
        maxWidth: "90%",
        onLoad: function(){
            $('#cboxClose').html('&times;'); // Replace the close button
        }
    });
});

