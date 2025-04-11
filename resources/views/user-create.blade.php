<body>

@include('layouts.header')

<div class="container" style="font-size: 12px;">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </td>
                    <td>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </td>
                    <td>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">User</option>
                        </select>
                    </td>
                    <td>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </td>
                    <td>
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-3"> <button type="submit" class="btn btn-primary">Save</button></div>
        <div class="mt-4 text-center" style="position: fixed; top: 10px; right: 10px; z-index: 999;">
           
            <a 
            href="javascript:history.back();" 
            class="btn btn-secondary btn-sm p-2 d-flex justify-content-center align-items-center mt-2" 
            style="width: 40px; height: 40px; border-radius: 50%; padding: 0;"
          >
            <i class="bi bi-arrow-left-circle-fill" style="font-size: 18px;"></i>
          </a>
        </div>
    </form>
</div>

@include('layouts.script')

</body>
</html>