function sendNotifications(notifications) {
    var n = [];
    var j = 0;
    for (var i in notifications) {
        n[i] = new Noty({
            type: 'success',
            layout: 'topRight',
            theme: 'bootstrap-v4',
            dismissQueue: 'billy',
            maxVisible: 3,
            modal: true,
            buttons: true,
            text: notifications[i].title.toUpperCase() + ' - ' + notifications[i].message,
        });
    }
    var notyInterval;

    notyInterval = setInterval(function () {
        if (typeof n[j] === 'undefined') {
            clearInterval(notyInterval);
        } else {
            n[j].show();
        }
        j++;
    }, 250);
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