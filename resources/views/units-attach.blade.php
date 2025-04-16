@include('layouts.header')

<body>
    <h1>Attachment Management</h1>
    
    <!-- Attachment Table -->
    <table style="font-size:9px; width: 100%; border: 1px solid black; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px; border: 1px solid rgb(24, 145, 60); background-color: #f0f0f0;">User</th>
                <th style="padding: 10px; border: 1px solid rgb(16, 145, 85); background-color: #f0f0f0;">Attachment</th>
                <th style="padding: 10px; border: 1px solid rgb(23, 147, 32); background-color: #f0f0f0;">Actions</th>
            </tr>
        </thead>
        <tbody id="attachment-list">
            @foreach($attachments as $attachment)
                <tr>
                    <td style="padding: 10px; border: 1px solid black;">
                        {{ $attachment->user->username ?? 'N/A' }}
                    </td>
                    <td style="padding: 10px; border: 1px solid black;">
                        <a href="{{ asset('storage/' . $attachment->att_file) }}" target="_blank">View Attachment</a>
                    </td>
                    <td style="padding: 10px; border: 1px solid black;">
                        <form method="POST" action="{{ route('attach.delete', $attachment->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 5px; background-color: #d9534f; color: white; border: none;">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form id="add-attachment-form" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="file" id="file-attachment" name="att_file" required />
      <textarea name="remarks" placeholder="Add remarks (optional)" rows="3"></textarea>
      <button type="submit">Add Attachment</button>
  </form>
  
  
</body>

<script>
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": "5000",
  };

  const attachmentForm = document.getElementById('add-attachment-form');
  const fileInput = document.getElementById('file-attachment');

  // Submit Form to Add Attachment
  attachmentForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const file = fileInput.files[0];
      if (!file) {
          toastr.error('Please select a file to upload!');
          return;
      }

      console.log('File being uploaded:', {
          name: file.name,
          size: file.size,
          type: file.type
      });

      const formData = new FormData();
      formData.append('att_file', file);

      fetch(`/units/{{ $unit->rec_id }}/add-attachment`, {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: formData,
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              toastr.success('Attachment added successfully!');
              fetchAttachments(); // Refresh the table
              fileInput.value = ''; // Clear input field
          } else {
              toastr.error(data.message || 'Failed to add attachment.');
          }
      })
      .catch(error => {
          console.error('Error adding attachment:', error);
          toastr.error(`An error occurred: ${error.message || 'Unknown error.'}`);
      });
  });

  // Fetch Attachments
  function fetchAttachments() {
      fetch(`/units/{{ $unit->rec_id }}/fetch-attachments`)
          .then(response => response.json())
          .then(attachments => {
              const attachmentList = document.getElementById('attachment-list');
              attachmentList.innerHTML = '';
              
              if (attachments.length === 0) {
                  const emptyRow = document.createElement('tr');
                  emptyRow.innerHTML = '<td colspan="3" style="text-align: center;">No attachments found.</td>';
                  attachmentList.appendChild(emptyRow);
              }

              attachments.forEach(attachment => {
                  const tr = document.createElement('tr');
                  const usernameTd = document.createElement('td');
                  usernameTd.textContent = attachment.user.username ?? 'N/A';
                  usernameTd.style.padding = '10px';
                  usernameTd.style.border = '1px solid black';
                  tr.appendChild(usernameTd);

                  const fileTd = document.createElement('td');
                  const fileLink = document.createElement('a');
                  fileLink.href = `/storage/${attachment.att_file}`;
                  fileLink.target = '_blank';
                  fileLink.textContent = 'View Attachment';
                  fileTd.style.padding = '10px';
                  fileTd.style.border = '1px solid black';
                  fileTd.appendChild(fileLink);
                  tr.appendChild(fileTd);

                  const actionsTd = document.createElement('td');
                  const deleteBtn = document.createElement('button');
                  deleteBtn.textContent = 'Delete';
                  deleteBtn.style.padding = '5px';
                  deleteBtn.style.backgroundColor = '#d9534f';
                  deleteBtn.style.color = '#fff';
                  deleteBtn.onclick = () => deleteAttachment(attachment.id);
                  actionsTd.style.padding = '10px';
                  actionsTd.style.border = '1px solid black';
                  actionsTd.appendChild(deleteBtn);
                  tr.appendChild(actionsTd);

                  attachmentList.appendChild(tr);
              });
          })
          .catch(error => {
              console.error('Error fetching attachments:', error);
              toastr.error('Failed to fetch attachments!');
          });
  }

  // Delete Attachment
  function deleteAttachment(attachmentId) {
      fetch(`/attachments/${attachmentId}/delete`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              toastr.success('Attachment deleted successfully!');
              fetchAttachments(); // Refresh the table
          } else {
              toastr.error(data.message || 'Failed to delete attachment.');
          }
      })
      .catch(error => {
          console.error('Error deleting attachment:', error);
          toastr.error(`An error occurred: ${error.message || 'Unknown error.'}`);
      });
  }

  // Initial fetch of attachments on page load
  fetchAttachments();
</script>


@include('layouts.script')
