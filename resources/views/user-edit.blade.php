@include('layouts.header')
<body>
    

<div class="container mt-2">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-5">
    <h3>Edit User</h3>
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="border rounded p-3">
        @csrf
        @method('PUT')

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Full Name</th>
                    <td>
                        <input 
                            type="text" 
                            name="fullname" 
                            class="form-control" 
                            value="{{ old('fullname', $user->fullname) }}" 
                            required
                        >
                    </td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>
                        <input 
                            type="text" 
                            name="username" 
                            class="form-control" 
                            value="{{ old('username', $user->username) }}" 
                            required
                        >
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control" 
                            value="{{ old('email', $user->email) }}" 
                            required
                        >
                    </td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        <select name="role" class="form-select" required>
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Sales" {{ old('role', $user->role) == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                            <!-- Add more roles as needed -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Is Active</th>
                    <td>
                        <input 
                            type="checkbox" 
                            name="isactive" 
                            {{ old('isactive', $user->isactive) ? 'checked' : '' }}
                        > Active
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-3">Cancel</a>
        </div>
    </form>
</div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
