@include('layouts.header')
<body>
    <div class="container-fluid mt-5">
        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" style="font-size: 12px;" placeholder="Search by Brand, Model, Serial Number, etc.">
        </div>
    
        <!-- Table -->
        <table class="table table-striped table-hover" id="unitsTable" style="font-size: 10px;">
            <thead class="table-primary">
                <div class="mb-4">
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px;">
                                {{ session('selected_limit') ?? 'Select Limit' }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a 
                                        class="dropdown-item {{ session('selected_limit') == '10' ? 'active' : '' }}" 
                                        href="{{ route('view-units', ['limit' => 10]) }}">
                                        10
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        class="dropdown-item {{ session('selected_limit') == '50' ? 'active' : '' }}" 
                                        href="{{ route('view-units', ['limit' => 50]) }}">
                                        50
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        class="dropdown-item {{ session('selected_limit') == 'all' ? 'active' : '' }}" 
                                        href="{{ route('view-units', ['limit' => 'All']) }}">
                                        Show All
                                    </a>
                                </li>
                            </ul>
                            <a href="{{ route('units.create') }}" class="btn btn-success" style="font-size: 12px;">Add Unit</a>
                        </div>
                        
                          
                    </div>
                </div>
                
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Device Type</th>
                    <th>Quantity</th>
                    <th>Date Added</th>
                    <th>Date Pullout</th>
                    <th>Serial Number</th>
                    <th>Location</th>
                    <th>Property Tag</th>
                    <th>Unit Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $unit)
                    <tr onclick="redirectToEditPage({{ $unit->id }})" style="cursor: pointer;">
                        <td>{{ $unit->brand }}</td>
                        <td>{{ $unit->model }}</td>
                        <td>{{ $unit->dev_type }}</td>
                        <td>{{ $unit->qty }}</td>
                        <td>{{ $unit->date_add }}</td>
                        <td>{{ $unit->date_pull }}</td>
                        <td>{{ $unit->ser_no }}</td>
                        <td>{{ $unit->location }}</td>
                        <td>{{ $unit->prop_tag }}</td>
                        <td>{{ $unit->unit_stat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

     
        
    </div>
     <script>
        function redirectToEditPage(id) {
            let route = `{{ route('edit-unit', ':id') }}`;
            route = route.replace(':id', id); 
            window.location.href = route;
        }
    </script>
    
    @include('layouts.footer')
    @include('layouts.script')
 
    
<script>
    document.addEventListener("DOMContentLoaded", function() {          
        const searchInput = document.getElementById("searchInput");
        const table = document.getElementById("unitsTable");
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

</body>
