@include('layouts.header')
<div class="container">
    <h1 class="mb-4">Unit Attachments</h1>

    <a href="{{ route('unit_attach.create') }}" class="btn btn-primary mb-3">Add Attachment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Unit</th>
                <th>Type</th>
                <th>File</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unitAttaches as $attach)
            <tr>
                <td>{{ $attach->id }}</td>
                <td>{{ $attach->user->name ?? 'N/A' }}</td>
                <td>{{ $attach->unit->name ?? 'N/A' }}</td>
                <td>{{ $attach->att_type }}</td>
                <td>
                    @if ($attach->att_dir)
                        <a href="{{ asset('storage/' . $attach->att_dir) }}" target="_blank">View</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $attach->stat === "\x01" ? 'Active' : 'Inactive' }}</td>
                <td>{{ $attach->remarks }}</td>
                <td>
                    <a href="{{ route('unit_attach.show', $attach->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('unit_attach.edit', $attach->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('unit_attach.destroy', $attach->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this attachment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $unitAttaches->links() }}
</div>
@include('layouts.script')