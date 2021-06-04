$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/userRegister',
        data: data,
        type: "POST",
        success: function(response) {
            response = JSON.parse(response);

            $(".failMessage").remove();

            if (response['status'] === true) location.href = "/";
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