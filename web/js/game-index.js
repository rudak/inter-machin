var oneTenData = [];
var chart = new CanvasJS.Chart("chartOneTen", {
    animationEnabled: true,
    title: {
        text: "Stats du OneTen",
        horizontalAlign: "center"
    },
    data: [{
        type: "doughnut",
        startAngle: 90,
        innerRadius: 70,
        indexLabelFontSize: 12,
        dataPoints: oneTenData,
    }]
});

window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('game_oneTenData', {}, true),
        success: function (data) {
            oneTenData.push({y: parseInt(data[0].total) - parseInt(data[0].total_win), label: 'Perdu'});
            oneTenData.push({y: parseInt(data[0].total_win), label: 'Gagné'});
            chart.render();
        }
    });
}