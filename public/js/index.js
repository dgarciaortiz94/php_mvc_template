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
        error: function() {
        console.log("No se ha podido obtener la información");
        }
    });
});