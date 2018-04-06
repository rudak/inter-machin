var dataPoints = [];
var chart = new CanvasJS.Chart("chartContainerUsersMoney", {
    animationEnabled: true,
    axisY: {
        title: "Répartition de l'argent",
        valueFormatString: "#0,,.",
        suffix: "mn",
        prefix: "$"
    },
    data: [{
        type: "pie",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: dataPoints
    }]
});
function addData(data) {
    for (var i = 0; i < data.length; i++) {
        dataPoints.push({
            "label": data[i]['name'],
            "y": data[i]['money']
        });
    }
    chart.render();
}
$.ajax({
    dataType: "json",
    url: api_users_money_data_index_url,
    success: addData
});



