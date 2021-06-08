$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/?class=IndexController&function=login',
        data: data,
        type: "POST",
        success: function(response) {
            location.href = "/?class=IndexController&function=verToken";
        },
        error: function(error) {
            if (error['status'] === 513) {
                console.log("Usuario o contraseña incorrectos");
            }else{
                console.log(error);
            }
        }
    });
});