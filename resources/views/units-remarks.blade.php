@include('layouts.header')
<body>

    <div>
        <table class="table table-bordered table-sm" style="width: 100%; margin: 0;">
            <thead class="bg-primary text-white">
                <tr>
                    <th colspan="2" class="text-center">
                        <i class="bi bi-highlighter"></i> Add Remark
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- Remarks List -->
                <tr>
                    <td colspan="2" style="padding: 0;">
                        <div class="remarks-container" 
                             style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; 
                                    padding: 5px; background-color: #f9f9f9; scrollbar-width: thin; scrollbar-color: #888 #f9f9f9;">
                            <ul id="remarks-list" style="list-style: none; padding: 0; margin: 0;">
                                <!-- Dynamic content will be inserted here -->
                                <li style="display: flex; flex-wrap: wrap; align-items: center; margin-bottom: 5px;">
                                    <input 
                                        type="text" 
                                        value="This is a very long remark that will automatically wrap into a new row if it does not fit within the current row." 
                                        class="form-control form-control-sm" 
                                        style="flex: 1 1 auto; margin-right: 10px; min-width: 200px;" 
                                        readonly>
                                    <button class="btn btn-outline-primary btn-sm me-1 edit-btn" style="white-space: nowrap;">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm delete-btn" style="white-space: nowrap;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </li>
                                
                            </ul>
                        </div>
                    </td>
                </tr>
                
                
    
                <!-- Add New Remark Section -->
                <tr>
                    <td style="width: 70%; padding-right: 10px;">
                        <textarea 
                            id="new-remark" 
                            class="form-control form-control-sm" 
                            rows="2" 
                            placeholder="Write your remark here..." 
                            style="resize: none; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
                        </textarea>
                    </td>
                    <td style="width: 30%; text-align: center;">
                        <button id="add-remark-btn" class="btn btn-success btn-sm w-100">Add Remark</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <script>
        const remarksList = document.getElementById('remarks-list');
        const addRemarkBtn = document.getElementById('add-remark-btn');
        const newRemarkInput = document.getElementById('new-remark');
        
        // Fetch and display remarks
        function fetchRemarks() {
            fetch(`/units/{{ $unit->rec_id }}/fetch-remarks`)
                .then(response => response.json())
                .then(remarks => {
                    remarksList.innerHTML = ''; // Clear the list
                    remarks.forEach(remark => {
                        const li = document.createElement('li');
                        li.style.display = 'flex';
                        li.style.alignItems = 'center';
                        li.style.marginBottom = '10px';
                        
                        // Remark content as a readonly input
                        const remarkInput = document.createElement('input');
                        remarkInput.type = 'text';
                        remarkInput.value = `${remark.user.username}: ${remark.remark}`; // Display user's name and remark
                        remarkInput.className = 'form-control form-control-sm';
                        remarkInput.style.flex = '1';
                        remarkInput.readOnly = true;
                        li.appendChild(remarkInput);
    
                        // Edit button
                        const editBtn = document.createElement('button');
                        editBtn.className = 'btn btn-outline-primary btn-sm mx-1';
                        editBtn.innerHTML = '<i class="bi bi-pencil-square"></i>';
                        editBtn.onclick = () => {
                            const newRemark = prompt('Edit your remark:', remark.remark);
                            if (newRemark) {
                                editRemark(remark.id, newRemark);
                            }
                        };
                        li.appendChild(editBtn);
    
                        // Delete button
                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-outline-danger btn-sm';
                        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteBtn.onclick = () => {
                            if (confirm('Are you sure you want to delete this remark?')) {
                                deleteRemark(remark.id);
                            }
                        };
                        li.appendChild(deleteBtn);
    
                        remarksList.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching remarks:', error));
        }
    
        // Add a new remark
        addRemarkBtn.addEventListener('click', () => {
            const remark = newRemarkInput.value;
    
            if (!remark.trim()) {
                alert('Remark cannot be empty!');
                return;
            }
    
            fetch(`/units/{{ $unit->rec_id }}/add-remark`, {
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
                        newRemarkInput.value = ''; // Clear the input
                        fetchRemarks(); // Refresh the remarks list
                    } else {
                        alert(data.message); // Handle errors
                    }
                })
                .catch(error => console.error('Error adding remark:', error));
        });
    
        // Edit an existing remark
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
                        fetchRemarks(); // Refresh the remarks list
                    } else {
                        alert(data.message); // Handle errors
                    }
                })
                .catch(error => console.error('Error editing remark:', error));
        }
    
        // Delete a remark
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
                        fetchRemarks(); // Refresh the remarks list
                    } else {
                        alert(data.message); // Handle errors
                    }
                })
                .catch(error => console.error('Error deleting remark:', error));
        }
    
        // Initial load
        fetchRemarks();
    </script>
    


</body>