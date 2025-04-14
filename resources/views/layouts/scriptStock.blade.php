

     {{-- FOR EDITING --}}
    <script>
        function redirectToEditPage(rec_id) {
            let route = `{{ route('edit.whitehouse', ':rec_id') }}`;
            route = route.replace(':rec_id', rec_id); 
            window.location.href = route;
        }
    </script>

    




{{-- <script>
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
</script> --}}

<script>
    function filterByDate(date) {
        const url = new URL(window.location.href);
        url.searchParams.set('specific_date', date); // Set the specific date parameter
        window.location.href = url.toString(); // Redirect to the updated URL
    }
</script>