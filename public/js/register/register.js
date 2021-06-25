$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/userRegister',
        data: data,
        type: "POST",
        dataType: "json",
        success: function(response) {
            $(".failMessage").remove();

            if (response['status'] === true) location.href = "/perfil";
            else {
                $("input[name='username']").before("<p class='failMessage'>" + response['response'] + "</p>");
                $(".failMessage").animate({opacity: '1'}, "fast");
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});