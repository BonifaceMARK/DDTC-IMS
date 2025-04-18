@include('layouts.header')
<body>
    
<table style="font-size:9px; width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
      <th style="padding: 10px; border: 1px solid rgb(24, 145, 60); background-color: #f0f0f0;">User</th>
      <th style="padding: 10px; border: 1px solid rgb(16, 145, 85); background-color: #f0f0f0;">Remarks</th>
      <th style="padding: 10px; border: 1px solid rgb(23, 147, 32); background-color: #f0f0f0;">Actions</th>
    </tr>
    <tbody id="remarks-list"></tbody>
    <tr>
      <td colspan="3" style="padding: 10px; border: 1px solid black; vertical-align: top;">
        <textarea id="new-remark" style="width: 100%; border: 1px solid black;" rows="3" placeholder="Write your remark here..."></textarea>
        <div style="text-align: right; margin-top: 5px;">
          <button id="add-remark-btn" style="padding: 5px 10px; background-color: #28a745; color: white; border: none;"><i class="bi bi-floppy2-fill"></i> Save</button>
        </div>
      </td>
    </tr>
  </table>
  
  <script>
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": "5000",
    };
  
    const remarksList = document.getElementById('remarks-list');
    const addRemarkBtn = document.getElementById('add-remark-btn');
    const newRemarkInput = document.getElementById('new-remark');
  
    function fetchRemarks() {
      fetch(`/units/{{ $unit->unit_id }}/fetch-remarks`)
        .then(response => response.json())
        .then(remarks => {
          remarksList.innerHTML = '';
          remarks.forEach(remark => {
            const tr = document.createElement('tr');
  
            // Username Cell
            const usernameTd = document.createElement('td');
            usernameTd.style.padding = '10px';
            usernameTd.style.border = '1px solid black';
            usernameTd.textContent = remark.user.username;
            tr.appendChild(usernameTd);
  
            // Remark Input Cell
            const remarkTd = document.createElement('td');
            remarkTd.style.padding = '10px';
            remarkTd.style.border = '1px solid black';
            const remarkInput = document.createElement('textarea');
            remarkInput.value = remark.remark;
            remarkInput.className = 'form-control form-control-sm';
            remarkInput.style.width = '100%';
            remarkInput.style.fontSize = '9px';
            remarkInput.rows = 2;
            remarkTd.appendChild(remarkInput);
            tr.appendChild(remarkTd);
  
            // Actions Cell
            const actionsTd = document.createElement('td');
            actionsTd.style.padding = '10px';
            actionsTd.style.border = '1px solid black';
  
            const saveBtn = document.createElement('button');
            saveBtn.innerHTML = '<i class="bi bi-save"></i>';
            saveBtn.className = 'btn btn-sm btn-success mx-1';
            saveBtn.title = 'Save';
            saveBtn.style.display = 'none'; // Hidden initially
  
            saveBtn.onclick = () => {
              const trimmedRemark = remarkInput.value.trim();
              if (!trimmedRemark) {
                toastr.error("Empty field can't be updated!");
                return;
              }
              editRemark(remark.id, trimmedRemark);
              saveBtn.style.display = 'none';
            };
  
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
            deleteBtn.className = 'btn btn-sm btn-danger';
            deleteBtn.title = 'Delete';
            deleteBtn.onclick = () => deleteRemark(remark.id);
  
            actionsTd.appendChild(saveBtn);
            actionsTd.appendChild(deleteBtn);
            tr.appendChild(actionsTd);
  
            // Show save button only if edited
            const originalValue = remark.remark;
            remarkInput.addEventListener('input', () => {
              if (remarkInput.value.trim() !== originalValue.trim()) {
                saveBtn.style.display = 'inline-block';
              } else {
                saveBtn.style.display = 'none';
              }
            });
  
            remarksList.appendChild(tr);
          });
        })
        .catch(error => {
          console.error('Error fetching remarks:', error);
          toastr.error('Failed to fetch remarks!');
        });
    }
  
    addRemarkBtn.addEventListener('click', () => {
      const remark = newRemarkInput.value.trim();
      if (!remark) {
        toastr.error('Remark cannot be empty!');
        return;
      }
  
      fetch(`/units/{{ $unit->unit_id }}/add-remark`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ remark }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            newRemarkInput.value = '';
            fetchRemarks();
            toastr.success('Remark added successfully!');
          } else {
            toastr.error(data.message || 'Failed to add remark.');
          }
        })
        .catch(error => {
          console.error('Error adding remark:', error);
          toastr.error('An error occurred while adding the remark.');
        });
    });
  
    function editRemark(remarkId, newRemark) {
      fetch(`/remarks/${remarkId}/edit`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ remark: newRemark }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            fetchRemarks();
            toastr.success('Remark updated successfully!');
          } else {
            toastr.error(data.message || 'Failed to update remark.');
          }
        })
        .catch(error => {
          console.error('Error editing remark:', error);
          toastr.error('An error occurred while editing the remark.');
        });
    }
  
    function deleteRemark(remarkId) {
      fetch(`/remarks/${remarkId}/delete`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            fetchRemarks();
            toastr.success('Remark deleted successfully!');
          } else {
            toastr.error(data.message || 'Failed to delete remark.');
          }
        })
        .catch(error => {
          console.error('Error deleting remark:', error);
          toastr.error('An error occurred while deleting the remark.');
        });
    }
  
    // Initial load
    fetchRemarks();
  </script>
  
  
@include('layouts.script')

</body>