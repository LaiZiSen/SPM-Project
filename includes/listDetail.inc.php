<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$phone_id = $_GET['phone_id'];
$phone_data = getElement($conn, "phone", $phone_id);

?>
<script>
    var phone_data = <?php echo $phone_data;?>[0];

    function generateHTML() {
        return `
            <p class='title'>${phone_data.phone_name}</p>
            <div class='info-box'>
                <div class='img-box'>
                    <img class='item-img' src="${phone_data.image_url}" alt="" onerror='this.src="img/error.jpg"'>
                </div>
                <div class='info-list'>
                    <p> Height: ${phone_data.height}</p>
                    <p> Width: ${phone_data.width}</p>
                    <p> Size: ${phone_data.size}</p>
                    <p> OS: ${phone_data.os}</p>
                    <p> Battery: ${phone_data.battery}</p>
                    <a href="${phone_data.phone_url}" target="_blank" onerror='this.src="img/error.jpg"'>Phone Url</a>
                </div>
            </div>
        `;
    }



    document.addEventListener("DOMContentLoaded", function(){
        const location = document.querySelector('.content');

        location.innerHTML = generateHTML();
    });
</script>