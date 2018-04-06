var dataMoney = [];
var dataLoan = [];

function render() {

    var options = {
        animationEnabled: true,
        theme: "light2",
        axisY: {
            title: "Argent",
            valueFormatString: "#0",
            suffix: "$",
        },
        legend: {
            cursor: "pointer",
            itemclick: toogleDataSeries
        },
        toolTip: {
            shared: true
        },
        data: [{
            type: "area",
            name: "Money",
            markerSize: 5,
            showInLegend: true,
            xValueFormatString: "DD/MM/YY",
            yValueFormatString: "#$",
            xValueType: "dateTime",
            dataPoints: dataMoney
        }, {
            type: "area",
            name: "Emprunt",
            markerSize: 5,
            showInLegend: true,
            yValueFormatString: "#$",
            dataPoints: dataLoan
        }]
    };
    $("#chartContainer").CanvasJSChart(options);

    function toogleDataSeries(e) {
        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        e.chart.render();
    }

}
function addData(data) {
    for (var i = 0; i < data.length; i++) {
        dataMoney.push({
            x: new Date(data[i]['date'] * 1000),
            y: data[i]['money']
        });
        dataLoan.push({
            x: new Date(data[i]['date'] * 1000),
            y: data[i]['loan']
        });
    }
    render();
}
window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('bank_index_data', {}, true),
        success: addData
    });
}
