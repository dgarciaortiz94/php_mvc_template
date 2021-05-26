$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/userLogin',
        data: data,
        type: "POST",
        success: function(response) {
            location.href = "/";
        },
        error: function(error) {
            let message;

            if (error['status'] === 513) {
                message = "Usuario o contraseña incorrectos";
            }else if (error['status'] == 518){
                message = "Hay campos vacios";
            }
            else{
                console.log(error);
            }

            $(".failMessage").remove();

            $("input[name='username']").before("<p class='failMessage'>" + message + "</p>");

            $(".failMessage").animate({opacity: '1'}, "fast");
        }
    });
});