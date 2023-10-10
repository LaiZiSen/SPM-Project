document.addEventListener('DOMContentLoaded', () => {
    // Get the table element by its class
    const table = document.getElementById('table');
    const changeFontSizeButton = document.getElementById('changeFontSize');

    // Define the initial font size and the maximum font size
    let currentFontSize = 16;
    const maxFontSize = 20;
    const minFontSize = 10;

    // Add an event listener to the button
    changeFontSizeButton.addEventListener('click', () => {
        // Increase the font size by 2
        currentFontSize += 2;

        // Ensure the font size stays within the range
        if (currentFontSize > maxFontSize) {
            currentFontSize = minFontSize;
        }

        // Apply the new font size to the entire table
        table.style.fontSize = currentFontSize + 'px';
    });
});
