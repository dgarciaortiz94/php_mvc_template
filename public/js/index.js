$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/login',
        data: data,
        type: "POST",
        success: function(response) {
            location.href = "/vertoken";
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