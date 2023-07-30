<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

$tableName = "phone";

$itemData = getTable($conn, $tableName);

?>
<script>
    const itemData = <?php echo $itemData?>;    
    var leftDivItem = null;
    var rightDivItem = null;
    var leftDiv;
    var rightDiv;

    function loadContainer(itemId, location) {
        if (itemId) {
            location.innerHTML = itemDetails(itemId);
        } else {
            location.innerHTML = itemContainer(location);
        }
    }

    function itemDetails(itemId) {
        foundItemData = itemData.find(item => item.id === itemId);


        return `
            <div class="item-details">
            <img class="item-img" src="${foundItemData.image_url}" alt="" onerror='this.src="img/error.jpg"'>
            <p class="detail-text">Name: ${foundItemData.phone_name}</p>
            <p class="detail-text">Height: ${foundItemData.height}</p>
            <p class="detail-text">Width: ${foundItemData.width}</p>
            <p class="detail-text">Size: ${foundItemData.size}</p>
            <p class="detail-text">OS: ${foundItemData.os}</p>
            <p class="detail-text">Battery: ${foundItemData.battery}</p>
            <a href="${foundItemData.phone_url}">Phone Url</a>
            <button class='change' onclick="handleChangeButton(event)">Change</button>
            </div>
        `;
    }

    function itemContainer(location) {
        let itemListHTML = '<div class="item-list">';
        
        itemData.forEach(item => {
            itemListHTML += `<div class="compare-item" id="${item.id}" onclick="handleItemClick(event)">${item.phone_name}</div>`;
        });
        
        itemListHTML += '</div>';
        
        return itemListHTML;
    }

    function handleChangeButton (event) {
        const clickedDiv = event.target.parentElement.parentElement;
        const hasLeftDiv = clickedDiv.classList.contains('left-div');
        const hasRightDiv = clickedDiv.classList.contains('right-div');

        if (hasLeftDiv) {
            leftDivItem = null;
            loadContainer(leftDivItem, leftDiv);  
        }
        if (hasRightDiv) {
            rightDivItem = null;
            loadContainer(rightDivItem, rightDiv);
        }
    }

    function handleItemClick(event) {
        const clickedItem = event.target;
        const itemId = parseInt(clickedItem.id, 10);

        const parentContainer = clickedItem.parentElement.parentElement;
        const hasLeftDiv = parentContainer.classList.contains('left-div');
        const hasRightDiv = parentContainer.classList.contains('right-div');

        if (hasLeftDiv) {
            leftDivItem = itemId;
            loadContainer(leftDivItem, leftDiv);  
        }
        if (hasRightDiv) {
            rightDivItem = itemId;
            loadContainer(rightDivItem, rightDiv);
        }
    }


    document.addEventListener("DOMContentLoaded", function(){
        leftDiv = document.querySelector('.left-div');
        rightDiv = document.querySelector('.right-div');

        loadContainer(leftDivItem, leftDiv);
        loadContainer(rightDivItem, rightDiv);
    });
</script>