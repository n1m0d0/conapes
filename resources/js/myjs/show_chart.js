import Chart from "chart.js/auto";

console.log("cargando chart");
var ctx = document.getElementById("estado");
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


console.log("cargando chart");
var ctx2 = document.getElementById("cartera");
var estadistica2 = JSON.parse(ctx.getAttribute("data"));
let estadisticaValues2 = [];
let estadisticaLabels2 = [];
estadistica2.forEach((element) => {
    estadisticaValues2.push(element.total);
    if (element.estado == 1) {
        estadisticaLabels2.push("REGISTRADO");
    }
    if (element.estado == 2) {
        estadisticaLabels2.push("REVISION");
    }
    if (element.estado == 3) {
        estadisticaLabels2.push("APROBADO");
    }
    if (element.estado == 4) {
        estadisticaLabels2.push("REPROBADO");
    }
    if (element.estado == 5) {
        estadisticaLabels2.push("ELIMINADO");
    }
});

var myChart2 = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: estadisticaLabels2,
        datasets: [
            {
                label: "Cartera",
                data: estadisticaValues2,
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
                text: "Propuestas por Cartera de Estado",
            },
        },
    },
});
