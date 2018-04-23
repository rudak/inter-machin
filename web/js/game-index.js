/**
 * ONETEN GRAPH
 * @type {Array}
 */
var oneTenData = [];
var oneTenChart = new CanvasJS.Chart("chartOneTen", {
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

function oneTenHandler(data) {
    oneTenData.push({y: parseInt(data[0].total) - parseInt(data[0].total_win), label: 'Perdu'});
    oneTenData.push({y: parseInt(data[0].total_win), label: 'Gagné'});
    oneTenChart.render();
}

/**
 * DICES GRAPH
 * @type {Array}
 */
var DicesData = [];
var DicesChart = new CanvasJS.Chart("chartDices", {
    animationEnabled: true,
    title: {
        text: "Stats du Dices",
        horizontalAlign: "center"
    },
    data: [{
        type: "doughnut",
        startAngle: 90,
        innerRadius: 70,
        indexLabelFontSize: 12,
        dataPoints: DicesData,
    }]
});

function dicesHandler(data) {
    DicesData.push({y: parseInt(data[0].total) - parseInt(data[0].total_win), label: 'Perdu'});
    DicesData.push({y: parseInt(data[0].total_win), label: 'Gagné'});
    DicesChart.render();
}

window.onload = function () {
    requests = [
        {route: 'game_oneTenData', callback: oneTenHandler},
        {route: 'game_DicesData', callback: dicesHandler},
    ];
    for (var i in requests) {
        $.ajax({
            dataType: "json",
            url: Routing.generate(requests[i].route),
            success: requests[i].callback
        });
    }
}