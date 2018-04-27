var dataMoney = [];
var dataLoan = [];
var dataLevel = [];
var dataDead = [];

function render() {

    var options = {
        animationEnabled: true,
        animationDuration: 300,
        zoomEnabled: true,
        theme: "light2",
        axisX: {
            stripLines: dataDead
        },
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
    var accountsData = data['accountsData'];
    for (var i = 0; i < accountsData.length; i++) {
        var date = new Date(accountsData[i]['date'] * 1000);
        dataMoney.push({
            x: date,
            y: accountsData[i]['money']
        });
        dataLoan.push({
            x: date,
            y: accountsData[i]['loan']
        });
        dataLevel.push({
            x: date,
            y: accountsData[i]['level']
        });
    }
    var deathData = data['deadData'];
    for (var j = 0; j < deathData.length; j++) {
        dataDead.push({
            value: new Date(deathData[j]['date'] * 1000),
            color: deathData[j]['state'] == 0 ? "#000" : "#FF00FF",
            label: deathData[j]['state'] == 0 ? "Mort" : "Vie",
            labelFontColor: "#000"
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
