document.addEventListener("DOMContentLoaded", () => {
    const checkboxList = document.getElementById("checkbox-list");
    const checkboxes = checkboxList.querySelectorAll("input[type='checkbox']");
  
    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", () => {
        updateVisibility();
      });
    });
  
    function updateVisibility() {
      checkboxes.forEach((checkbox) => {
        const label = checkbox.parentElement;
        if (!checkbox.checked) {
          label.style.display = "none";
        } else {
          label.style.display = "block";
        }
      });
    }
  });
  