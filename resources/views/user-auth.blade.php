@include('layouts.header')
<body>
    
<div class="container mt-5" style="font-size: 10px;">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
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
                                    style="font-size:10px;" 
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
                                    style="font-size:10px;" 
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
                                    style="font-size:10px;" 
                                    class="form-control" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                >
                            </td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                <select style="font-size:10px;"  name="role" class="form-select" required>
                                    <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Manager</option>
                                    <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>User</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Is Active</th>
                            <td>
                                <input 
                                style="font-size:10px;" 
                                    type="checkbox" 
                                    name="isactive" 
                                    {{ old('isactive', $user->isactive) ? 'checked' : '' }}
                                > Active
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Role Update Form -->
    <div class="mt-4 text-center" style="font-size:10px;position: fixed; top: 10px; right: 10px; z-index: 999;">
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
@include('layouts.footer')
</body>
</html>