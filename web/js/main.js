function sendNotifications(notifications) {
    for (var i in notifications) {
        new Noty({
            type: 'warning',
            layout: 'topRight',
            theme: 'bootstrap-v4',
            text: notifications[i].title.toUpperCase() + ' - ' + notifications[i].message,
        }).show();
    }
}

$(function () {

    $.ajax({
        dataType: "json",
        url: Routing.generate('getMyNotifications'),
        success: function (data) {
            if (!data.status) {
                return;
            }
            sendNotifications(data.notifications);
        }
    });

})