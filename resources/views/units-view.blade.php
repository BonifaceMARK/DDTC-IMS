@include('layouts.header')
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
<body>

 
    <div class="container-fluid mb-3 mt-3">

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
    <option value="all_locations" selected>🌍 All Locations</option>
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
                
<!-- Specific Date Input -->
<input 
style="font-size: 10px; 
       padding: 8px; 
       border-radius: 5px; 
       border: 1px solid #ced4da; 
       background: linear-gradient(to right, #ffffff, #f7f7f7); 
       color: #333; 
       box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);" 
type="date" 
id="specific_date" 
name="specific_date" 
value="{{ request('specific_date') }}" 
onchange="filterByDate(this.value);" 
>
            </div>
            @auth
            @if (in_array(auth()->user()->role, [1, 2]))
            <div 
              class="position-fixed top-0 start-50 translate-middle-x z-3 d-flex gap-2 align-items-center py-2"
              style="margin-top: 10px;"
            >
              <!-- Add Button -->
              <a 
                onclick="openCreateModal()"
                class="btn btn-sm d-flex justify-content-center align-items-center shadow-sm"
                style="width: 42px; height: 42px; border-radius: 50%; background-color: #f0f0f0; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='green'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='#f0f0f0'; this.style.color='black';"
                title="Add New"
              >
                <i class="bi bi-plus-lg" style="font-size: 10px;"></i>
              </a>
            
              <!-- Save Button -->
              <button 
                class="btn btn-sm d-flex justify-content-center align-items-center shadow-sm"
                id="saveChanges"
                style="width: 42px; height: 42px; border-radius: 50%; background-color: #f0f0f0; transition: all 0.3s ease;"
                onmouseover="this.style.backgroundColor='green'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='#f0f0f0'; this.style.color='black';"
                title="Save Changes"
              >
                <i class="bi bi-floppy" style="font-size: 10px;"></i>
              </button>
            </div>
            @endif
            @endauth
            
        </div>
    </div>
</div>


 <!-- Responsive Table with Resizable Columns -->
    <table class="table table-bordered" id="excelTable" 
           style="font-size: 9px; border-collapse: collapse; width: 100%; text-align: center;overflow-x:inherit;">
           <thead style="position: sticky; top: 0; background-color: #004080; color: #fff; z-index: 1;">
            <tr style="border-bottom: 3px solid #ccc;">
                {{-- <th style="width: 150px; position: relative;">
                    <i class="bi bi-building"></i> Company
                </th> --}}
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-tags"></i> Category
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-tags"></i> Model
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-upc-scan"></i> SKU
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-card-text"></i> Short Item Description
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-card-text"></i> Serial Number
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-card-text"></i> Warehouse
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-truck"></i> Vendor / Supplier
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-truck"></i> Vendor PO Attachment
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-clipboard-check"></i> Allocation
                </th>
                {{-- <th style="width: 150px; position: relative;">
                    <i class="bi bi-box-seam"></i> Bundled Item
                </th> --}}
                {{-- <th style="width: 150px; position: relative;">
                    <i class="bi bi-upc-scan"></i> Serial Number
                </th> --}}
                    {{-- <th style="width: 150px; position: relative;">
                        <i class="bi bi-patch-check"></i> Property Tag
                    </th> --}}
               
                {{-- <th style="width: 150px; position: relative;">
                    <i class="bi bi-person-fill"></i> Input by
                </th> --}}
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-shield-check"></i> Unit Status
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-people-fill"></i> Vendor Type
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-gear"></i> Product Management Status
                </th>
                {{-- <th style="width: 150px; position: relative;">
                    <i class="bi bi-receipt"></i> Customer PO Reference
                </th> --}}
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-graph-up-arrow"></i> Sales Status
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-graph-up-arrow"></i> Sales Remarks
                </th>
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-chat-text-fill"></i> Customer PO Reference
                </th>
                @auth
                @if (in_array(auth()->user()->role, [1, 2]))
                <th style="width: 150px; position: relative;">
                    <i class="bi bi-eye"></i> Unit Information
                </th>
                @endif
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
            <tr data-rec-id="{{ $unit->unit_id }}"> <!-- Add data-id for identification -->
                {{-- <td>
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
                </td> --}}
                
                
                
                <td style="background-color: transparent;">
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                               max-width: 130px; 
                               word-wrap: break-word; 
                               white-space: normal; 
                               overflow: hidden;">
                        <option value="" selected></option>
                        <option value="Audio Visual" {{ $unit->categ == 'Audio Visual' ? 'selected' : '' }}>🎵 Audio Visual</option>
                        <option value="Computing Products" {{ $unit->categ == 'Computing Products' ? 'selected' : '' }}>💻 Computing Products</option>
                        <option value="Document & Data Management" {{ $unit->categ == 'Document & Data Management' ? 'selected' : '' }}>📄 Document & Data Management</option>
                        <option value="Retail Solution" {{ $unit->categ == 'Retail Solution' ? 'selected' : '' }}>🛒 Retail Solution</option>
                    </select>
                </td>
                <td contenteditable="true">{{ $unit->model }}</td>
                <td contenteditable="true">{{ $unit->sku }}</td>
                
                <td contenteditable="true" 
                style="max-width: 150px; 
                       word-wrap: break-word; 
                       white-space: normal; 
                       overflow: hidden;">
                {{ $unit->desc }}
            </td>
            <td contenteditable="true">{{ $unit->ser_no }}</td>
            <td contenteditable="true">{{$unit->location}}</td>

                <td contenteditable="true">{{ $unit->vendor_com }}</td>
                <td 
                style="max-width: 70px; 
                       word-wrap: break-word; 
                       white-space: normal; 
                       overflow: hidden;
                       cursor: pointer;"
                data-bs-toggle="modal" 
                data-bs-target="#attachmentsModal" 
                data-unit-id="{{ $unit->unit_id }}" 
                onmouseover="this.firstElementChild.style.transform='scale(1.2)'; this.firstElementChild.style.transition='transform 0.2s ease';" 
                onmouseout="this.firstElementChild.style.transform='scale(1)';"
                class="open-attachments"
            >
                <i class="bi bi-file-earmark-text"></i> View
            </td>
            
            
       <!-- Modal -->
<div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachmentsModalLabel">Attachments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="border rounded p-2 shadow-sm" 
                     style="background-color: #f9f9f9; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                    <iframe 
                        id="attachmentsIframe"
                        data-src="{{ route('unit.attachments', $unit->unit_id) }}" 
                        width="100%" 
                        height="500px" 
                        style="border: none;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const iframe = document.getElementById('attachmentsIframe');
        const attachmentsModal = document.getElementById('attachmentsModal');
        const routeTemplate = attachmentRouteTemplate; // e.g., "/unit/__UNIT_ID__/attachments"

        document.querySelectorAll('.open-attachments').forEach(item => {
            item.addEventListener('click', function () {
                const unitId = this.getAttribute('data-unit-id');
                const finalUrl = routeTemplate.replace('__UNIT_ID__', unitId);
                iframe.setAttribute('src', finalUrl);
            });
        });

        attachmentsModal.addEventListener('hidden.bs.modal', function () {
            iframe.setAttribute('src', '');
        });
    });
</script>

<script>
    const attachmentRouteTemplate = "{{ route('unit.attachments', ['unit_id' => '__UNIT_ID__']) }}";
</script>


                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: #f8f9fa; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                               max-width: 130px; 
                               word-wrap: break-word; 
                               white-space: normal; 
                               overflow: hidden;" 
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
                
                {{-- <td contenteditable="true"
                style="max-width: 150px; 
                       word-wrap: break-word; 
                       white-space: normal; 
                       overflow: hidden;">{{ $unit->bundle_item }}</td> --}}
                {{-- <td contenteditable="true">{{ $unit->ser_no }}</td> --}}
                {{-- <td contenteditable="true">{{ $unit->prop_tag }}</td> --}}
                {{-- <td>
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
                </td> --}}
                
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
                <td>
                    <select 
                    style="font-size: 10px; 
                           padding: 5px; 
                           border-radius: 5px; 
                           border: 1px solid #ced4da; 
                           background-color: #f8f9fa; 
                           color: #495057; 
                           box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                           max-width: 130px; 
                           word-wrap: break-word; 
                           white-space: normal; 
                           overflow: hidden;">
                    <option value="" selected></option>
                    <option value="Principal" {{ $unit->vendor_type == 'Principal' ? 'selected' : '' }}>⭐ Principal</option>
                    <option value="Distributor" {{ $unit->vendor_type == 'Distributor' ? 'selected' : '' }}>✔️ Distributor</option>
                </select>
                
                </td>
                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: {{ getPmgStatsStyles($unit->pmg_stats)['color'] }}; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                               max-width: 130px; 
                               word-wrap: break-word; 
                               white-space: normal; 
                               overflow: hidden;
                               "
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
                
                {{-- <td contenteditable="true">{{ $unit->cust_po_ref }}</td> --}}

                <td>
                    <select 
                        style="font-size: 10px; 
                               padding: 5px; 
                               border-radius: 5px; 
                               border: 1px solid #ced4da; 
                               background-color: {{ getSalesStatsStyles($unit->sales_stats)['color'] }}; 
                               color: #495057; 
                               box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                               max-width: 130px; 
                               word-wrap: break-word; 
                               white-space: normal; 
                               overflow: hidden;"
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
                <td contenteditable="true">{{$unit->cust_po_ref}}</td>
                @auth
                @if (in_array(auth()->user()->role, [1, 2]))
              <!-- Modal Button -->
<td 
onclick="openModal({{ $unit->unit_id }})"
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
></i> View
</td>
            @endif
            @endauth
            
            </tr>
        @endforeach
        </tbody>
    </table>
 
<!-- Updated Modal HTML -->
<div id="createUnitModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div  style="background: #fff; margin: 110px 30px; padding: 20px; width: 95%; border-radius: 10px; position: relative;">
        <!-- Close Button -->
        <button 
            onclick="closeCreateModal()" 
            style="
                position: absolute; 
                top: 10px; 
                right: 10px; 
                padding: 5px 10px; 
                background-color: red; 
                color: white; 
                border: none; 
                border-radius: 5px; 
                cursor: pointer;
            ">
            <i class="bi bi-box-arrow-right"></i>
        </button>

        <!-- Iframe Content -->
        <iframe 
            id="createIframe" 
            src="" 
            style="width: 100%; height: 500px; border: none;">
        </iframe>
    </div>
</div>

<script>
    function openCreateModal(recId) {
        const iframe = document.getElementById('createIframe');
        iframe.src = `/units/create`;
        document.getElementById('createUnitModal').style.display = 'block';
    }

    function closeCreateModal() {
        document.getElementById('createUnitModal').style.display = 'none';
    }
</script>
<!-- Updated Modal HTML -->
<div id="editUnitModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div  style="background: #fff; margin: 110px 30px; padding: 20px; width: 95%; border-radius: 10px; position: relative;">
        <!-- Close Button -->
        <button 
            onclick="closeModal()" 
            style="
                position: absolute; 
                top: 10px; 
                right: 10px; 
                padding: 5px 10px; 
                background-color: red; 
                color: white; 
                border: none; 
                border-radius: 5px; 
                cursor: pointer;
            ">
            <i class="bi bi-box-arrow-right"></i>
        </button>

        <!-- Iframe Content -->
        <iframe 
            id="modalIframe" 
            src="" 
            style="width: 100%; height: 500px; border: none;">
        </iframe>
    </div>
</div>

<script>
    function openModal(recId) {
        const iframe = document.getElementById('modalIframe');
        iframe.src = `/whitehouse/edit/${recId}`;
        document.getElementById('editUnitModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('editUnitModal').style.display = 'none';
    }
</script>
@include('layouts.tableScript')
@include('layouts.filterscript')
@include('layouts.script')
@include('layouts.scriptStock')
</body>
