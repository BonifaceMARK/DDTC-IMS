@include("layouts.header")
<body>
    <div class="container-fluid mt-5">
        {{-- @if (session('success'))
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
@endif --}}

             <!-- Search Bar -->
             <div class="mb-4">
                <input type="text" id="searchInput" class="form-control" style="font-size: 12px;" placeholder="Search...">
            </div>
        
    <a href="{{ url('/users/create') }}" class="btn btn-success" style="font-size: 12px;">Create New User</a>
    <table class="table table-striped table-hover mt-3" style="font-size: 12px;" id="usersTable">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Email Verified At</th>
                <th>Status</th>
                <th>Profile Picture</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="clickable-row" data-url="{{ route('users.show', $user->id) }}" style="cursor: pointer;">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->role == 1)
                            Admin
                        @elseif ($user->role == 2)
                            Manager
                        @else
                            User
                        @endif
                    </td>
                    <td>{{ $user->email_verified_at ?? 'Not Verified' }}</td>
                    <td>{{ $user->isactive ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <img src="{{ $user->profile_pic }}" alt="Profile Picture" width="50" height="50">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @include('layouts.footer')
</div>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".clickable-row");

    rows.forEach(row => {
        row.addEventListener("click", () => {
            const url = row.dataset.url;
            window.location.href = url; // Redirect to the user details page
        });
    });
});

</script>

 
    {{-- SEARCH BAR  --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {          
        const searchInput = document.getElementById("searchInput");
        c   onst table = document.getElementById("usersTable");
        const rows = table.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) { // Skip the header row
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                row.style.display = match ? "" : "none"; // Show or hide the row
            }
        });
    });
</script>
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
@include('layouts.script')

    
</body>