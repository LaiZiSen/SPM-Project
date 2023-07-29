<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$uid = $_SESSION['uid'];

$tableName = "phone";

$itemData = getTable($conn, $tableName);
$favouriteData = getFavourites($conn, $uid);

?>
<script>
    var favourites = <?php echo $favouriteData;?>;
    const localUrl = "suggestion.php";
    const ajaxUrl = "includes/ajaxRequest.inc.php";

    function createURL(endpoint, params) {
        const encodedParams = params.map(([key, value]) => {
        return encodeURIComponent(key) + "=" + encodeURIComponent(value);
        });

        const queryString = encodedParams.join("&");
        const url = endpoint + "?" + queryString;

        return url;
    }

    function loadItems(){
        const itemData = <?php echo $itemData;?>;
        const loadLocation = document.querySelector('.suggestion-list');

        console.log(itemData);
        console.log(favourites);

        itemData.forEach(function(itemData){ 
            createItem(itemData, favourites ,loadLocation);
        });

        const comparePageButton = document.querySelector('.compare-button');
        comparePageButton.addEventListener("click", function () {
            window.location.href = "compare.php";
        })

    }

    function createItem(phone, favourites, location){
        favourited = favourites.some(item => item.phone_id === phone.id);

        itemHTML = generateHtml(phone.image_url, phone.phone_name, favourited);

        const tempContainer = document.createElement("div");
        tempContainer.innerHTML = itemHTML;

        const suggestionCardElement = tempContainer.firstElementChild;

        const nameElement = suggestionCardElement.querySelector(".item-name");
        nameElement.addEventListener("click", function () {
            openPhonePage(phone.id);
        });

        const imgElement = suggestionCardElement.querySelector(".item-img");
        imgElement.addEventListener("click", function () {
            openPhonePage(phone.id);
        });

        const favouriteElement = suggestionCardElement.querySelector(".fas");
        favouriteElement.addEventListener("click", function (event) {
            const element = event.target.parentElement;
            toggleFavourite(element, phone.id);
        });

        location.appendChild(suggestionCardElement);
    }

    function generateHtml(image_url, phone_name, favourited){
        return `
            <div class="suggestion-card">
            <img class="item-img" src="${image_url}" onerror='this.src="img/error.jpg"'>
            <div class='item-info'>
                <p class='item-name'>${phone_name}</p>
                <div class="favourite-element ${favourited ? 'favourite' : ''}" aria-label="Favourite">
                <i class="fas fa-star"></i>
                </div>
            </div>
            </div>
        `;
    }

    function openPhonePage (phone_id) {
        window.location.href = createURL(localUrl, [["phone_id", phone_id]]);
    }

    async function toggleFavourite(element, phone_id){
        console.log(`Toggled Favourite for ${phone_id}`);
        console.log(element);

        const isFavourite = element.classList.contains('favourite');
        
        if (isFavourite) {
            var prams = [
                ['method', 'removeFavourite'], 
                ['phone_id', phone_id], 
                ['user_id', <?php echo $uid ?>]
            ];
            const url = createURL(ajaxUrl, prams);

            await fetch(url);

            element.classList.remove("favourite");
            favourites = favourites.filter(item => item.phone_id !== phone_id);

            console.log(favourites);
        } else {
            var prams = [
                ['method', 'addFavourite'], 
                ['phone_id', phone_id], 
                ['user_id', <?php echo $uid ?>]
            ];
            const url = createURL(ajaxUrl, prams);

            await fetch(url);

            element.classList.add("favourite");
            favourites.push({'phone_id' : phone_id});

            console.log(favourites);
        }
    }

    document.addEventListener("DOMContentLoaded", function(){
        loadItems();
    });
</script>