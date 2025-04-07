@include('layouts.header')
<div class="container mt-5">
    <h2>User Details</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Full Name:</strong> {{ $user->fullname }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Current Role:</strong> 
                @if ($user->role == 1)
                    Admin
                @elseif ($user->role == 2)
                    Manager
                @else
                    User
                @endif
            </p>
            <p><strong>Status:</strong> {{ $user->isactive ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>

    <!-- Role Update Form -->
    <div class="mt-4">
        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="role">Change User Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Manager</option>
                    <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update Role</button>
        </form>
    </div>

    <!-- Additional Actions -->
    <div class="mt-4">
        <button class="btn btn-info" onclick="alert('User logs feature coming soon!');">User Logs</button>
    </div>
</div>
@include('layouts.script')