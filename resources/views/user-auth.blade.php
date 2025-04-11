@include('layouts.header')
<body>
    
<div class="container mt-5">
    <h2>User Details</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
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
    <div class="mt-3">
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
        <button class="btn btn-info mt-2" onclick="alert('User logs feature coming soon!');">User Logs</button>
         
        </form>
    </div>
    <!-- Role Update Form -->
    <div class="mt-4 text-center" style="position: fixed; top: 10px; right: 10px; z-index: 999;">
        <a 
        href="javascript:history.back();" 
        class="btn btn-secondary btn-sm p-2 d-flex justify-content-center align-items-center mt-2" 
        style="width: 40px; height: 40px; border-radius: 50%; padding: 0;"
      >
        <i class="bi bi-arrow-left-circle-fill" style="font-size: 18px;"></i>
      </a>  
    </div>

</div>
@include('layouts.script')
</body>
</html>