

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


     {{-- FOR EDITING --}}
    <script>
        function redirectToEditPage(rec_id) {
            let route = `{{ route('edit.whitehouse', ':rec_id') }}`;
            route = route.replace(':rec_id', rec_id); 
            window.location.href = route;
        }
    </script>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
    
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>

    {{-- FOR TABLE SELECTOR --}}
    
    <script>
        document.addEventListener('keydown', function (event) {
            const activeCell = document.activeElement;

            if (!activeCell || activeCell.tagName !== 'TD') return;

            const table = document.getElementById('excelTable');
            const rows = Array.from(table.getElementsByTagName('tr'));
            const cells = Array.from(activeCell.parentElement.children);
            const currentRowIndex = rows.indexOf(activeCell.parentElement);
            const currentCellIndex = cells.indexOf(activeCell);

            switch (event.key) {
                case 'ArrowUp': // Move up
                    if (currentRowIndex > 0) {
                        const targetCell = rows[currentRowIndex - 1].children[currentCellIndex];
                        targetCell.focus();
                    }
                    break;
                case 'ArrowDown': // Move down
                    if (currentRowIndex < rows.length - 1) {
                        const targetCell = rows[currentRowIndex + 1].children[currentCellIndex];
                        targetCell.focus();
                    }
                    break;
                case 'ArrowLeft': // Move left
                    if (currentCellIndex > 0) {
                        const targetCell = cells[currentCellIndex - 1];
                        targetCell.focus();
                    }
                    break;
                case 'ArrowRight': // Move right
                    if (currentCellIndex < cells.length - 1) {
                        const targetCell = cells[currentCellIndex + 1];
                        targetCell.focus();
                    }
                    break;
            }
        });

        document.addEventListener('focusin', function (event) {
            const activeCell = event.target;
            if (activeCell && activeCell.tagName === 'TD') {
                const range = document.createRange();
                const selection = window.getSelection();
                range.selectNodeContents(activeCell);
                selection.removeAllRanges();
                selection.addRange(range);
            }
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
<script>
  // Wait for the DOM content to fully load
  document.addEventListener("DOMContentLoaded", function () {
      const table = document.getElementById("unitTable"); // ID of your table
      const rows = table.querySelectorAll("tbody tr"); // All table rows in the table body

      window.filterByCompany = function (selectedCompany) {
          rows.forEach(row => {
              const companyCell = row.querySelector("td:first-child"); // Target the first cell (Company column)
              if (selectedCompany === "" || companyCell.textContent.trim() === selectedCompany) {
                  row.style.display = ""; // Show matching rows
              } else {
                  row.style.display = "none"; // Hide non-matching rows
              }
          });
      };
  });
</script>