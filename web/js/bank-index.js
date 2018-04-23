var dataMoney = [];
var dataLoan = [];
var dataLevel = [];

function render() {

    var options = {
        animationEnabled: true,
        theme: "light2",
        axisY: {
            title: "Argent",
            valueFormatString: "#0",
            suffix: "$",
        },
        axisY2: {
            title: "Niveau",
            titleFontColor: "#C0504E",
            lineColor: "#C0504E",
            labelFontColor: "#C0504E",
            tickColor: "#C0504E",
            includeZero: false,
            valueFormatString: "##",
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
            markerSize: 2,
            showInLegend: true,
            xValueFormatString: "DD/MM/YY",
            yValueFormatString: "#$",
            xValueType: "dateTime",
            dataPoints: dataMoney
        }, {
            type: "area",
            name: "Emprunt",
            markerSize: 2,
            showInLegend: true,
            yValueFormatString: "#$",
            dataPoints: dataLoan
        },
            {
                type: "line",
                name: "Niveau",
                markerSize: 2,
                axisYType: "secondary",
                showInLegend: true,
                dataPoints: dataLevel
            }
        ]
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
        var date = new Date(data[i]['date'] * 1000);
        dataMoney.push({
            x: date,
            y: data[i]['money']
        });
        dataLoan.push({
            x: date,
            y: data[i]['loan']
        });
        dataLevel.push({
            x: date,
            y: data[i]['level']
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
