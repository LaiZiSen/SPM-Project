<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "user";

?>
<script src="includes/table.inc.js" ></script>
<script>
  var selectedData;
  var deleteButton;
  var ajaxUrl = "includes/ajaxRequest.inc.php";

  function createURL(endpoint, params) {
    const encodedParams = params.map(([key, value]) => {
      return encodeURIComponent(key) + "=" + encodeURIComponent(value);
    });

    const queryString = encodedParams.join("&");
    const url = endpoint + "?" + queryString;

    return url;
  }

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

  function printPage() {
    window.print();
  }

  document.addEventListener("DOMContentLoaded", function(){
    deleteButton = document.querySelector(".delete");

    deleteButton.addEventListener("click",deleteElement);

    loadTable();
    
  });
</script>