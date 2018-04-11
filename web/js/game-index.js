var oneTenData = [];
var chart = new CanvasJS.Chart("chartOneTen", {
    animationEnabled: true,
    title: {
        text: "Stats du OneTen ",
        horizontalAlign: "center"
    },
    data: [{
        type: "doughnut",
        startAngle: 90,
        innerRadius: 70,
        indexLabelFontSize: 12,
        dataPoints: oneTenData
    }
    ]
});

window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('game_oneTenData', {}, true),
        success: function (data) {
            var sommeGains = parseInt(data[0].total_gain) + parseInt(data[0].total_amount);
            var sommeEssais = parseInt(data[0].total_win) + parseInt(data[0].total);
            oneTenData.push({y: (parseInt(data[0].total_amount) * 100) / sommeGains, label: 'argent misé'});
            oneTenData.push({y: (parseInt(data[0].total_gain) * 100) / sommeGains, label: 'argent gagné'});
            oneTenData.push({y: (parseInt(data[0].total) * 100) / sommeEssais, label: 'Essais'});
            oneTenData.push({y: (parseInt(data[0].total_win) * 100) / sommeEssais, label: 'Gagné'});
            chart.render();
        }
    });
}