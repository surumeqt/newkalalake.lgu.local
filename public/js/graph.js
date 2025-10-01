const ctx = document.getElementById('casesChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Criminal', 'Civil'],
      datasets: [{
        label: 'Number of Cases',
        data: [15, 10],
        backgroundColor: ['#ff6384', '#36a2eb'],
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: '#fff' }
        }
      },
      scales: {
        x: { ticks: { color: '#fff' } },
        y: { beginAtZero: true, ticks: { color: '#fff' } }
      }
    }
  });