//Old Prototype

document.addEventListener("DOMContentLoaded", function() {
  const phoneData = [
      {
          id: 1,
          phone_name: "Huawei Mate 50",
          height: "161.5 mm",
          width: "76.1 mm",
          size: "6.7\"",
          os: "Android",
          brand: "Huawei",
          battery: "4460 mAh",
          image_url: "https://files.gsmchoice.com/phones/huawei-mate-50/huawei-mate-50-01.jpg",
          phone_url: "https://consumer.huawei.com/en/phones/mate50/specs/"
        },
        {
          id: 2,
          phone_name: "iPhone 14 Pro",
          height: "147.5 mm",
          width: "71.5 mm",
          size: "6.1\"",
          os: "iOS",
          brand: "Apple",
          battery: "4323 mAh",
          image_url: "https://technave.com/data/files/article/202209090148323176.jpg",
          phone_url: "https://www.apple.com/my/iphone-14-pro/specs/"
        }
  ];

  const tableBody = document.querySelector("#table tbody");
  let selectedRow = null;

  function createTableRow(phone) {
    const row = document.createElement("tr");
    row.addEventListener("click", function() {
      if (selectedRow) {
        selectedRow.classList.remove("selected");
      }
      this.classList.add("selected");
      selectedRow = this;
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

  phoneData.forEach(function(phone) {
    createTableRow(phone);
  });
});