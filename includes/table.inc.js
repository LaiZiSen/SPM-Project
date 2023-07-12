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

function checkEmpty(data, emptySample) {
  for (let key in data) {
    if (data[key] == "") {
        return true; // Empty property found
    }
  }

  for (let key in emptySample) {
    if (data[key] == emptySample[key]){
        return true;
    }
  }

  return false; // No empty properties found
}

function checkVariableFormat(data, expectedFormats) {

    for (const variable in expectedFormats) {
        const value = data[variable];
        if (value && !value.endsWith(expectedFormats[variable])) {
            console.log(value);
            console.log(variable);
            return false;
        } 
    }

    return true;
}

function errorCheck(data, tableName){
    switch(tableName) {
        case "phone" :
            const expectedFormats = {
                height: ' mm',
                size: '\"',
                width: ' mm',
                battery: ' mAh'
            };

            const emptySample = {
                height: '0 mm',
                size: '0\"',
                width: '0 mm',
                battery: '0 mAh'
            };

            if (checkEmpty(data, emptySample)) {
                return "Empty";
            }

            if (!checkVariableFormat(data, expectedFormats)) {
                console.log("in format error");
                return "Format Error";
            }

            return "No Error";
        default:
            return "TableName Doesn't Exist!"; 
    }
}