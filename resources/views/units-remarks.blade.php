@include('layouts.header')
<body style="font-family: Arial, sans-serif; background-color: #eef2f5; padding: 20px;">

    <div style="max-width: 800px; margin: auto;">
        
        <!-- Remarks List -->
        <div>
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <ul id="remarks-list" style="list-style: none; padding: 0; margin: 0;">
                    <!-- Dynamic content will be inserted here -->
                    <li style="display: flex; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
                        <!-- Readonly Input -->
                        <textarea 
                            type="text" 
                            value=""
                            rows="3" 
                            style="flex-grow: 1; border: none; padding: 9px; font-size: 9px; background-color: #f9f9f9; border-radius: 4px;" 
                            readonly>
                    </textarea>
                        <!-- Edit and Delete Buttons -->
                        <div style="margin-left: 9px; display: flex; gap: 5px;">
                            <button style="border: none; background-color: #007bff; color: #fff; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                Edit
                            </button>
                            <button style="border: none; background-color: #dc3545; color: #fff; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                Delete
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    
        <!-- Add New Remark Section -->
        <div style="display: flex; gap: 9px;">
            <textarea 
                id="new-remark" 
                style="flex: 2; resize: none; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;" 
                rows="3" 
                placeholder="Write your remark here...">
            </textarea>
            <button id="add-remark-btn" style="flex: 1;font-size:9px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                Add Remark
            </button>
        </div>
    </div>
    <script>
        function openEditModal(remark) {
            document.getElementById('edit-modal').style.display = 'block';
            document.getElementById('edit-remark-input').value = remark;
        }

        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
        }

        function saveEditedRemark() {
            const newRemark = document.getElementById('edit-remark-input').value;
            alert(`Saved remark: ${newRemark}`); // Replace with actual save logic
            closeEditModal();
        }
    </script>
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