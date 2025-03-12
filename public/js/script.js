


function toggleDisabilityOptions() {
    var disabilitySelect = document.getElementById("learnerDisability").value;
    var disabilityOptions = document.getElementById("disabilityOptions");

    if (disabilitySelect === "yes") {
      disabilityOptions.style.display = "block";  // Show disability options
    } else {
      disabilityOptions.style.display = "none";   // Hide disability options
    }
  }
  function toggleSublist(parentCheckboxId, sublistId) {
    var parentCheckbox = document.getElementById(parentCheckboxId);
    var sublist = document.getElementById(sublistId);

    // Show sublist only if parent checkbox is checked
    sublist.style.display = parentCheckbox.checked ? "block" : "none";
}

$(document).ready(function() {
  $('#myTable').DataTable();
});