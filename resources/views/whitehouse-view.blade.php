@include('layouts.header')
<body>
 
    <div class="container-fluid mt-3">

  <!-- Search Bar and Filters -->
<div class="mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
        <!-- Search Bar -->
        <div>
            <input 
                type="text" 
                id="searchInput" 
                class="form-control" 
                style="font-size: 10px; width: 500px;" 
                placeholder="Search by Brand, Model, Serial Number, etc."
            >
        </div>

        <!-- Dropdown Filters -->
        <div class="d-flex align-items-center">
            <!-- Limit Dropdown -->
            <div class="dropdown me-2">
                <button 
                    class="btn btn-dark dropdown-toggle" 
                    type="button" 
                    id="dropdownMenuButton" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false" 
                    style="font-size: 10px;"
                >
                    {{ session('selected_limit') ?? 'Select Limit' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item {{ session('selected_limit') == '10' ? 'active' : '' }}" href="{{ route('view.whitehouse', ['limit' => 10]) }}">10</a></li>
                    <li><a class="dropdown-item {{ session('selected_limit') == '50' ? 'active' : '' }}" href="{{ route('view.whitehouse', ['limit' => 50]) }}">50</a></li>
                    <li><a class="dropdown-item {{ session('selected_limit') == 'all' ? 'active' : '' }}" href="{{ route('view.whitehouse', ['limit' => 'All']) }}">All</a></li>
                </ul>
            </div>

            <!-- Location Dropdown -->
            <select 
                id="locationDropdown" 
                style="font-size: 10px; 
                       padding: 8px; 
                       border-radius: 5px; 
                       border: 1px solid #ced4da; 
                       background: linear-gradient(to right, #ffffff, #f7f7f7); 
                       color: #333; 
                       box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);" 
                onchange="filterByLocation()"
            >
                <option value="" selected>🌍 All Locations</option>
                @foreach ($locations as $loc)
                    <option value="{{ $loc->location }}" {{ request('location') == $loc->location ? 'selected' : '' }}>📍 {{ $loc->location }}</option>
                @endforeach
            </select>

            <!-- Month Selector -->
            <div class="dropdown ms-2 me-2">
                <button 
                    class="btn btn-light dropdown-toggle" 
                    type="button" 
                    id="monthDropdown" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false" 
                    style="font-size: 10px;"
                >
                    {{ request('month') ? DateTime::createFromFormat('!m', request('month'))->format('F') : 'Select Month' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                    @for ($i = 1; $i <= 12; $i++)
                        <li><a class="dropdown-item" href="{{ route('view.whitehouse', ['month' => $i, 'year' => request('year'), 'limit' => session('selected_limit') ?? 10]) }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</a></li>
                    @endfor
                </ul>
            </div>

            <!-- Year Selector -->
            <div class="dropdown ms-2 me-2">
                <button 
                    class="btn btn-light dropdown-toggle" 
                    type="button" 
                    id="yearDropdown" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false" 
                    style="font-size: 10px;"
                >
                    {{ request('year') ? request('year') : 'Select Year' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                    @for ($year = now()->year; $year >= 2000; $year--)
                        <li><a class="dropdown-item" href="{{ route('view.whitehouse', ['year' => $year, 'month' => request('month'), 'limit' => session('selected_limit') ?? 10]) }}">{{ $year }}</a></li>
                    @endfor
                </ul>
            </div>

            <!-- Add Button -->
            <a 
                href="{{ route('units.create') }}" 
                class="btn btn-primary ms-2" 
                style="font-size: 10px;"
            >
                <i class="bi bi-plus-square-fill"></i> Add
            </a>

            <!-- Save Button -->
            <button 
                class="btn btn-success ms-2" 
                id="saveChanges" 
                style="font-size: 10px;"
            >
                <i class="bi bi-floppy"></i> Save
            </button>
        </div>
    </div>
</div>


 <!-- Responsive Table with Resizable Columns -->
<div class="table-wrapper" style="width: auto; height: auto; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow-x: auto;">
    <table class="table table-bordered" id="excelTable" 
           style="font-size: 10px; border-collapse: collapse; width: 100%; text-align: center;">
           <thead style="position: sticky; top: 0; background-color: #004080; color: #fff; z-index: 1;">
            <tr style="border-bottom: 3px solid #ccc;">
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-building"></i> Company
                </th>
                
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-tags"></i> Category
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-upc-scan"></i> SKU
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-card-text"></i> Short Item Description
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-truck"></i> Vendor Company
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-clipboard-check"></i> Allocation
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-box-seam"></i> Bundled Item
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-upc-scan"></i> Serial Number
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-patch-check"></i> Property Tag
                </th>
               
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-person-fill"></i> Input by
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-shield-check"></i> Unit Status
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-people-fill"></i> Vendor Type
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-gear"></i> Product Management Status
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-receipt"></i> Customer PO Reference
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-graph-up-arrow"></i> Sales Status
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-chat-text-fill"></i> Sales Remarks
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-eye"></i> Unit Information
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
            <tr data-id="{{ $unit->id }}"> <!-- Add data-id for identification -->
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                        <option value="" selected></option>
                        <option value="DOSC" {{ $unit->company == 'DOSC' ? 'selected' : '' }}>🏢 DOSC</option>
                        <option value="DDTC" {{ $unit->company == 'DDTC' ? 'selected' : '' }}>📊 DDTC</option>
                        <option value="DBIC" {{ $unit->company == 'DBIC' ? 'selected' : '' }}>🌐 DBIC</option>
                    </select>
                </td>
                
                
                
                <td style="background-color: transparent;">
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                        <option value="" selected></option>
                        <option value="Audio Visual" {{ $unit->categ == 'Audio Visual' ? 'selected' : '' }}>🎵 Audio Visual</option>
                        <option value="Computing Products" {{ $unit->categ == 'Computing Products' ? 'selected' : '' }}>💻 Computing Products</option>
                        <option value="Document & Data Management" {{ $unit->categ == 'Document & Data Management' ? 'selected' : '' }}>📄 Document & Data Management</option>
                        <option value="Retail Solution" {{ $unit->categ == 'Retail Solution' ? 'selected' : '' }}>🛒 Retail Solution</option>
                    </select>
                </td>
                <td contenteditable="true">{{ $unit->sku }}</td>
                <td contenteditable="true">{{ $unit->desc }}</td>
                <td contenteditable="true">{{ $unit->vendor_com }}</td>
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);" 
                    >
                        <option value="" selected></option>
                        <option value="Louwie Espiritu" {{ $unit->allocation == 'Louwie Espiritu' ? 'selected' : '' }}>Louwie Espiritu</option>
                        <option value="Dyan Dimaculangan" {{ $unit->allocation == 'Dyan Dimaculangan' ? 'selected' : '' }}>Dyan Dimaculangan</option>
                        <option value="Maya Cruz" {{ $unit->allocation == 'Maya Cruz' ? 'selected' : '' }}>Maya Cruz</option>
                        <option value="Andy Salenga" {{ $unit->allocation == 'Andy Salenga' ? 'selected' : '' }}>Andy Salenga</option>
                        <option value="Larry Bernardo" {{ $unit->allocation == 'Larry Bernardo' ? 'selected' : '' }}>Larry Bernardo</option>
                        <option value="ICT" {{ $unit->allocation == 'ICT' ? 'selected' : '' }}>ICT</option>
                        <option value="Rey Plaza" {{ $unit->allocation == 'Rey Plaza' ? 'selected' : '' }}>Rey Plaza</option>
                        <option value="Lincy Flores" {{ $unit->allocation == 'Lincy Flores' ? 'selected' : '' }}>Lincy Flores</option>
                        <option value="Stephanie Machan" {{ $unit->allocation == 'Stephanie Machan' ? 'selected' : '' }}>Stephanie Machan</option>
                        <option value="Gae Ann Cunanan" {{ $unit->allocation == 'Gae Ann Cunanan' ? 'selected' : '' }}>Gae Ann Cunanan</option>
                        <option value="Run Rate Stocks" {{ $unit->allocation == 'Run Rate Stocks' ? 'selected' : '' }}>Run Rate Stocks</option>
                        <option value="Cyril Pita" {{ $unit->allocation == 'Cyril Pita' ? 'selected' : '' }}>Cyril Pita</option>
                        <option value="Rexel Tabamo" {{ $unit->allocation == 'Rexel Tabamo' ? 'selected' : '' }}>Rexel Tabamo</option>
                        <option value="Mark Guererro" {{ $unit->allocation == 'Mark Guererro' ? 'selected' : '' }}>Mark Guererro</option>
                        <option value="Ricky Tamayo" {{ $unit->allocation == 'Ricky Tamayo' ? 'selected' : '' }}>Ricky Tamayo</option>
                        <option value="Rodel Lozano" {{ $unit->allocation == 'Rodel Lozano' ? 'selected' : '' }}>Rodel Lozano</option>
                        <option value="Weynard Fetesio" {{ $unit->allocation == 'Weynard Fetesio' ? 'selected' : '' }}>Weynard Fetesio</option>
                        <option value="Apple Arcaina" {{ $unit->allocation == 'Apple Arcaina' ? 'selected' : '' }}>Apple Arcaina</option>
                        <option value="Sheryl De Guzman" {{ $unit->allocation == 'Sheryl De Guzman' ? 'selected' : '' }}>Sheryl De Guzman</option>
                        <option value="Service Unit/ Demo Unit/" {{ $unit->allocation == 'Service Unit/ Demo Unit/' ? 'selected' : '' }}>Service Unit/ Demo Unit/</option>
                        <option value="NONE" {{ $unit->allocation == 'NONE' ? 'selected' : '' }}>NONE</option>
                        <option value="Earl Nicdao" {{ $unit->allocation == 'Earl Nicdao' ? 'selected' : '' }}>Earl Nicdao</option>
                        <option value="Cherry Liwag" {{ $unit->allocation == 'Cherry Liwag' ? 'selected' : '' }}>Cherry Liwag</option>
                        <option value="DOSC" {{ $unit->allocation == 'DOSC' ? 'selected' : '' }}>DOSC</option>
                        <option value="Merylle Adelantar" {{ $unit->allocation == 'Merylle Adelantar' ? 'selected' : '' }}>Merylle Adelantar</option>
                        <option value="Cristen Gabriel" {{ $unit->allocation == 'Cristen Gabriel' ? 'selected' : '' }}>Cristen Gabriel</option>
                        <option value="AR Lim" {{ $unit->allocation == 'AR Lim' ? 'selected' : '' }}>AR Lim</option>
                    </select>
                </td>
                
                <td contenteditable="true">{{ $unit->bundle_item }}</td>
                <td contenteditable="true">{{ $unit->ser_no }}</td>
                <td contenteditable="true">{{ $unit->prop_tag }}</td>
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);" 
                    >
                        <option value="" selected></option>
                        <option value="Aia Valles" {{ $unit->input_by == 'Aia Valles' ? 'selected' : '' }}>Aia Valles</option>
                        <option value="Annbert Umambac" {{ $unit->input_by == 'Annbert Umambac' ? 'selected' : '' }}>Annbert Umambac</option>
                        <option value="Sofia Hilario" {{ $unit->input_by == 'Sofia Hilario' ? 'selected' : '' }}>Sofia Hilario</option>
                        <option value="Cristen Gabriel" {{ $unit->input_by == 'Cristen Gabriel' ? 'selected' : '' }}>Cristen Gabriel</option>
                        <option value="Marlon Alfonso" {{ $unit->input_by == 'Marlon Alfonso' ? 'selected' : '' }}>Marlon Alfonso</option>
                        <option value="Renz Garcia" {{ $unit->input_by == 'Rhenz' ? 'selected' : '' }}>Renz Garcia</option>
                    </select>
                </td>
                
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: {{ getStatusColor($unit->unit_stat) }}; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);" 
                        onchange="updateBackgroundColor(this)"
                    >
                        <option value="" selected style="color: #6c757d;" ></option>
                        <option value="Brand New" {{ $unit->unit_stat == 'Brand New' ? 'selected' : '' }} style="background-color: #d4edda;">✨ Brand New</option>
                        <option value="Good Unit" {{ $unit->unit_stat == 'Good Unit' ? 'selected' : '' }} style="background-color: #d1ecf1;">👍 Good Unit</option>
                        <option value="Demo Unit" {{ $unit->unit_stat == 'Demo Unit' ? 'selected' : '' }} style="background-color: #fff3cd;">🔧 Demo Unit</option>
                        <option value="Service Unit" {{ $unit->unit_stat == 'Service Unit' ? 'selected' : '' }} style="background-color: #f8d7da;">🛠️ Service Unit</option>
                    </select>
                </td>
                <td contenteditable="true">{{ $unit->vendor_type }}</td>
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: {{ getPmgStatsStyles($unit->pmg_stats)['color'] }}; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);"
                        onchange="updateBackgroundColor(this)"
                    >
                        <option value="" selected style="color: #6c757d;"></option>
                        <option value="Ordered and Waiting for Arrival" 
                                {{ $unit->pmg_stats == 'Ordered and Waiting for Arrival' ? 'selected' : '' }} 
                                style="background-color: {{ getPmgStatsStyles('Ordered and Waiting for Arrival')['color'] }};">
                            {{ getPmgStatsStyles('Ordered and Waiting for Arrival')['icon'] }} Ordered and Waiting for Arrival
                        </option>
                        <option value="Arrived and Endorsed to Sales" 
                                {{ $unit->pmg_stats == 'Arrived and Endorsed to Sales' ? 'selected' : '' }} 
                                style="background-color: {{ getPmgStatsStyles('Arrived and Endorsed to Sales')['color'] }};">
                            {{ getPmgStatsStyles('Arrived and Endorsed to Sales')['icon'] }} Arrived and Endorsed to Sales
                        </option>
                        <option value="Intransit to Provincial Office (DBIC)" 
                                {{ $unit->pmg_stats == 'Intransit to Provincial Office (DBIC)' ? 'selected' : '' }} 
                                style="background-color: {{ getPmgStatsStyles('Intransit to Provincial Office (DBIC)')['color'] }};">
                            {{ getPmgStatsStyles('Intransit to Provincial Office (DBIC)')['icon'] }} Intransit to Provincial Office (DBIC)
                        </option>
                        <option value="Arrive and For Stocking" 
                                {{ $unit->pmg_stats == 'Arrive and For Stocking' ? 'selected' : '' }} 
                                style="background-color: {{ getPmgStatsStyles('Arrive and For Stocking')['color'] }};">
                            {{ getPmgStatsStyles('Arrive and For Stocking')['icon'] }} Arrive and For Stocking
                        </option>
                    </select>
                </td>
                
                <td contenteditable="true">{{ $unit->cust_po_ref }}</td>

                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: {{ getSalesStatsStyles($unit->sales_stats)['color'] }}; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);"
                        onchange="updateBackgroundColor(this)"
                    >
                        <option value="" selected style="color: #6c757d;"></option>
                        <option value="Delivered" 
                                {{ $unit->sales_stats == 'Delivered' ? 'selected' : '' }} 
                                style="background-color: {{ getSalesStatsStyles('Delivered')['color'] }};">
                            {{ getSalesStatsStyles('Delivered')['icon'] }} Delivered
                        </option>
                        <option value="Processed for Delivery" 
                                {{ $unit->sales_stats == 'Processed for Delivery' ? 'selected' : '' }} 
                                style="background-color: {{ getSalesStatsStyles('Processed for Delivery')['color'] }};">
                            {{ getSalesStatsStyles('Processed for Delivery')['icon'] }} Processed for Delivery
                        </option>
                        <option value="No Update Yet" 
                                {{ $unit->sales_stats == 'No Update Yet' ? 'selected' : '' }} 
                                style="background-color: {{ getSalesStatsStyles('No Update Yet')['color'] }};">
                            {{ getSalesStatsStyles('No Update Yet')['icon'] }} No Update Yet
                        </option>
                        <option value="For Stocking Only" 
                                {{ $unit->sales_stats == 'For Stocking Only' ? 'selected' : '' }} 
                                style="background-color: {{ getSalesStatsStyles('For Stocking Only')['color'] }};">
                            {{ getSalesStatsStyles('For Stocking Only')['icon'] }} For Stocking Only
                        </option>
                    </select>
                </td>
                
                
                <td contenteditable="true">{{ $unit->sales_remarks }}</td>
                <td 
                onclick="redirectToEditPage({{ $unit->id }})" 
                style="
                    cursor: pointer; 
                    color: #333; 
                    background: linear-gradient(to right, #ffffff, #ffffff); 
                    padding: 10px; 
                    font-size: 10px; 
                    font-family: Arial, sans-serif; 
                    border-radius: 5px; 
                    box-shadow: 0 2px 5px rgba(246, 2, 2, 0.1); 
                    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;"
                onmouseover="this.style.backgroundColor='green'; this.style.boxShadow='0 4px 10px rgba(0, 128, 0, 0.3)'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor=''; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)'; this.style.transform='';"
            >
                <i 
                    class="bi bi-view-list" 
                    style="margin-right: 5px; color: #05580a; font-size: 10px;"
                ></i> View Unit
            </td>
            
            
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
 
<script>
  document.getElementById('saveChanges').addEventListener('click', function () {
    let editedRows = [];
    
    // Loop through all rows
    document.querySelectorAll('#excelTable tbody tr').forEach(row => {
        let rowData = { id: row.getAttribute('data-id') }; // Get the unique ID for the row

        // Loop through all cells in the row
        row.querySelectorAll('td').forEach((cell, index) => {
            // Map the data by column names
            const columnNames = [
                'company',  'categ','sku', 'desc', 'vendor_com', 'allocation', 
                'bundle_item', 'ser_no', 'prop_tag',  'input_by', 'unit_stat',
                'vendor_type','pmg_stats', 'cust_po_ref', 'sales_stats', 'sales_remarks'
            ];
            
            // Skip the "View" button column (index 16)
            if (index === 16) return;

            // Check if the cell contains a dropdown
            if (cell.querySelector('select')) {
                rowData[columnNames[index]] = cell.querySelector('select').value; // Get selected value
            } else {
                rowData[columnNames[index]] = cell.textContent.trim(); // Get cell content
            }
        });

        editedRows.push(rowData); // Add the row's data to the array
    });

    // Send data to the backend using AJAX
    fetch('/update-units', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ units: editedRows }) // Send the edited rows as JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Changes saved successfully!', 'Success'); // Toastr success notification
        } else {
            toastr.error('Failed to save changes. Please try again.', 'Error'); // Toastr error notification
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while saving changes.', 'Error'); // Toastr error notification
    });
});

</script>

    
<style>
    /* Ensure a clean design */
    th {
        position: relative;
        white-space: nowrap; /* Prevent text from wrapping */
    }

    th > div {
        position: absolute;
        height: 100%;
    }

    tbody td {
        white-space: nowrap; /* Prevent text from wrapping */
    }

    
</style>



    @include('layouts.footer')
    @include('layouts.script')
</body>
