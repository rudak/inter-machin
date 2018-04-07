var dataPoints = [];
var chartMoney = new CanvasJS.Chart("chartContainerUsersMoney", {
    title:{
        text: "Distribution de l'argent en jeu"
    },
    animationEnabled: true,
    data: [{
        type: "pie",
        yValueFormatString: "#,##0 $",
        indexLabel: "{label} ({y})",
        dataPoints: dataPoints
    }]
});
function addDataMoney(data) {
    for (var i = 0; i < data.length; i++) {
        dataPoints.push({
            "label": data[i]['name'],
            "y": data[i]['money']
        });
    }
    chartMoney.render();
}
$.ajax({
    dataType: "json",
    url: api_users_money_data_index_url,
    success: addDataMoney
});

var dataPointsPurchases = [];
var chartPurchases = new CanvasJS.Chart("chartContainerPurchases", {
    title:{
        text: "Nombre d'achat par armes"
    },
    animationEnabled: true,
    data: [{
        type: "column",
        dataPoints: dataPointsPurchases
    }]
});
function addDataPurchases(data) {
    console.log(data);
    for (var i = 0; i < data.length; i++) {
        dataPointsPurchases.push({
            "label": data[i][0],
            "y": data[i][1]
        });
    }
    chartPurchases.render();
}
$.ajax({
    dataType: "json",
    url: api_purchases_data_index_url,
    success: addDataPurchases
});



