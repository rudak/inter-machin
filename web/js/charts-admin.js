/**
 *      CHART CAMEMBERT MONEY
 **/
var dataPoints = [];
var chartMoney = new CanvasJS.Chart("chartContainerUsersMoney", {
    title: {
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

/**
 *      CHART ACHATS ARMES
 **/
var dataPointsPurchases = [];
var chartPurchases = new CanvasJS.Chart("chartContainerPurchases", {
    title: {
        text: "Nombre d'achat par armes"
    },
    animationEnabled: true,
    data: [{
        type: "column",
        dataPoints: dataPointsPurchases
    }]
});
function addDataPurchases(data) {
    for (var i = 0; i < data.length; i++) {
        dataPointsPurchases.push({
            "label": data[i][0],
            "y": data[i][1]
        });
    }
    chartPurchases.render();
}


/**
 *      CHART USERS ACCOUNTS
 **/
var dataUsersAccounts = [];
var chartAccounts = new CanvasJS.Chart("chartContainerAccounts", {
    title: {
        text: "Récap des accounts"
    },
    toolTip: {
        shared: true
    },
    animationEnabled: true,
    data: dataUsersAccounts
});
function addDataAccounts(data) {
    $.each(data, function (index, value) {
        dataUsersAccounts.push({
            type: "line",
            axisYType: "secondary",
            name: index,
            showInLegend: true,
            markerSize: 0,
            yValueFormatString: "###$",
            dataPoints: getUserAccounts(value)
        })
    });
    chartAccounts.render();
}

function getUserAccounts(value) {
    var userAccount = [];
    $.each(value, function (index2, value2) {
        var date = new Date(value2['date'] * 1000);
        userAccount.push({
            x: date,
            y: value2['money']
        })
    })
    return userAccount;
}
window.onload = function () {
    $.ajax({
        dataType: "json",
        url: Routing.generate('purchase_data', {}),
        success: addDataPurchases
    });
    $.ajax({
        dataType: "json",
        url: Routing.generate('users_money_data', {}),
        success: addDataMoney
    });
    $.ajax({
        dataType: "json",
        url: Routing.generate('bank_users_accounts', {}),
        success: addDataAccounts
    });
}


