// start of add and delete product rows
const orderTable = document.getElementById("order-table");
const addRowBtn = document.querySelector('.add_one');
addRowBtn.addEventListener('click', addRow);

function addRow() {
    var rows = document.getElementsByClassName('product-row');
    var lastRow = rows[rows.length - 1];
    const lastRowProductsSelect = lastRow.querySelector('select[name="product[]"]');
    const lastRowSelectedProduct = lastRowProductsSelect.value;
    // Clone the last row
    var clone = lastRow.cloneNode(true);
    const [productsSelect, quantityInput] = clone.querySelectorAll('select[name="product[]"], input[name="quantity[]"]');
    productsSelect.value = "";
    quantityInput.value = 1;
    // Insert the clone after the last row
    lastRow.insertAdjacentElement('afterend', clone);

    initSync(productsSelect);
    if (lastRowSelectedProduct) {
        hideOption(productsSelect, lastRowSelectedProduct);
    }

    // Loop through the rows
    for (let i = 0; i < rows.length; i++) {
        // Set the inner HTML of the first cell to the current loop iteration number
        rows[i].cells[0].innerHTML = i + 1;
    }
}
function deleteRow(deleteBtn) {
    const productsRowCount = orderTable.querySelectorAll('.product-row').length;
    if (productsRowCount > 1) {
        const row = deleteBtn.closest("tr");
        const productsSelect = row.querySelector("select[name='product[]']");
        removeSync(productsSelect);
        row.remove();

        const rows = orderTable.getElementsByClassName('product-row');
        for (let i = 0; i < rows.length; i++) {
            // Set the inner HTML of the first cell to the current loop iteration number
            rows[i].cells[0].textContent = i + 1;
        }
    } else {
        alert("You need order at least one item.");
    }
}
// end of add and delete product rows





// self learning
// start of prevent user from selecting the same product more than once

// const productsSelects = {
//     selects: new Set(),
//     add: function(select) {
//         this.selects.add(select);
//     },
//     delete: function(select) {
//         this.selects.delete(select);
//     },
//     get all() {
//         return this.selects;
//     }
// };
// const selectedProducts = {
//     products: new Set(),
//     add: function(id) {
//         this.products.add(id);
//     },
//     delete: function(id) {
//         this.products.delete(id);
//     },
//     get all() {
//         return this.products;
//     }
// };
// document.querySelectorAll("select[name='product[]']").forEach(initSync);
// productsSelects.all.forEach(select => updateAllProductsSelects.apply(select));

// function initSync(select) {
//     productsSelects.add(select);
//     select.addEventListener("input", updateAllProductsSelects);
// }
// function removeSync(select) {
//     select.removeEventListener("input", updateAllProductsSelects);
//     productsSelects.delete(select);
//     const selectedValue = select.value;
//     if (selectedValue) {
//         selectedProducts.delete(selectedValue);
//         productsSelects.all.forEach(s => showOption(s, selectedValue));
//     }
// }
// function updateAllProductsSelects() {
//     const currentValue = this.value;
//     const oldValue = this.dataset.currentValue;
//     if (oldValue) {
//         selectedProducts.delete(oldValue);
//         productsSelects.all.forEach(s => showOption(s, oldValue));
//     }
//     selectedProducts.add(currentValue);
//     this.dataset.currentValue = currentValue;
//     productsSelects.all.forEach(s => {
//         if (s !== this) {
//             hideOption(s, currentValue);
//         }
//     });
// }
// function showOption(select, val) {
//     select.querySelector(`option[value="${val}"]`).classList.remove("d-none");
// }
// function hideOption(select, val) {
//     select.querySelector(`option[value="${val}"]`).classList.add("d-none");
// }

// end of prevent user from selecting the same product more than once