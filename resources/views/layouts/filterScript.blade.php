

{{-- FOR SEARCH BAR  --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("excelTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    const selectElement = cell.querySelector("select");

                    if (selectElement) {
                        // Check selected option text
                        const selectedOptionText = selectElement.options[selectElement.selectedIndex].text.toLowerCase();
                        if (selectedOptionText.includes(filter)) {
                            match = true;
                            break;
                        }
                    } else {
                        // Check regular cell text
                        const cellText = cell.textContent.toLowerCase();
                        if (cellText.includes(filter)) {
                            match = true;
                            break;
                        }
                    }
                }

                row.style.display = match ? "" : "none";
            }
        });
    });
</script>


<script>
    function filterByLocation() {
        const location = document.getElementById('locationDropdown').value;
        const url = new URL(window.location.href);
  
        // Update the 'location' parameter
        if (location && location !== "all_locations") {
            url.searchParams.set('location', location);
        } else {
            url.searchParams.delete('location'); // Clear the filter if "All Locations" is selected
        }
  
        // Redirect to the updated URL
        window.location.href = url.toString();
    }
  </script>