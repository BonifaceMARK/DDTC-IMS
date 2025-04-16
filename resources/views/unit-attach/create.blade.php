@include('layouts.header')
<div class="container">
    <h2 class="mb-4">Add Unit Attachment</h2>

    <form action="{{ route('unit_attach.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit</label>
            <select name="unit_id" class="form-control" required>
                <option value="">Select unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="att_type" class="form-label">Attachment Type</label>
            <input type="text" name="att_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="att_file" class="form-label">Upload File</label>
            <input type="file" name="att_file" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stat" class="form-label">Status</label>
            <select name="stat" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('unit_attach.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@include('layouts.script')