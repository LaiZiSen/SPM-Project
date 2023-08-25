<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "phone";

?>
<script src="includes/table.inc.js" ></script>
<script>
  var selectedData;
  var tableData;
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
    tableData = <?php echo getTable($conn, $tableName); ?>;
    const tableBody = document.querySelector("#table tbody");
    
    console.log("tabledata: " + tableData);

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
        window.location.href = localUrl;
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

  async function addElement(data){
    const prams = [
      ["method", "addElement"],
      ["tableName", "<?php echo $tableName?>"]
    ];

    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        prams.push([key, data[key]]);
      }
    }
    
    url = createURL(ajaxUrl, prams);

    try {
      const response = await fetch(url);
      console.log("got response");
      return true;
    } catch (error) {
      console.error("Error:", error);
      return false;
    }
  }

  function uploadCSV(event){
    var file = event.target.files[0];
    
    var reader = new FileReader();
    reader.onload = function(e) {
      var contents = e.target.result;
      processData(contents);
    };
    reader.readAsText(file);
  }

  function processData(csvData) {

    var rows = csvData.split('\n');
    var csvResults = [];

    for (var i = 1; i < rows.length; i++) {
      var header = rows[0].match(/(?<=^|,)(?:"([^"]|"")*"|[^,]*)/g).map(function(value) {
        return value.replace(/^"|"$/g, '');
      });

      var data = rows[i].match(/(?<=^|,)(?:"([^"]|"")*"|[^,]*)/g).map(function(value) {
        return value.replace(/^"|"$/g, '');
      });

      var dictionary = {};

      for (var j = 0; j < header.length; j++) {
        var key = header[j];
        var value;

        if (key == "id") {
          value = parseInt(data[j], 10);
        } else {
          value = data[j];
        }

        dictionary[key] = value;
      }

      csvResults.push(dictionary);
    }
    console.log(csvResults);
    addCsvData(csvResults);
  }

  async function addCsvData(data){
    errorResults = [];

    for (var i = 0; i < data.length; i++) {
      errorCheckResult = errorCheck(data[i], "<?php echo $tableName ?>", tableData);
      console.log("tableData: ",tableData);

      if (errorCheckResult == "Data Format Error") {
        window.location.href =  createURL(localUrl, [["error", errorCheckResult]]);
        break;
      } else if (errorCheckResult == "No Error") {
        await addElement(data[i]); //Here is problem
      } else {
        errorResults.push(errorCheckResult);
      }
    }

    if (errorResults.length !== 0) {
      const errorMessage = processCsvError(errorResults);
      // console.log(createURL(localUrl, [["error", "CsvError"], ["message", errorMessage]]));
      window.location.href = createURL(localUrl, [["error", "CsvError"], ["message", errorMessage]]);
    } else {
      successUrl = createURL(localUrl, [['message','Csv Upload is Successful!']]);
      window.location.href = successUrl;
    }
    
  }

  function processCsvError(result){
    const occurrences = {};
    var outputMessage = "CSV errors:  <br>";

    for (i = 0; i < result.length; i++) {
      const item = result[i];

      occurrences[item] = occurrences[item]? occurrences[item] + 1 : 1;
    }

    console.log(occurrences);
    const keys = Object.keys(occurrences);

    for (i = 0; i < keys.length; i++) {
      outputMessage = outputMessage + occurrences[keys[i]] + " " + keys[i] + "<br>";
    }
    return outputMessage;
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
      if (this.value.startsWith("0")){
        var inputValue = this.value.slice(-1);
      } else {
        var inputValue = this.value.replace(/[^\d.]/g, '');
      }
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

  function startAddForm(){
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
    formHeading.textContent = "Add Element";
    phoneNameInput.value = "";
    heightInput.value = "0 mm";
    widthInput.value = "0 mm";
    sizeInput.value = "0\"";
    osInput.value = "";
    brandInput.value = "";
    batteryInput.value = "0 mAh";
    imageUrlInput.value = "";
    phoneUrlInput.value = "";
  }
  
  function cancelForm(){
    overlay.style.display = "none";
  }

  //Functions for Add function
  function startAdd(){
    submitButton.addEventListener("click", finishAdd);
    overlay.style.display = "block";
    
    startAddForm();
  }

  async function finishAdd(){
    overlay.style.display = "none";
    fetchedValue = fetchFormValues();

    console.log(fetchedValue);
    
    result = errorCheck(fetchedValue, "<?php echo $tableName?>", tableData);
    console.log("This is the result:  " + result);

    var addResult;

    if (result !== "No Error") {
      window.location.href = createURL(localUrl, [['error', result]]);
    } else {
      const respond = await addElement(fetchedValue);

      if (respond) {
        window.location.href = localUrl;
      }
    }
  }

  //Functions for Edit function
  function startEdit() {
    if (!selectedData) {
      return;
    }

    submitButton.addEventListener("click", finishEdit);
    overlay.style.display = "block";

    populateForm(selectedData);
  }

  function finishEdit() {
    overlay.style.display = "none";
    
    fetchedValue = fetchFormValues();
    fetchedValue['id'] = selectedData.id;

    result = errorCheck(fetchedValue, "phone", tableData);
    console.log("This is the result:  " + result);

    if (result !== "No Error" && result !== "Name Repeated") {
      window.location.href = createURL(localUrl, [['error', result]]);
    } else {
      editElement(fetchedValue);
    }

  }

  function printPage() {
    window.print();
  }

  document.addEventListener("DOMContentLoaded", function(){
    overlay = document.querySelector(".overlay");
    errorElement = document.querySelector(".error");

    deleteButton = document.querySelector(".delete");

    addButton = document.querySelector(".add");

    editButton = document.querySelector(".edit");

    uploadButton = document.querySelector(".upload");

    submitButton = document.querySelector(".submit");
    cancelButton = document.querySelector(".cancel");

    deleteButton.addEventListener("click",deleteElement);

    addButton.addEventListener("click", startAdd);

    uploadButton.addEventListener("change", uploadCSV);

    editButton.addEventListener("click", startEdit);

    cancelButton.addEventListener("click", cancelForm);

    loadTable();
    initEditForm();
  });
</script>