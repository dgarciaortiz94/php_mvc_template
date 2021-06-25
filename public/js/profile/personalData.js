$("#send").click(function(e){
    e.preventDefault();

    let data = $("#form").serialize();

    $.ajax({
        url: '/perfil/updatePersonalData',
        data: data,
        type: "POST",
        success: function(response) {
            response = JSON.parse(response);

            $(".failMessage").remove();

            if (response['status'] === true) location.href = "/perfil";
            else {
                $("input[type='submit']").after("<p class='failMessage'>" + response['response'] + "</p>");
                $(".failMessage").animate({opacity: '1'}, "fast");
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});