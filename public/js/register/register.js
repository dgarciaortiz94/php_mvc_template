$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/userRegister',
        data: data,
        type: "POST",
        success: function(response) {
            location.href="/";
        },
        error: function(error) {
            $(".failMessage").remove();

            let message;

            if (error['status'] === 514) {
                message = "Las contraseñas deben coincidir";
            }else if (error['status'] === 515){
                console.log(error);
            }else if (error['status'] === 516){
                console.log(error);
            }else if (error['status'] === 517){
                message = "Este usuario ya existe";
            }else if (error['status'] === 518){
                errorText = error["statusText"];

                if (errorText == "There are empty fields") {
                    message = "Hay campos vacios";
                }else{
                    message = "Email no válido";
                }
            }
            else{
                console.log(error);
            }

            $("input[name='username']").before("<p class='failMessage'>" + message + "</p>");

            $(".failMessage").animate({opacity: '1'}, "fast");
        }
    });
});