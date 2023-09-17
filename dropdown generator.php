<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Combined Example</title>
  <style>
    .input-group {
      display: flex;
      flex-direction: column;
      width: 300px;
      border: 2px solid lightgray;
      border-radius: 5px;
      transition: border-color 0.4s ease;
      position: relative;
    }
    .input-group:focus-within {
      border-color: black;
    }
    input {
      border: 1px solid transparent;
      padding: 10px;
      outline: none;
    }
    input:first-child {
      border-bottom: 0;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }
    input:last-child {
      border-top: 0;
      border-bottom-left-radius: 5px;
      border-bottom-right-radius: 5px;
    }
    /* Searchable dropdown styles */
    #dropdown {
      border: 2px solid lightgray;
      border-radius: 10px;
      position: absolute;
      top:40px;
      transform: scaleY(0);
      transform-origin: top;
      opacity: 0;
      transition: transform 0.3s ease, opacity 0.3s ease;
      pointer-events: none;
      max-height: 200px;
      width: 150px;
      overflow-y: auto;
      z-index: 1000;  /* New addition */
    }
    #dropdown.show {
      transform: scaleY(1);
      opacity: 1;
      pointer-events: auto;
    }
    #optionList {
      list-style: none;
      margin: 0;
      padding: 0;
      max-height: 150px;
      overflow-y: auto;
    }
    #optionList li {
      padding: 8px;
      cursor: pointer;
      background-color: #ffffff;
    }
    #optionList li:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<button id="generate">Generate new input</button>
<div id="container"></div>

<script>
  function createInputGroup(options) {
    // Create input group
    const inputGroup = document.createElement("div");
    inputGroup.className = "input-group";

    // Create dropdown input
    const dropdownInput = document.createElement("input");
    dropdownInput.type = "text";
    dropdownInput.placeholder = "Type to search or click for dropdown";
    dropdownInput.onclick = toggleDropdown;
    dropdownInput.oninput = filterOptions;

    // Create dropdown
    const dropdown = document.createElement("div");
    dropdown.id = "dropdown";

    const list = document.createElement("ul");
    list.id = "optionList";

    for (let option of options) {
      const li = document.createElement("li");
      li.textContent = option;
      list.appendChild(li);
    }

    dropdown.appendChild(list);

    // Create simple text input
    const textInput = document.createElement("input");
    textInput.type = "text";
    textInput.placeholder = "Second Input";

    // Append elements
    inputGroup.appendChild(dropdownInput);
    inputGroup.appendChild(dropdown);
    inputGroup.appendChild(textInput);

    return inputGroup;
  }

  function toggleDropdown() {
    const dropdown = this.nextElementSibling;
    dropdown.classList.toggle("show");
  }

  function filterOptions() {
    const filter = this.value.toUpperCase();
    const lis = this.nextElementSibling.getElementsByTagName("li");

    for (let i = 0; i < lis.length; i++) {
      const txtValue = lis[i].textContent || lis[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        lis[i].style.display = "";
      } else {
        lis[i].style.display = "none";
      }
    }
  }

  document.addEventListener("click", function(event) {
    const inputs = document.querySelectorAll(".input-group input[type='text']");
    
    for (let input of inputs) {
      const dropdown = input.nextElementSibling;
      const isClickInsideInput = input.contains(event.target);
      const isClickInsideDropdown = dropdown ? dropdown.contains(event.target) : false;

      if (!isClickInsideInput && !isClickInsideDropdown) {
        dropdown && dropdown.classList.remove("show");
      }

      if(event.target.tagName === 'LI') {
        event.target.closest(".input-group").querySelector("input[type='text']").value = event.target.textContent;
        event.target.closest("#dropdown").classList.remove("show");
      }
    }
  });

  document.getElementById("generate").addEventListener("click", function() {
    const sampleOptions = ["Option 1", "Option 2", "Option 3", "Option 4", "Option 5", "Option 6", "Option 7", "Option 8"];
    const newInputGroup = createInputGroup(sampleOptions);
    const container = document.getElementById("container");
    container.appendChild(newInputGroup);
  });
</script>

</body>
</html>