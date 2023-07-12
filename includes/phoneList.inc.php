<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "phone";

?>
<script src="includes/table.inc.js" ></script>
<script>
  var selectedData;
  // var deleteButton;
  // var editButton;
  // var overlay;
  var ajaxUrl = "includes/ajaxRequest.inc.php";
  var localUrl = 'http://localhost/k-tech/phone_list.php';

  //Function to create URLs with complex parameters
  function createURL(endpoint, params) {
    const encodedParams = params.map(([key, value]) => {
      return encodeURIComponent(key) + "=" + encodeURIComponent(value);
    });

    const queryString = encodedParams.join("&");
    const url = endpoint + "?" + queryString;

    return url;
  }

  //Table Functions
  function loadTable() {
    const tableData = <?php echo getTable($conn, $tableName); ?>;
    const tableBody = document.querySelector("#table tbody");
    
    tableBody.innerHTML = ""; 
    tableData.forEach(function(rowData) {
      createTableRow(rowData, tableBody);
    });
  }

  function deleteElement() {
    if (!selectedData) {return;}
    
    //Preparing Information
    const prams = [
      ["method" , "deleteElement"],
      ["tableName" , "<?php echo $tableName?>"],
      ["id" , selectedData.id],
    ];
    const url = createURL(ajaxUrl, prams);

    //delete the selectedData
    fetch(url)
      .then(response => {
        // Reload the current page
        window.location.reload();
      })
      .catch(error => {
          console.error("Error:", error);
      });
    //reload the table
  }

  function editElement(data){
    const prams = [
      ["method", "editElement"],
      ["tableName", "<?php echo $tableName?>"]
    ];

    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        prams.push([key, data[key]]);
      }
    }
    
    url = createURL(ajaxUrl, prams);
    fetch(url)
      .then(response => {
        window.location.href = localUrl;
      })
      .catch(error => {
          console.error("Error:", error);
      });
  }

  //Form Functions
  function initEditForm(){
    const heightInput = document.getElementById('height');
    const widthInput = document.getElementById('width');
    const sizeInput = document.getElementById('size');
    const batteryInput = document.getElementById('battery');

    setupInputs(heightInput, " mm");
    setupInputs(widthInput, " mm");
    setupInputs(sizeInput, "\"");
    setupInputs(batteryInput, " mAh");
  }

  function setupInputs(inputElement, backpoint){
    inputElement.addEventListener('focus', function() {
      const inputValue = this.value.replace(backpoint, '');
      this.value = inputValue;
    });

    inputElement.addEventListener('input', function() {
      const inputValue = this.value.replace(/[^\d.]/g, '');
      this.value = inputValue;
    });

    inputElement.addEventListener('blur', function() {
      if (this.value) {
        formattedValue = this.value + backpoint;
      } else {
        formattedValue = "0" + backpoint;
      }
      this.value = formattedValue;
    });
  }

  function populateForm(data) {
    // Get references to the form inputs
    const formHeading = document.querySelector('.formHeading');
    const phoneNameInput = document.getElementById('phone_name');
    const heightInput = document.getElementById('height');
    const widthInput = document.getElementById('width');
    const sizeInput = document.getElementById('size');
    const osInput = document.getElementById('os');
    const brandInput = document.getElementById('brand');
    const batteryInput = document.getElementById('battery');
    const imageUrlInput = document.getElementById('image_url');
    const phoneUrlInput = document.getElementById('phone_url');

    // Set the values of the form inputs
    formHeading.textContent = "ID: " + data.id.toString();
    phoneNameInput.value = data.phone_name;
    heightInput.value = data.height;
    widthInput.value = data.width;
    sizeInput.value = data.size;
    osInput.value = data.os;
    brandInput.value = data.brand;
    batteryInput.value = data.battery;
    imageUrlInput.value = data.image_url;
    phoneUrlInput.value = data.phone_url;
  }

  function fetchFormValues() {
    const phoneNameInput = document.getElementById('phone_name');
    const heightInput = document.getElementById('height');
    const widthInput = document.getElementById('width');
    const sizeInput = document.getElementById('size');
    const osInput = document.getElementById('os');
    const brandInput = document.getElementById('brand');
    const batteryInput = document.getElementById('battery');
    const imageUrlInput = document.getElementById('image_url');
    const phoneUrlInput = document.getElementById('phone_url');

    const extractedValues = {
      "id": selectedData.id,
      "phone_name": phoneNameInput.value,
      "height": heightInput.value,
      "width": widthInput.value,
      "size": sizeInput.value,
      "os": osInput.value,
      "brand": brandInput.value,
      "battery": batteryInput.value,
      "image_url": imageUrlInput.value,
      "phone_url": phoneUrlInput.value
    };

    return extractedValues;
  }

  //Functions for Edit function
  function startEdit() {
    if (!selectedData) {
      return;
    }
    overlay.style.display = "block";
    populateForm(selectedData);
  }

  function cancelEdit(){
    overlay.style.display = "none";
  }

  function finishEdit() {
    overlay.style.display = "none";
    
    fetchedValue = fetchFormValues();
    
    result = errorCheck(fetchedValue, "phone");
    console.log("This is the result:  " + result);

    if (result !== "No Error") {
      window.location.href = createURL(localUrl, [['error', result]]);
    } else {
      editElement(fetchedValue);
    }

  }

  document.addEventListener("DOMContentLoaded", function(){
    overlay = document.querySelector(".overlay");
    errorElement = document.querySelector(".error");

    deleteButton = document.querySelector(".delete");

    editButton = document.querySelector(".edit");
    closeEditButton = document.querySelector(".closeEdit");
    cancelEditButton = document.querySelector(".cancelEdit");

    deleteButton.addEventListener("click",deleteElement);

    editButton.addEventListener("click", startEdit);
    closeEditButton.addEventListener("click", finishEdit);
    cancelEditButton.addEventListener("click", cancelEdit);

    loadTable();
    initEditForm();
  });
</script>