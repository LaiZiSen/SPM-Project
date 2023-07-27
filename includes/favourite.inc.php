<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$uid = $_SESSION['uid'];

$tableName = "phone";

$itemData = getTable($conn, $tableName);
$favouriteData = getFavourites($conn, $uid);

?>
<script>
    var favourited = <?php echo $favouriteData;?>;
    var itemData = <?php echo $itemData; ?>;
    const uid = <?php echo $uid; ?>;
    const phoneDetailUrl = "suggestion.php";
    const ajaxUrl = "includes/ajaxRequest.inc.php";

    function createURL(endpoint, params) {
        const encodedParams = params.map(([key, value]) => {
        return encodeURIComponent(key) + "=" + encodeURIComponent(value);
        });

        const queryString = encodedParams.join("&");
        const url = endpoint + "?" + queryString;

        return url;
    }

    function loadFavourites (){
        const loadLocation = document.querySelector('.favourite-grid');

        favourited.forEach(function(favouritedData) {
            const data = itemData.filter(item => item.id === favouritedData.phone_id);
            createItem(data, loadLocation);
        })
    }

    function createItem (data, location){
        itemHTML = generateHtml(data[0].image_url, data[0].phone_name);

        const tempContainer = document.createElement("div");
        tempContainer.innerHTML = itemHTML;

        const favouriteCard = tempContainer.firstElementChild;

        const imageElement = favouriteCard.querySelector(".item-img");
        imageElement.addEventListener("click", function () {
            openPhonePage(data[0].id);
        })

        const nameElement = favouriteCard.querySelector(".item-name");
        nameElement.addEventListener("click", function () {
            openPhonePage(data[0].id);
        });

        const deleteElement = favouriteCard.querySelector(".fas");
        deleteElement.addEventListener("click", function (event) {
            const element = event.target.parentElement;
            removeFavourite(element, data[0].id, favouriteCard);
        });

        // location.insertAdjacentHTML("beforeend", itemHTML);
        location.appendChild(favouriteCard);
    }

    function generateHtml(image_url, phone_name){
        return `
        <div class='favourite-item'>
                <img class='item-img'src=${image_url} alt="" onerror='this.src="img/error.jpg"'>
                <p class='item-name'>${phone_name}</p>
                <div class="delete-element" aria-label="Delete">
                    <i class="fas fa-trash"></i>
                </div>
        </div>
        `;
    }

    function openPhonePage (phone_id) {
        window.location.href = createURL(phoneDetailUrl, [["phone_id", phone_id]]);
    }

    async function removeFavourite(element, phone_id, card) {
        console.log('deleted');
        var prams = [
                ['method', 'removeFavourite'], 
                ['phone_id', phone_id], 
                ['user_id', uid]
            ];
        const url = createURL(ajaxUrl, prams);

        await fetch(url);
        card.remove();
    }

    document.addEventListener("DOMContentLoaded", function(){
        loadFavourites();
    });

</script>