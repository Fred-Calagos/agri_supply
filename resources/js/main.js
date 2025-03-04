import ApexCharts from 'apexcharts';

const options = {
  chart: { type: 'bar', height: 350 },
  series: [{ name: 'Sales', data: [100, 200, 300, 400] }],
  xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr'] }
};

const chart = new ApexCharts(document.querySelector("#salesChart"), options);
chart.render();
