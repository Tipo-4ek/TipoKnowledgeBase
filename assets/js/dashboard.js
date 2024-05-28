function createChart(chartId, type, legend, url) {
  var ctx = document.getElementById(chartId).getContext('2d');
  var myPieChart;

  fetch(url)
      .then(response => response.json())
      .then(data => {
          myPieChart = new Chart(ctx, {
              type: type,
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                    legend: {
                        display: legend
                    }
                }
              }
          });
      });
}

createChart('chart-channel', 'pie', true, 'assets/php/chart-channels.php');
createChart('chart-rating', 'bar', true, 'assets/php/chart-rating.php');
createChart('chart-ml-dynamic', 'line', false, 'assets/php/chart-ml-dynamic.php');