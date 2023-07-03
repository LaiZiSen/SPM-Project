function createTableRow(rowData, tableBody) {
    const row = document.createElement("tr");
    row.addEventListener("click", function() {
        const selectedRow = tableBody.querySelector(".selected");
        if (selectedRow) {
        selectedRow.classList.remove("selected");
        }
        this.classList.add("selected");
        selectedData = rowData;
        displaySelectedRowData();
    });

    Object.values(rowData).forEach(function(value) {
        const cell = document.createElement("td");
        cell.textContent = value;
        row.appendChild(cell);
    });

    tableBody.appendChild(row);
}

function displaySelectedRowData() {
    const selectedNameElement = document.querySelector(".tableHeader .selectedItemName");

    if (selectedData.phone_name) {
        selectedNameElement.textContent = selectedData.phone_name;
    } else if (selectedData.username) {
        selectedNameElement.textContent = selectedData.username;
    } else {
        selectedNameElement.textContent = '';
    }
      
}

