@include('layouts.header')
<body>

    <div class="container-fluid">
        <script>
            @if(session('success'))
                toastr.success("{{ session('success') }}", 'Success', {
                    closeButton: true,
                    // progressBar: true,
                    positionClass: 'toast-top-right',
                });
            @endif
        
            @if(session('error'))
                toastr.error("{{ session('error') }}", 'Error', {
                    closeButton: true,
                    // progressBar: true,
                    positionClass: 'toast-top-right',
                });
            @endif
        </script>
        
        <!-- Display Attachments with Upload Section -->
        <table style="font-size:9px; width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="padding: 10px; border: 1px solid rgb(24, 145, 60); background-color: #f0f0f0;">File Name</th>
                    <th style="padding: 10px; border: 1px solid rgb(16, 145, 85); background-color: #f0f0f0;">Type</th>
                    <th style="padding: 10px; border: 1px solid rgb(23, 147, 32); background-color: #f0f0f0;">Size (KB)</th>
                    <th style="padding: 10px; border: 1px solid rgb(24, 145, 60); background-color: #f0f0f0;">Uploaded At</th>
                    <th style="padding: 10px; border: 1px solid rgb(16, 145, 85); background-color: #f0f0f0;">Remarks</th>
                    <th style="padding: 10px; border: 1px solid rgb(23, 147, 32); background-color: #f0f0f0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attachments as $attachment)
                    <tr>
                        <td style="padding: 10px; border: 1px solid black;">{{ $attachment->file_name }}</td>
                        <td style="padding: 10px; border: 1px solid black;">{{ $attachment->file_type }}</td>
                        <td style="padding: 10px; border: 1px solid black;">{{ $attachment->file_size }}</td>
                        <td style="padding: 10px; border: 1px solid black;">{{ $attachment->uploaded_at }}</td>
                        <td style="padding: 10px; border: 1px solid black;">{{ $attachment->file_remarks ?? 'None' }}</td>
                        <td style="padding: 10px; border: 1px solid black; text-align: center;">
                            <a href="{{ route('attachments.download', $attachment->attachment_id) }}" style="color: #007bff; text-decoration: none;">Download</a> |
                            <form id="delete-form-{{ $attachment->attachment_id }}" action="{{ route('attachments.delete', $attachment->attachment_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" style="font-size:10px;" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $attachment->attachment_id }})"><i class="bi bi-trash"></i></button>
                            </form>
                            
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 10px; border: 1px solid black; text-align: center;">No attachments found for this unit.</td>
                    </tr>
                @endforelse
       <!-- Upload New Attachment Row -->
<tr>
    <td colspan="6" class="p-4 bg-light border rounded shadow-sm">
        <form action="{{ route('attachments.upload', $unit->unit_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 align-items-center">
                <!-- File Input -->
                <div class="col-md-4">
                    <label for="file" style="font-size:10px;" class="form-label text-uppercase text-muted fw-bold small">Choose File:</label>
                    <input type="file" style="font-size:10px;" name="file" id="file" class="form-control rounded">
                    @error('file')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="col-md-5">
                    <label for="file_remarks" class="form-label text-uppercase text-muted fw-bold small">Remarks (Optional):</label>
                    <textarea name="file_remarks" style="font-size:10px;" id="file_remarks" rows="1" class="form-control rounded small-text"></textarea>
                </div>

                <!-- Upload Button -->
                <div class="col-md-3 text-center mt-4">
                    <button type="submit" style="font-size:9px;" class="btn btn-success fw-bold text-uppercase rounded"><i class="bi bi-upload"></i> Upload</button>
                </div>
            </div>
        </form>
    </td>
</tr>

                <!-- Add some additional hover effects to improve the feel -->
               
                
            </tbody>
        </table>

    </div>
    <script>
        function confirmDelete(id) {
            toastr.clear(); // clear previous toasts
            toastr.warning(
                `
                <div>
                    <p style="margin: 0;">Are you sure you want to delete this attachment?</p>
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="submitDelete(${id})">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" onclick="toastr.clear()">Cancel</button>
                </div>
                `,
                '',
                {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    allowHtml: true,
                    tapToDismiss: false,
                    positionClass: 'toast-top-center'
                }
            );
        }
    
        function submitDelete(id) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    </script>
    
@include('layouts.script')

</body>
