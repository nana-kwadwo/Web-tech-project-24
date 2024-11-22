// Select relevant elements
const costsContainer = document.getElementById('costs');
const unitsInput = document.getElementById('units');
const markupInput = document.getElementById('markup');
const totalCostOutput = document.getElementById('totalCost');
const unitCostOutput = document.getElementById('unitCost');
const sellingPriceOutput = document.getElementById('sellingPrice');
const profitPerUnitOutput = document.getElementById('profitPerUnit');
const netProfitOutput = document.getElementById('netProfit');
const projectedRevenueOutput = document.getElementById('projectedRevenue');
const breakevenUnitsOutput = document.getElementById('breakevenUnits');

// Function to calculate total cost
function calculateTotalCost() {
    let total = 0;
    document.querySelectorAll('.cost-value').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

// Function to calculate unit cost
function calculateUnitCost(totalCost, units) {
    return units > 0 ? totalCost / units : 0;
}

// Function to calculate selling price
function calculateSellingPrice(unitCost) {
    const markup = parseFloat(markupInput.value) || 0;
    return unitCost * (1 + markup / 100);
}

// Function to calculate profit per unit
function calculateProfitPerUnit(sellingPrice, unitCost) {
    return sellingPrice - unitCost;
}

// Function to calculate net profit
function calculateNetProfit(profitPerUnit, units) {
    return profitPerUnit * units;
}

// Function to calculate projected revenue
function calculateProjectedRevenue(sellingPrice, units) {
    return sellingPrice * units;
}

// Function to calculate breakeven units
function calculateBreakevenUnits(totalCost, sellingPrice) {
    return sellingPrice > 0 ? Math.ceil(totalCost / sellingPrice) : 0;
}

// Function to update results dynamically
function updateResults() {
    const totalCost = calculateTotalCost();
    const units = parseFloat(unitsInput.value) || 0;
    const unitCost = calculateUnitCost(totalCost, units);
    const sellingPrice = calculateSellingPrice(unitCost);
    const profitPerUnit = calculateProfitPerUnit(sellingPrice, unitCost);
    const netProfit = calculateNetProfit(profitPerUnit, units);
    const projectedRevenue = calculateProjectedRevenue(sellingPrice, units);
    const breakevenUnits = calculateBreakevenUnits(totalCost, sellingPrice);

    totalCostOutput.textContent = `$${totalCost.toFixed(2)}`;
    unitCostOutput.textContent = `$${unitCost.toFixed(2)}`;
    sellingPriceOutput.textContent = `$${sellingPrice.toFixed(2)}`;
    profitPerUnitOutput.textContent = `$${profitPerUnit.toFixed(2)}`;
    netProfitOutput.textContent = `$${netProfit.toFixed(2)}`;
    projectedRevenueOutput.textContent = `$${projectedRevenue.toFixed(2)}`;
    breakevenUnitsOutput.textContent = breakevenUnits;
}

// Attach event listeners to all inputs
function attachEventListeners() {
    document.querySelectorAll('.cost-value').forEach(input => {
        input.addEventListener('input', updateResults);
    });
    unitsInput.addEventListener('input', updateResults);
    markupInput.addEventListener('input', updateResults);
}

// Function to delete a cost item
function deleteCostItem(button) {
    const costItem = button.parentElement;
    costItem.remove();
    updateResults(); // Update results after deleting an item
}

// Function to add a new cost item
function addCostItem() {
    const newCostItem = document.createElement('div');
    newCostItem.classList.add('cost-item');
    newCostItem.innerHTML = `
        <input type="text" value="Item ${costsContainer.children.length + 1}" class="cost-name" />
        <input type="number" value="0" class="cost-value" min="0" />
        <button class="delete-btn" onclick="deleteCostItem(this)">✖</button>
    `;
    costsContainer.appendChild(newCostItem);
    attachEventListeners(); // Reattach event listeners to include the new item
}

// Initialize event listeners on load
attachEventListeners();
updateResults();
