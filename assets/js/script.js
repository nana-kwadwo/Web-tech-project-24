// Select relevant elements
const costsContainer = document.getElementById('costs');
const fixedCostsInput = document.getElementById('fixed-cost');
const markupInput = document.getElementById('markup');
const totalCostPerUnitOutput = document.getElementById('totalCostPerUnit');
const sellingPriceOutput = document.getElementById('sellingPrice');
const profitPerUnitOutput = document.getElementById('profitPerUnit');
const breakevenUnitsOutput = document.getElementById('breakevenUnits');

// Function to calculate total cost per unit
function calculateTotalCostPerUnit() {
    let total = 0;
    document.querySelectorAll('.cost-value').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

// Function to calculate selling price based on markup
function calculateSellingPrice(totalCostPerUnit) {
    const markup = parseFloat(markupInput.value) || 0;
    return totalCostPerUnit * (1 + markup / 100);
}

// Function to calculate profit per unit
function calculateProfitPerUnit(sellingPrice, totalCostPerUnit) {
    return sellingPrice - totalCostPerUnit;
}

// Function to calculate breakeven units
function calculateBreakevenUnits(profitPerUnit) {
    const fixedCosts = parseFloat(fixedCostsInput.value) || 0;
    return profitPerUnit > 0 ? Math.ceil(fixedCosts / profitPerUnit) : 0;
}

// Function to update results
function updateResults() {
    const totalCostPerUnit = calculateTotalCostPerUnit();
    const sellingPrice = calculateSellingPrice(totalCostPerUnit);
    const profitPerUnit = calculateProfitPerUnit(sellingPrice, totalCostPerUnit);
    const breakevenUnits = calculateBreakevenUnits(profitPerUnit);

    totalCostPerUnitOutput.textContent = `$${totalCostPerUnit.toFixed(2)}`;
    sellingPriceOutput.textContent = `$${sellingPrice.toFixed(2)}`;
    profitPerUnitOutput.textContent = `$${profitPerUnit.toFixed(2)}`;
    breakevenUnitsOutput.textContent = breakevenUnits;
}

// Event listeners for input fields
document.querySelectorAll('.cost-value, #fixed-cost, #markup').forEach(input => {
    input.addEventListener('input', updateResults);
});

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
    newCostItem.querySelector('.cost-value').addEventListener('input', updateResults);
    costsContainer.appendChild(newCostItem);
}