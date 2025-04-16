@include('layouts.header')
<body>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <table style="font-size:9px; width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <th style="padding: 10px; border: 1px solid rgb(24, 145, 60); background-color: #f0f0f0;">User</th>
            <th style="padding: 10px; border: 1px solid rgb(16, 145, 85); background-color: #f0f0f0;">Attachment</th>
            <th style="padding: 10px; border: 1px solid rgb(23, 147, 32); background-color: #f0f0f0;">Actions</th>
        </tr>
        <tbody id="attachments-list">
            <!-- Uploaded data would populate here -->
        </tbody>
        <tr>
            <td colspan="3" style="padding: 10px; border: 1px solid black; vertical-align: top;">
                <form action="{{ route('unit.upload.attachment', $unit->rec_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file_att">
                    <button type="submit">Upload</button>
                </form>
                
            </td>
        </tr>
    </table>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchAttachments();
        
            function fetchAttachments() {
                fetch("{{ route('unit.fetch.attachments', $unit->rec_id) }}")
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById("attachments-list");
                        tbody.innerHTML = '';
        
                        if (Array.isArray(data)) {
                            data.forEach(attachment => {
                                const tr = document.createElement("tr");
                                tr.innerHTML = `
                                    <td style="border: 1px solid black;">${attachment.user?.name || 'Unknown'}</td>
                                    <td style="border: 1px solid black;"><a href="/storage/${attachment.att_dir}" target="_blank">View File</a></td>
                                    <td style="border: 1px solid black;">Actions here</td>
                                `;
                                tbody.appendChild(tr);
                            });
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }
        });
        </script>
        
@include('layouts.script')

</body>