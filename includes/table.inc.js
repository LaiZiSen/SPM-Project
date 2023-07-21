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
            // console.log(value);
            // console.log(variable);
            return false;
        } 
    }

    return true;
}

function checkElementNameExists (data, tableData){
    console.log("checking repating names");
    for (var i = 0; i < tableData.length; i++) {
        if (tableData[i][data[0]] == data[1]) {
            console.log(tableData[i][0] + data[1]);
            return true;
        }
    }
    return false;
}

function checkObjectKeys(obj) {
    const expectedDataKeys = [
        "phone_name", "height", "size", "width", "phone_url", "image_url", "os", "brand", "battery"
    ];

    const objKeys = Object.keys(obj);

    // Check for missing keys
    const missingKeys = expectedDataKeys.filter(key => key !== "id" && !objKeys.includes(key));

    // Check for extra keys
    const extraKeys = objKeys.filter(key => key !== "id" && !expectedDataKeys.includes(key));

    return missingKeys.length === 0 && extraKeys.length === 0;
}

function errorCheck(data, tableName, tableData){
    switch(tableName) {
        case "phone" :
            const expectedFormats = {
                height: ' mm',
                size: '\"',
                width: ' mm',
                battery: ' mAh'
            };

            const expectedDataKeys = [
                "phone_name", "height", "size", "width", "phone_url", "image_url", "os", "brand", "battery"
            ];

            const emptySample = {
                height: '0 mm',
                size: '0\"',
                width: '0 mm',
                battery: '0 mAh'
            };

            if (!checkObjectKeys(data, expectedDataKeys)) {
                return "Data Format Error";
            }

            if (checkEmpty(data, emptySample)) {
                return "Empty";
            }

            if (!checkVariableFormat(data, expectedFormats)) {
                return "Variable Format Error";
            }

            if (checkElementNameExists(["phone_name",data.phone_name], tableData)) {
                console.log("returning name repeated");
                return "Name Repeated";
            }

            return "No Error";
        default:
            return "TableName Doesn't Exist!"; 
    }
}