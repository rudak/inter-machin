/**
 *      CHART CAMEMBERT MONEY
 **/
var dataPoints = [];
var chartMoney = new CanvasJS.Chart("chartContainerUsersMoney", {
    title: {
        text: "Distribution de l'argent en jeu"
    },
    animationEnabled: true,
    animationDuration: 300,
    height: 400,
    data: [{
        type: "pie",
        yValueFormatString: "#,##0 $",
        indexLabel: "{label} ({y})",
        dataPoints: dataPoints
    }]
});

function addDataMoney(data) {
    for (var i in data) {
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
    animationDuration: 500,
    height: 400,
    data: [{
        type: "column",
        dataPoints: dataPointsPurchases
    }]
});

function addDataPurchases(data) {
    for (var i in data) {
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
    animationDuration: 300,
    zoomEnabled: true,
    height: 400,
    data: dataUsersAccounts
});

function getUserAccounts(userData) {
    var userAccount = [];
    for (var i in userData) {
        userAccount.push({
            x: new Date(userData[i]['date'] * 1000),
            y: userData[i]['money']
        })
    }
    return userAccount;
}

function addDataAccounts(data) {
    $.each(data, function (username, userData) {
        dataUsersAccounts.push({
            type: "line",
            axisYType: "secondary",
            name: username,
            showInLegend: true,
            markerSize: 2,
            yValueFormatString: "###$",
            dataPoints: getUserAccounts(userData)
        })
    });
    chartAccounts.render();
}

/**
 *      CHART LEVELS ACCOUNTS
 **/
var dataLevelsAccounts = [];
var chartLevels = new CanvasJS.Chart("chartContainerLevels", {
    title: {
        text: "Evolution des levels"
    },
    toolTip: {
        shared: true
    },
    animationEnabled: true,
    animationDuration: 300,
    zoomEnabled: true,
    height: 400,
    data: dataLevelsAccounts
});

function addLevelsAccounts(dataLevels) {

    $.each(dataLevels, function (username, data) {

        var userLevel = [];
        for (var i in data) {
            userLevel.push({
                x: new Date(data[i]['date'] * 1000),
                y: data[i]['level']
            })
        }
        dataLevelsAccounts.push({
            type: "stepLine",
            name: username,
            showInLegend: true,
            markerSize: 0,
            yValueFormatString: "Niveau ###",
            dataPoints: userLevel
        })
    })
    chartLevels.render();
}

/**
 *      AJAX LAUNCHES
 **/
window.onload = function () {
    requests = [
        {route: 'purchase_data', callback: addDataPurchases},
        {route: 'users_money_data', callback: addDataMoney},
        {route: 'bank_users_accounts', callback: addDataAccounts},
        {route: 'users_level_data', callback: addLevelsAccounts}
    ];
    for (var i in requests) {
        $.ajax({
            dataType: "json",
            url: Routing.generate(requests[i].route),
            success: requests[i].callback
        });
    }
}


