<?php include '../actions/dashboard_data.php'; ?>

<main>
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin Panel. Here you can manage users, recipes, and view site analytics.</p>

    <section class="dashboard-stats">
        <div class="card">
            <h2>Total Users</h2>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="card">
            <h2>Total Recipes</h2>
            <p><?php echo $total_recipes; ?></p>
        </div>
        <div class="card">
            <h2>Recipes This Month</h2>
            <p><?php echo $recipes_this_month; ?></p>
        </div>
        <div class="card">
            <h2>Top 5 Users</h2>
            <ul>
                <?php while ($row = $top_users_result->fetch_assoc()) { ?>
                    <li><?php echo $row['fname'] . ' - ' . $row['recipes_count'] . ' recipes'; ?></li>
                <?php } ?>
            </ul>
        </div>
    </section>
</main>
