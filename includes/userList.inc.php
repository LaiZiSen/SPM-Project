<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "user";

?>
<script src="includes/table.inc.js" ></script>
<script>
  var selectedData;

  function initializeTable() {
    const tableData = <?php echo getTable($conn, $tableName); ?>;
    const tableBody = document.querySelector("#table tbody");

    tableData.forEach(function(rowData) {
      createTableRow(rowData, tableBody);
    });
  }

  document.addEventListener("DOMContentLoaded", initializeTable);
</script>