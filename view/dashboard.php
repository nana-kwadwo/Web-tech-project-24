<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fashion Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-nav">
            <li><a href="#">Dashboard</a></li>
            <li><a href="new_collection.php">New<br> Collection</a></li>
            <li><a href="collection_history.php">Collections</a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="../actions/logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
        <div class="logo">
            <h2>Dashboard</h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="dashboard-row">
            <button class="btn-create"><a href="new_collection.php">Create New Collection</a></button>

            
            <div class="info-box">  
                <a href="collection_history.php">
                <div class="info-name">Collections </div>
                </a>
            </div>

          <div class="info-box">
          <a href="help.php">
            <div class="info-name">FAQs</div>
          </a> 
            </div>
        </div>

        <div class="dashboard-row">
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="productDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');

            // Toggle sidebar visibility
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });

            // Revenue Bar Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Apoluo', 'Apoluo 2', 'Asher'],
                    datasets: [{
                        label: 'Revenue per Collection',
                        data: [22000, 18000, 15000],
                        backgroundColor: ['#0078ff', '#00a2ff', '#5eb4ff'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Product Distribution Pie Chart
            const productCtx = document.getElementById('productDistributionChart').getContext('2d');
            new Chart(productCtx, {
                type: 'pie',
                data: {
                    labels: ['Bottoms', 'Outerwear', 'Accessories'],
                    datasets: [{
                        data: [40, 35, 25],
                        backgroundColor: ['#0078ff', '#00a2ff', '#5eb4ff']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
</body>
</html>
