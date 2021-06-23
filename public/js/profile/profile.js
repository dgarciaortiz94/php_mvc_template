let imageUrl = $("#profile-photo").css("background-image");
let finalImg;

var basic;

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

    $("#crudButtons").css("display", "none");

    $("#savePhotoProfile").css("display", "block");

    basic = $('#modal-profile-image').croppie({
        viewport: {
            width: 500,
            height: 500,
            type: 'circle'
        }
    });
})

$("#updateForm").on("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(document.getElementById("updateForm"));

    $.ajax({
        url : '/profile/updatePhotoProfile',
        data : formData,
        type : 'POST',
        dataType: "json",
        success : function(response) {
            basic.croppie('bind', {
                url: '/images/profiles/'+response["image"]
            });
        },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');
        },
        cache: false,
        contentType: false,
        processData: false
    });
})


$("#savePhotoProfile").click(function() {
    //on button click
    basic.croppie('result', {
        type: "blob",
        size: 'viewport',
    }).then(function(img) { 
        
        var data = new FormData();
        data.append('photo', img);

        $.ajax({
            url : '/profile/updatePhotoProfile',
            data: data,
            type : 'POST',
            dataType : 'json',
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
