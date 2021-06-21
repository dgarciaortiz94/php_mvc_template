let imageUrl = $("#profile-photo").css("background-image");


$("#profile-photo").click(function(){
    $("#modal-profile-image").css("background-image", imageUrl);
    $("#imageModal").css("display", "flex");

    
});

$("#closeImage").click(function(){
    $("#imageModal").css("display", "none");
    
});


$("#deleteImage").click(function(){
    $.ajax({
        url : '/profile/deletePhotoProfile',
        type : 'POST',
        dataType : 'json',
        success : function(response) {
            if (response["response"]) {
                location.href = "/perfil";
            } else{
                alert(response["message"]);
            }
        },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');
        }
    });
    
});




$("#editImage").click(function() {
    $("#file").trigger('click');
})

$("#file").change(function() {
    $("#updateForm").trigger('submit');
})

$("#updateForm").on("submit", function(e) {
    e.preventDefault();

    let file = document.getElementById("file");

    let formData = new FormData(document.getElementById("updateForm"));

    $.ajax({
        url : '/profile/updatePhotoProfile',
        data : formData,
        type : 'POST',
        success : function(response) {
            location.href = "/perfil";
        },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');
        },
        cache: false,
        contentType: false,
        processData: false
    });
})




$('.demo').croppie({
    url: "../../profiles/images/profiles/image-profile-default.jpg",
    viewport: { 
        width: 150, 
        height: 150, 
        type: 'circle' 
    },
    showZoomer: true
});
