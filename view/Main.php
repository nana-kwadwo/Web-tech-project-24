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
        <div class="upload-section">
            <label for="imageUpload" class="upload-label">
                <span class="upload-icon">📤</span>
                <span>Upload Image</span>
            </label>
            <input type="file" id="imageUpload" accept="image/*" hidden>
        </div>
        <div class="back-button-container">
            <button class="back-button" onclick="goBack()"><a href="new_collection.html">← Back</a></button>
        </div>
        <div class="card">
           <h2><input type="text" class="product-name" value="Product Name" placeholder="Enter product name"></h2>
            <div class="section">
                <h3>Costs</h3>
                <div id="costs">
                    <div class="cost-item">
                        <input type="text" value="Fabric" class="cost-name" />
                        <input type="number" value="0" class="cost-value" />
                        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                    </div>
                    <div class="cost-item">
                        <input type="text" value="Embroidery" class="cost-name" />
                        <input type="number" value="0" class="cost-value" />
                        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                    </div>
                    <div class="cost-item">
                        <input type="text" value="Sewing" class="cost-name" />
                        <input type="number" value="0" class="cost-value" />
                        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                    </div>
                    <div class="cost-item">
                        <input type="text" value="Packaging" class="cost-name" />
                        <input type="number" value="0" class="cost-value" />
                        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                    </div>
                    <div class="cost-item">
                        <input type="text" value="Delivery" class="cost-name" />
                        <input type="number" value="0" class="cost-value" />
                        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
                    </div>
                </div>
                <button onclick="addCostItem()">Add Cost Item</button>
            </div>

            <div class="cost-section">
                <label for="units">Number of Units</label>
                <input type="number" id="units" placeholder="Enter number of units">

                <label for="markup">Markup Percentage (%)</label>
                <input type="number" id="markup" placeholder="Enter markup percentage">
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

    <div class="button-group">
        <button id="saveButton" class="action-btn" disabled>Save</button>
    </div>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>
