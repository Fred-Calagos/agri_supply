window.getStrand = function (trackId, isEdit = false) {
    console.log("Selected Track:", trackId);

    let strandSelect = isEdit 
        ? document.getElementById("edit_strand_id") 
        : document.getElementById("strand");

    // Reset strand dropdown
    strandSelect.innerHTML = '<option value="0" selected hidden>Select Strand</option>';

    if (trackId === "0") {
        return; // Exit if no valid track is selected
    }

    fetch("/strand", {  // Ensure correct PHP route
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "trackId=" + encodeURIComponent(trackId),
    })
    .then(response => response.json())  
    .then(data => {
        console.log("Response data:", data); // Debugging Log

        if (data.length === 0) {
            console.log("No strands found for the selected track.");
            return;
        }

        data.forEach(strand => {
            strandSelect.innerHTML += `<option value="${strand.id}">${strand.strand_name}</option>`;
        });
    })
    .catch(error => console.error("Error fetching strands:", error));
};
