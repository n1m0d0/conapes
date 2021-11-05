import Chart from "chart.js/auto";

var ctx = document.getElementById("estado");
if (ctx != null) {
    var estadistica = JSON.parse(ctx.getAttribute("data"));
    let estadisticaValues = [];
    let estadisticaLabels = [];
    estadistica.forEach((element) => {
        estadisticaValues.push(element.total);
        if (element.estado == 1) {
            estadisticaLabels.push("REGISTRADO");
        }
        if (element.estado == 2) {
            estadisticaLabels.push("REVISION");
        }
        if (element.estado == 3) {
            estadisticaLabels.push("APROBADO");
        }
        if (element.estado == 4) {
            estadisticaLabels.push("REPROBADO");
        }
        if (element.estado == 5) {
            estadisticaLabels.push("ELIMINADO");
        }
    });

    var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: estadisticaLabels,
            datasets: [
                {
                    label: "Estado",
                    data: estadisticaValues,
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                    ],
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Propuestas por Estado",
                },
            },
        },
    });
}

var ctx2 = document.getElementById("cartera");
if (ctx2 != null) {
    var estadistica2 = JSON.parse(ctx2.getAttribute("data"));
    let estadisticaValues2 = [];
    let estadisticaLabels2 = [];
    estadistica2.forEach((element) => {
        estadisticaValues2.push(element.total);
        estadisticaLabels2.push(element.nombre);
    });

    var myChart2 = new Chart(ctx2, {
        type: "polarArea",
        data: {
            labels: estadisticaLabels2,
            datasets: [
                {
                    label: "Cartera",
                    data: estadisticaValues2,
                    backgroundColor: [
                        "rgba(0, 99, 132, 0.6)",
                        "rgba(30, 99, 132, 0.6)",
                        "rgba(60, 99, 132, 0.6)",
                        "rgba(90, 99, 132, 0.6)",
                        "rgba(120, 99, 132, 0.6)",
                        "rgba(150, 99, 132, 0.6)",
                        "rgba(180, 99, 132, 0.6)",
                        "rgba(210, 99, 132, 0.6)",
                        "rgba(240, 99, 132, 0.6)",
                    ],
                    borderColor: [
                        "rgba(0, 99, 132, 1)",
                        "rgba(30, 99, 132, 1)",
                        "rgba(60, 99, 132, 1)",
                        "rgba(90, 99, 132, 1)",
                        "rgba(120, 99, 132, 1)",
                        "rgba(150, 99, 132, 1)",
                        "rgba(180, 99, 132, 1)",
                        "rgba(210, 99, 132, 1)",
                        "rgba(240, 99, 132, 1)",
                    ],
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "left",
                },
                title: {
                    position: "left",
                    display: true,
                    text: "Propuestas por Cartera de Estado",
                },
            },
            layout: {
                padding: 20,
            },
        },
    });
}
