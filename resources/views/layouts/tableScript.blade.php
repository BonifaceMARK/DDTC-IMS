
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#excelTable tbody');

    table.addEventListener('input', function (event) {
        const row = event.target.closest('tr');
        if (row) {
            row.setAttribute('data-changed', 'true'); // Mark the row as changed
        }
    });

    document.getElementById('saveChanges').addEventListener('click', function () {
        let editedRows = [];
        const columnNames = [
         'categ', 'model', 'sku', 'desc','ser_no','location','vendor_com',null,
         'allocation', 'unit_stat', 'vendor_type', 'pmg_stats',  'sales_stats', 'sales_remarks','cust_po_ref'
        ];

        const chunkArray = (arr, size) => {
            const chunks = [];
            for (let i = 0; i < arr.length; i += size) {
                chunks.push(arr.slice(i, i + size));
            }
            return chunks;
        };

        document.querySelectorAll('#excelTable tbody tr[data-changed="true"]').forEach(row => {
            let rowData = { unit_id: row.getAttribute('data-rec-id') }; // Get the unique unit_id for the row

            if (!rowData.unit_id) {
                console.error('Missing unit_id for row:', row); // Log missing unit_id
                return;
            }

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