function createTableRow(phone, tableBody) {
    const row = document.createElement("tr");
    row.addEventListener("click", function() {
        const selectedRow = tableBody.querySelector(".selected");
        if (selectedRow) {
        selectedRow.classList.remove("selected");
        }
        this.classList.add("selected");
        displaySelectedRowData(phone);
    });

    Object.values(phone).forEach(function(value) {
        const cell = document.createElement("td");
        cell.textContent = value;
        row.appendChild(cell);
    });

    tableBody.appendChild(row);
}

function displaySelectedRowData(phone) {
    const phoneNameElement = document.querySelector(".tableHeader .selectedItemName");

    // phoneNameElement.textContent = phone.username;
    if (phone.phone_name) {
        phoneNameElement.textContent = phone.phone_name;
    } else if (phone.username) {
        phoneNameElement.textContent = phone.username;
    } else {
        phoneNameElement.textContent = 'null';
    }
      
}

