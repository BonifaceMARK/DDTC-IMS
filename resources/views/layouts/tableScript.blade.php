
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#excelTable tbody');

    // Detect changes in any cell and mark the row as changed
    table.addEventListener('input', function (event) {
        const row = event.target.closest('tr');
        if (row) {
            row.setAttribute('data-changed', 'true'); // Mark the row as changed
        }
    });

    document.getElementById('saveChanges').addEventListener('click', function () {
        let editedRows = [];
        const columnNames = [
         'categ', 'sku', 'desc', 'allocation',
             'prop_tag', 'unit_stat',
            'vendor_type', 'pmg_stats',  'sales_stats', 'sales_remarks'
        ];

        // Helper function to chunk the data into smaller arrays
        const chunkArray = (arr, size) => {
            const chunks = [];
            for (let i = 0; i < arr.length; i += size) {
                chunks.push(arr.slice(i, i + size));
            }
            return chunks;
        };

        // Loop through all rows and collect only edited rows
        document.querySelectorAll('#excelTable tbody tr[data-changed="true"]').forEach(row => {
            let rowData = { rec_id: row.getAttribute('data-rec-id') }; // Get the unique rec_id for the row

            if (!rowData.rec_id) {
                console.error('Missing rec_id for row:', row); // Log missing rec_id
                return;
            }

            // Map the data by column names
            row.querySelectorAll('td').forEach((cell, index) => {
                if (index === 16) return; // Skip the "View" button column
                rowData[columnNames[index]] = cell.querySelector('select') 
                    ? cell.querySelector('select').value 
                    : cell.textContent.trim();
            });

            editedRows.push(rowData);
        });

        console.log('Edited Rows:', editedRows); // Debugging: Log the array

        // Split the data into chunks of 100 rows each
        const chunks = chunkArray(editedRows, 100);

        // Track the number of units (edited rows)
        const totalUnits = editedRows.length;

        // Notify the user about the total units being updated
        if (totalUnits > 0) {
            toastr.info(`${totalUnits} unit(s) edited. Starting updates...`, 'Info');
        } else {
            toastr.warning('No changes detected. No updates required.', 'Warning');
            return;
        }

        // Process each chunk sequentially
        let updatedUnits = 0;

        chunks.forEach((chunk, index) => {
            fetch('/update-units', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ units: chunk }) // Send the chunk as JSON
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updatedUnits += chunk.length; // Increment counter for successful units
                    console.log(`Unit ${index + 1} updated successfully.`);
                    toastr.success(`Units updated successfully. Total: ${updatedUnits}/${totalUnits}.`, 'Success');
                } else {
                    console.error(`Unit ${index + 1} failed.`, data);
                    toastr.error(`Some units failed to update.`, 'Error');
                }
            })
            .catch(error => {
                console.error(`Error updating Unit ${index + 1}:`, error);
                toastr.error(`An error occurred while updating units.`, 'Error');
            });
        });
    });
});

  
  
  </script>
  