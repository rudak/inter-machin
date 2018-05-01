var chart;

function formatData(resourceData) {
    var tab = [];
    for (var i = 0; i < resourceData.length; i++) {
        tab.push({
                x: new Date(resourceData[i].date), y: resourceData[i].value
            }
        );
    }
    return tab;
}

function toogleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    chart.render();
}

function addData(data) {

    var lines = [];
    for (var name in data) {
        lines.push({
            type: "spline",
            // axisYType: "secondary",
            name: name,
            showInLegend: true,
            markerSize: 0,
            // percentFormatString: "#0.##",
            toolTipContent: "{name} {y}%",
            dataPoints: formatData(data[name])
        });
    }
    // console.log(lines);
    // return;
    chart = new CanvasJS.Chart("chartContainer", {
        zoomEnabled: true,
        title: {
            text: "Évolution des ressources."
        },
        axisX: {
            valueFormatString: "DD/MM/YY"
        },
        axisY:{
            suffix: " %"
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            verticalAlign: "top",
            horizontalAlign: "center",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
        },
        data: lines
    });
    chart.render();
}

window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('resource_evolution_data', {}, true),
        success: addData
    });
}