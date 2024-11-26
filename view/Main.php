<?php
include '../functions/collection_function.php';

if (isset($_GET['id'])) {
    $result = getCollection($_GET['id']);

    //var_dump($result);
    //exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Calculator</title>
    <link rel="stylesheet" href="../assets/css/stylez.css">
</head>

<body>
    <div class="container">
        <div class="back-button-container">
            <button class="back-button" onclick="goBack()"><a href="existing_page.php?id=<?php echo $result['collection_id']; ?>">← Back</a></button>
        </div>
        <div class="card">
            <form action="../actions/add_product.php" method="post">
                <?php if (isset($_SESSION['Create_Error'])): ?>
                    <div class="error-message">
                        <?php
                        foreach ($_SESSION['Create_Error'] as $error) {
                            echo $error . "<br>";
                        }
                        unset($_SESSION['Create_Error']);
                        ?>
                    </div>
                <?php endif; ?>
                <h2><input type="text" class="product-name" value="Product Name" name="product_name"
                        placeholder="Enter product name"></h2>
                <div class="section">
                    <h3>Costs</h3>
                    <div id="costs">
                        <div class="cost-item">
                            <label type="text" value="Fabric" class="cost-name">Fabric </label>
                            <input type="number" value="0" class="cost-value" name="fabric_cost" />
                            <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                        </div>
                        <div class="cost-item">
                            <label type="text" value="Fabric" class="cost-name">Printing </label>
                            <input type="number" value="0" class="cost-value" name="printing_cost" />
                            <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                        </div>
                        <div class="cost-item">
                            <label type="text" value="Fabric" class="cost-name">Sewing </label>
                            <input type="number" value="0" class="cost-value" name="sewing_cost" />
                            <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                        </div>
                        <div class="cost-item">
                            <label type="text" value="Fabric" class="cost-name">Packaging </label>
                            <input type="number" value="0" class="cost-value" name="packaging_cost" />
                            <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                        </div>
                        <div class="cost-item">
                            <label type="text" value="Fabric" class="cost-name">Delivery </label>
                            <input type="number" value="0" class="cost-value" name="delivery_cost" />
                            <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                        </div>
                    </div>
                </div>

                <div class="cost-section">
                    <label for="units">Number of Units</label>
                    <input type="number" id="units" name="number_of_units" placeholder="Enter number of units">

                    <label for="markup">Markup Percentage (%)</label>
                    <input type="number" id="markup" name="markup_percentage" placeholder="Enter markup percentage">
                </div>
                <input type="hidden" value=<?php echo $_GET['id']?> name="collection_id">
                <div class="button-group">
                    <button id="saveButton" class="action-btn" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="section results">
        <h3>Results</h3>
        <div class="result-item">
            <p>Total Cost</p>
            <span id="totalCost">₵0.00</span>
        </div>
        <div class="result-item">
            <p>Unit Cost</p>
            <span id="unitCost">₵0.00</span>
        </div>
        <div class="result-item">
            <p>Selling Price</p>
            <span id="sellingPrice">₵$0.00</span>
        </div>
        <div class="result-item">
            <p>Profit Per Unit</p>
            <span id="profitPerUnit">₵0.00</span>
        </div>
        <div class="result-item">
            <p>Net Profit</p>
            <span id="netProfit">₵0.00</span>
        </div>
        <div class="result-item">
            <p>Projected Revenue</p>
            <span id="projectedRevenue">₵0.00</span>
        </div>
        <div class="result-item">
            <p>Breakeven Units</p>
            <span id="breakevenUnits">0</span>
        </div>
    </div>
    </div>
    </div>



    <script src="../assets/js/script.js"></script>
</body>

</html>