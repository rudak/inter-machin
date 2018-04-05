var dataPoints = [];
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    axisY: {
        title: "Mon argent",
        valueFormatString: "#0,,.",
        suffix: "mn",
        prefix: "$"
    },
    data: [{
        type: "spline",
        markerSize: 5,
        xValueFormatString: "DD/MM/YY",
        yValueFormatString: "$#,##0.##",
        xValueType: "dateTime",
        dataPoints: dataPoints
    }]
});
function addData(data) {
    for (var i = 0; i < data.length; i++) {
        dataPoints.push({
            x: new Date(data[i][0]*1000),
            y: data[i][1]
        });
    }
    chart.render();
}
$.ajax({
    dataType: "json",
    url: api_bank_data_index_url,
    success: addData
});



