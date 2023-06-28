<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "user";

?>
<script src="includes/table.inc.js" ></script>
<script>
  function initializeTable() {
    const phoneData = <?php echo getTable($conn, $tableName); ?>;
    const tableBody = document.querySelector("#table tbody");

    phoneData.forEach(function(phone) {
      createTableRow(phone, tableBody);
    });
  }

  document.addEventListener("DOMContentLoaded", initializeTable);
</script>