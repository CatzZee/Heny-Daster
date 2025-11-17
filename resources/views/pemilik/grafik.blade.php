<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Grafik Keuangan</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<style>
  :root {
    --accent-blue: #1ea7ff;
    --text-color: #111;
    --soft-pink: #f9a8d4;
  }

  html, body {
    height: 100%;
    margin: 0;
    background: #fff;
    font-family: "Poppins", sans-serif;
    color: var(--text-color);
  }

  /* Sidebar */
  .sidebar {
    background-color: #ff9cc7;
    width: 60px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    gap: 15px;
  }

  .sidebar a {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    transition: background-color 0.2s;
  }

  .sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.3);
  }

  .sidebar svg {
    width: 22px;
    height: 22px;
    fill: white;
  }

  /* Main Content */
  .main-content {
    margin-left: 80px;
    padding: 40px;
  }

  .chart-wrapper {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 30px;
  }

  h2 {
    color: #888;
    margin-bottom: 20px;
    font-weight: normal;
    font-size: 18px;
  }

  canvas {
    max-height: 300px;
  }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <a href="#">
    <!-- Icon Home -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2z"/>
    </svg>
  </a>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="chart-wrapper">
    <h2>Maret 2021</h2>
    <canvas id="chartMaret"></canvas>
  </div>

  <div class="chart-wrapper">
    <h2>April 2021</h2>
    <canvas id="chartApril"></canvas>
  </div>

  <div class="chart-wrapper">
    <h2>Mei 2021</h2>
    <canvas id="chartMei"></canvas>
  </div>
</div>

<script>
  const commonOptions = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: false,
        grid: {
          color: '#e0e0e0',
          drawBorder: false
        },
        ticks: {
          display: false
        }
      },
      x: {
        grid: {
          display: false,
          drawBorder: true,
          borderColor: '#000'
        },
        ticks: {
          font: {
            size: 10
          }
        }
      }
    }
  };

  const dataMaret = [120, 110, 105, 130, 160, 175, 180, 165, 140, 145, 150, 160, 180, 165, 150, 145, 155, 170, 185, 200, 190, 170, 110, 215, 195, 175, 155, 150, 165, 140, 135];
  const dataApril = [140, 130, 120, 110, 125, 155, 175, 220, 180, 150, 140, 155, 190, 210, 195, 180, 145, 120, 175, 210, 195, 185, 175, 160, 145];
  const dataMei = [130, 125, 120, 125, 135, 145, 155, 165, 175, 190, 200, 210, 215, 220, 225, 230, 240, 250, 260, 270, 255, 240, 225, 210, 195, 180];

  const labelsMaret = Array.from({length: 31}, (_, i) => i + 1);
  const labelsApril = Array.from({length: 30}, (_, i) => i + 1);
  const labelsMei = Array.from({length: 31}, (_, i) => i + 1);

  new Chart(document.getElementById('chartMaret'), {
    type: 'line',
    data: {
      labels: labelsMaret,
      datasets: [{
        data: dataMaret,
        borderColor: '#e74c3c',
        backgroundColor: 'transparent',
        borderWidth: 2,
        tension: 0.1,
        pointRadius: 0
      }]
    },
    options: commonOptions
  });

  new Chart(document.getElementById('chartApril'), {
    type: 'line',
    data: {
      labels: labelsApril,
      datasets: [{
        data: dataApril,
        borderColor: '#e74c3c',
        backgroundColor: 'transparent',
        borderWidth: 2,
        tension: 0.1,
        pointRadius: 0
      }]
    },
    options: commonOptions
  });

  new Chart(document.getElementById('chartMei'), {
    type: 'line',
    data: {
      labels: labelsMei,
      datasets: [{
        data: dataMei,
        borderColor: '#e74c3c',
        backgroundColor: 'transparent',
        borderWidth: 2,
        tension: 0.1,
        pointRadius: 0
      }]
    },
    options: commonOptions
  });
</script>

</body>
</html>