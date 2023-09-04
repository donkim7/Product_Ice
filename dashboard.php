<?php
require "functions.php";
check_login();
// echo $query; // Add this line to display the SQL query
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Dashboard</title>
    <style>
        /* Create 3D effect for pie chart */
        .chart-container {
            position: relative;
            width: 400px; /* Adjust as needed */
            height: 400px; /* Adjust as needed */
            display: inline-table;
            max-width: 50%;
            color: #4527A0;
                        /* padding-left: 20; */
            margin-left: 10%;
            margin-bottom: 15px;
            /* background-color: #5d05ae17; */
            border-radius: 4px;
        }
        .radios{
            display: flex;
    align-items: center;
    justify-content: space-evenly;

        }
        /* The container */
        .chart-container2{
                        position: relative;
            width: 400px; /* Adjust as needed */
            height: 400px; /* Adjust as needed */
            display: inline-table;
            max-width: 50%;
            color: #4527A0;
                        /* padding-left: 20; */
            margin-left: 10%;
            margin-bottom: 15px;
            /* background-color: #5d05ae17; */
            border-radius: 4px;
        }
        body{
    background-color: #dde3f5;
}
 
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body >
<?php include "sidebar.php" ?>

<div class="content">
    <h1 class="headings">Welcome to your Dashboard</h1>
    <div class="chart-container2">
        
        <canvas id="revenueAndIncomeChart" width="400" height="400"></canvas>
        <div class="radios" >
            <input type="radio" id="today" name="range" value="today" checked>
            <label for="today">Today</label>
    
            <input type="radio" id="weekly" name="range" value="weekly">
            <label for="weekly">Weekly</label>
    
            <input type="radio" id="monthly" name="range" value="monthly">
            <label for="monthly">Monthly</label>
        </div>
    </div>




    <!-- Line Graph - Most Created Products -->
    <div class="chart-container">
        <canvas id="mostCreatedChart" width="400" height="400"></canvas>
    </div>

    <!-- Pie Chart - Most Bought Products -->
    <div class="chart-container">
        <canvas id="mostBoughtChart" width="400" height="400"></canvas>
    </div>


    <!-- Horizontal Bar Graph - Top Purchased Products -->
    <div class="chart-container">
        <canvas id="topPurchasedChart" width="400" height="400"></canvas>
    </div>

    <!-- Doughnut Chart - Top Expenses -->
    <div class="chart-container">
        <canvas id="topExpensesChart" width="400" height="400"></canvas>
    </div>






    <script>

            // Add the following options to each chart
    var chartOptions = {
        scales: {
            x: {
                ticks: {
                    color: 'rgba: (115, 44, 123, 1)' // Adjust the color as needed
                }
            },
            y: {
                ticks: {
                    color: 'rgba: (115, 44, 123, 1)' // Adjust the color as needed
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: 'rgba: (115, 44, 123, 1)' // Adjust the color as needed
                }
            }
        }
    };

        // Most Bought Products
        var mostBoughtCtx = document.getElementById('mostBoughtChart').getContext('2d');
        new Chart(mostBoughtCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($mostBoughtProducts, 'saleItem')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($mostBoughtProducts, 'totalQuantity')); ?>,
                    backgroundColor: ['#FF8952', '#297FF9', '#00C689', '#D0D2D6', '#733686'],
                    color: 'rgba(115, 44, 123, 1)'
                }]
            }, options: {
    title: {
      display: true,
      text: "Most Sold Products",
      color: 'rgba(115, 44, 123, 1)'
    }
  },

        });

        // Most Created Products
        var mostCreatedCtx = document.getElementById('mostCreatedChart').getContext('2d');
        new Chart(mostCreatedCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($mostCreatedProducts, 'productName')); ?>,
                datasets: [{
                    label: 'Creation Count',
                    data: <?php echo json_encode(array_column($mostCreatedProducts, 'creationCount')); ?>,
                    borderColor: '#732C7B',
                    fill: false
                }]
            }, options: {
    title: {
      display: true,
      text: "Added Products in Store"
    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
  }
        });

        // Top Purchased Products
        var topPurchasedCtx = document.getElementById('topPurchasedChart').getContext('2d');
        new Chart(topPurchasedCtx, {
            type: 'horizontalBar',
            data: {
                labels: <?php echo json_encode(array_column($topPurchasedProducts, 'itemsPurchased')); ?>,
                datasets: [{
                    label: 'Total Quantity Purchased',
                    data: <?php echo json_encode(array_column($topPurchasedProducts, 'totalQuantity')); ?>,
                    backgroundColor: ['#FF8952', '#297FF9', '#00C689', '#D0D2D6', '#733686']
                }]
            }, options: {
    title: {
      display: true,
      text: "Most Purchased equipments "
    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
    
  }
        });

        // Top Expenses
        var topExpensesCtx = document.getElementById('topExpensesChart').getContext('2d');
        new Chart(topExpensesCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($topExpenses, 'expenseName')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($topExpenses, 'totalAmount')); ?>,
                    backgroundColor: ['#FF8952', '#297FF9', '#00C689', '#D0D2D6', '#733686']
                }]
            },
            options: {
    title: {
      display: true,
      text: "Most Incured Expenses"
    },


  }
        });






// Function to create a combined revenue and income chart
function createRevenueAndIncomeChart(revenueData, incomeData) {
    const ctx = document.getElementById('revenueAndIncomeChart').getContext('2d');
    let revenueAndIncomeChart;

    if (revenueAndIncomeChart) {
        revenueAndIncomeChart.destroy();
    }

    revenueAndIncomeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: revenueData.map(item => item.saleDate),
            datasets: [
                {
                    label: 'Income',
                    data: incomeData.map(item => item.income),
                    borderColor: '#733686',
                    fill: false,
                    type: 'line',
                    // yAxisID: 'y-axis-income', // Assign this dataset to a separate y-axis
                    pointRadius: 6, // Increase the point diameter
                    pointBorderColor: '#733686', // Modify point border color
                    pointBackgroundColor: '#733686', // Modify point fill color
                
                   },
                {
                    label: 'Revenue',
                    data: revenueData.map(item => item.totalSales),
                    backgroundColor: ['#FF8952', '#297FF9', '#00C689', '#D0D2D6', '#733686', '#FF8952', '#297FF9', '#00C689', '#D0D2D6', '#733686'],
                
                },
            ],
        },
        options: {
            legend: {
                display: true,
            },
            title: {
                display: true,
                text: 'Revenue and Income',
            },
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Amount',
                        },
                    },
                ],
                xAxes: [
                    {
                        scaleLabel: {
                            display: true,
                            labelString: 'Date',
                        },
                    },
                ],
            },
            hover: {
                mode: null, // Disable hover interactions
            },
        },
    });
}

// Function to update the combined revenue and income chart
function updateRevenueAndIncomeChart(range) {
    fetch(`sales_dash.php?range=${range}`)
        .then(response => response.json())
        .then(data => {
            const revenueData = data.revenue;
            const incomeData = data.income;

            createRevenueAndIncomeChart(revenueData, incomeData);
        });
}

// Call the function to create the chart with default 'today' range
updateRevenueAndIncomeChart('today');

// Add event listeners to radio buttons for chart update
document.querySelectorAll('input[name="range"]').forEach(radio => {
    radio.addEventListener('change', event => {
        updateRevenueAndIncomeChart(event.target.value);
    });
});




</script>
