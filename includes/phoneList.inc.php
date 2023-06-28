<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "phone";

?>
<script>
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
    const phoneNameElement = document.querySelector(".tableHeader .selectedPhoneName");

    phoneNameElement.textContent = phone.phone_name;
  }

  function initializeTable() {
    const phoneData = <?php echo getTable($conn, $tableName); ?>;
    const tableBody = document.querySelector("#table tbody");

    phoneData.forEach(function(phone) {
      createTableRow(phone, tableBody);
    });
  }

  document.addEventListener("DOMContentLoaded", initializeTable);
</script>