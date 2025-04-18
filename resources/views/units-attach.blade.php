@include('layouts.header')
<body>

    <div class="container">
        <h3>Attachments for Unit: {{ $unit->unit_id }}</h3>
        @if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

        <!-- Display Attachments -->
        <div class="card mt-3">
            <div class="card-header">
                <strong>Uploaded Attachments</strong>
            </div>
            <div class="card-body">
                @if($attachments->isEmpty())
                    <p>No attachments found for this unit.</p>
                @else
                    <ul class="list-group">
                        @foreach($attachments as $attachment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $attachment->file_name }}</strong><br>
                                    <small>Type: {{ $attachment->file_type }}</small> | 
                                    <small>Size: {{ $attachment->file_size }} KB</small> |
                                    <small>Uploaded: {{ $attachment->uploaded_at }}</small>
                                    @if($attachment->file_remarks)
                                        <p class="mt-1"><em>Remarks: {{ $attachment->file_remarks }}</em></p>
                                    @endif
                                </div>
                                <a href="{{ route('attachments.download', $attachment->attachment_id) }}" class="btn btn-sm btn-primary">
                                    Download
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    
        <!-- Upload Attachment -->
        <div class="card mt-4">
            <div class="card-header">
                <strong>Upload New Attachment</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('attachments.upload', $unit->unit_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Choose File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
@error('file')
    <div class="error">{{$message}}</div>
@enderror                        
                        

                    <div class="form-group mt-3">
                        <label for="file_remarks">Remarks (Optional)</label>
                        <textarea name="file_remarks" id="file_remarks" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Upload</button>
                </form>
            </div>
        </div>
    </div>
        
@include('layouts.script')

</body>