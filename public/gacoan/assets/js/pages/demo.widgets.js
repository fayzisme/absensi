(Apex.grid = { padding: { right: 0, left: 0 } }),
  (Apex.dataLabels = { enabled: !1 });
var colors = ["#3e60d5"],
  dataColors = $("#campaign-sent-chart").data("colors"),
  options1 = {
    chart: { type: "bar", height: 60, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "60%" } },
    colors: (colors = dataColors ? dataColors.split(",") : colors),
    series: [{ data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] }],
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    xaxis: { crosshairs: { width: 1 } },
    tooltip: {
      fixed: { enabled: !1 },
      x: { show: !1 },
      y: {
        title: {
          formatter: function (o) {
            return "";
          },
        },
      },
      marker: { show: !1 },
    },
  },
  colors =
    (new ApexCharts(
      document.querySelector("#campaign-sent-chart"),
      options1
    ).render(),
    ["#3e60d5"]),
  dataColors = $("#new-leads-chart").data("colors"),
  options2 = {
    chart: { type: "line", height: 60, sparkline: { enabled: !0 } },
    series: [{ data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54] }],
    stroke: { width: 2, curve: "smooth" },
    markers: { size: 0 },
    colors: (colors = dataColors ? dataColors.split(",") : colors),
    tooltip: {
      fixed: { enabled: !1 },
      x: { show: !1 },
      y: {
        title: {
          formatter: function (o) {
            return "";
          },
        },
      },
      marker: { show: !1 },
    },
  },
  colors =
    (new ApexCharts(
      document.querySelector("#new-leads-chart"),
      options2
    ).render(),
    ["#3e60d5"]),
  dataColors = $("#deals-chart").data("colors"),
  options3 = {
    chart: { type: "bar", height: 60, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "60%" } },
    colors: (colors = dataColors ? dataColors.split(",") : colors),
    series: [{ data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14] }],
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    xaxis: { crosshairs: { width: 1 } },
    tooltip: {
      fixed: { enabled: !1 },
      x: { show: !1 },
      y: {
        title: {
          formatter: function (o) {
            return "";
          },
        },
      },
      marker: { show: !1 },
    },
  },
  colors =
    (new ApexCharts(document.querySelector("#deals-chart"), options3).render(),
    ["#3e60d5"]),
  dataColors = $("#booked-revenue-chart").data("colors"),
  options4 = {
    chart: { type: "line", height: 60, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "60%" } },
    colors: (colors = dataColors ? dataColors.split(",") : colors),
    series: [{ data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82] }],
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    stroke: { width: 2, curve: "smooth" },
    markers: { size: 0 },
    tooltip: {
      fixed: { enabled: !1 },
      x: { show: !1 },
      y: {
        title: {
          formatter: function (o) {
            return "";
          },
        },
      },
      marker: { show: !1 },
    },
  };
new ApexCharts(
  document.querySelector("#booked-revenue-chart"),
  options4
).render();
