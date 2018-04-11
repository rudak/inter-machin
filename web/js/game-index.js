window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('game_oneTenData', {}, true),
        success: function (data) {
            console.log(data);
        }
    });
}