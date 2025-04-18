@include('layouts.header')

<body>
    <div class="container-fluid" style="font-size: 10px;">
        {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    
        <!-- Form to edit a unit -->
        <form action="{{ route('update.whitehouse', ['unit_id' => $unit->unit_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container-fluid">
                <div class="row">
                    <!-- Adjusted Table Width -->
                    <div class="col-lg-8">
                        <table class="table table-bordered" style="font-size: 10px; width: 100%;">
                            <tr>
                                <th>Company
                                    <input type="text" style="font-size: 10px;" class="form-control" id="company" name="company" value="{{ $unit->company }}">
                                </th>
                                <th>Brand 
                                    <input type="text" style="font-size: 10px;" class="form-control" id="brand" name="brand" value="{{ $unit->brand }}">
                                </th>
                                <th>Model
                                    <input type="text" style="font-size: 10px;" class="form-control" id="model" name="model" value="{{ $unit->model }}">
                                </th>
                                
                                <th>Device Type
                                    <input type="text" style="font-size: 10px;" class="form-control" id="dev_type" name="dev_type" value="{{ $unit->dev_type }}">
                                </th>
                            </tr>
                            <tr>
                                <th>Stock Keeping Unit - SKU
                                    <input type="text" style="font-size: 10px;" class="form-control" id="sku" name="sku" value="{{ $unit->sku }}">
                                </th>
                                <th>Category
                                    <input type="text" style="font-size: 10px;" class="form-control" id="categ" name="categ" value="{{ $unit->categ }}">
                                </th>
                                <th>Serial Number
                                    <input type="text" style="font-size: 10px;" class="form-control" id="ser_no" name="ser_no" value="{{ $unit->ser_no }}">
                                </th>
                                <th>Area
                                    <input type="text" style="font-size: 10px;" class="form-control" id="area" name="area" value="{{ $unit->area }}">
                                </th>
                                
                            </tr>
                            <tr>
                                <th>Vendor Company
                                    <input type="text" style="font-size: 10px;" class="form-control" id="vendor_com" name="vendor_com" value="{{ $unit->vendor_com }}">
                                </th>
                                <th>Allocation
                                    <input type="text" style="font-size: 10px;" class="form-control" id="allocation" name="allocation" value="{{ $unit->allocation }}">
                                </th>
                                <th>Quantity
                                    <input type="number" style="font-size: 10px;" class="form-control" id="qty" name="qty" value="{{ $unit->qty }}">
                                </th>
                                <th>Bundle Item
                                    <input type="text" style="font-size: 10px;" class="form-control" id="bundle_item" name="bundle_item" value="{{ $unit->bundle_item }}">
                                </th>
                                
                            </tr>
                            <tr>
                                <th>Property Tag
                                    <input type="text" style="font-size: 10px;" class="form-control" id="prop_tag" name="prop_tag" value="{{ $unit->prop_tag }}">
                                </th>
                                <th>Customer PO Reference
                                    <input type="text" style="font-size: 10px;" class="form-control" id="cust_po_ref" name="cust_po_ref" value="{{ $unit->cust_po_ref }}">
                                </th>
                              
                                <th>Location
                                    <input type="text" style="font-size: 10px;" class="form-control" id="location" name="location" value="{{ $unit->location }}">
                                </th>
                                <th>Unit Status
                                    <input type="text" style="font-size: 10px;" class="form-control" id="unit_stat" name="unit_stat" value="{{ $unit->unit_stat }}">
                                </th>
                            </tr>
                            <tr>
                                <th>Input By
                                    <input type="text" style="font-size: 10px;" class="form-control" id="input_by" name="input_by" value="{{ $unit->input_by }}">
                                </th>
                                <th>Vendor Type
                                    <input type="text" style="font-size: 10px;" class="form-control" id="vendor_type" name="vendor_type" value="{{ $unit->vendor_type }}">
                                </th>
                                <th>Product Management Status
                                    <select class="form-control" id="pmg_stats" name="pmg_stats" value="{{ $unit->pmg_stats }}"
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
                                </th>
                                <th>Sales Status
                                    <select  class="form-control" id="sales_stats" name="sales_stats" value="{{ $unit->sales_stats }}"
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
                                </th>
                            
                            </tr>
                            <tr>
                                <th>Sales Remarks
                                    <input type="text" style="font-size: 10px;" class="form-control" id="sales_remarks" name="sales_remarks" value="{{ $unit->sales_remarks }}">
                                </th>
                                <th>Description
                                    <input type="text" style="font-size: 10px;" class="form-control" id="desc" name="desc" value="{{ $unit->desc }}">
                                </th>
                                <th>Date Added
                                    <input type="date" style="font-size: 10px;" class="form-control" id="date_add" name="date_add" value="{{ $unit->date_add }}">
                                </th>
                                <th>Date Pullout
                                    <input type="date" style="font-size: 10px;" class="form-control" id="date_pull" name="date_pull" value="{{ $unit->date_pull }}">
                                </th>
                              
                            </tr>
                                                     <!-- Action buttons -->
            
                        </table>
                    </div>
                    
                                              <!-- Age - Stock Period Card -->
                                              <div class="col-lg-4">
                                                <div class="row">
                                                    <!-- Age - Stock Period -->
                                                    <div class="col-lg-6">
                                                        <div class="card mb-3">
                                                            <div class="card-header">
                                                                <i class="bi bi-calendar2-week"></i> Age - Stock Period
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" style="font-size: 10px;" class="form-control" id="age" name="age" 
                                                                       value="{{ $unit->exact_age_in_days }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Status -->
                                                    <div class="col-lg-6">
                                                        <div class="card mb-3">
                                                            <div class="card-header">
                                                                <i class="bi bi-archive"></i> Request to Archive
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" style="font-size: 10px;" class="form-control" id="status" name="status" 
                                                                       value="Archive {{ $unit->stats }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-success" style="font-size: 12px;"><i class="bi bi-floppy2"></i> Update</button>
                                                </div>
                                            </form>
                                    </div>
                                            
              
         
    </div>
                                                  
                                                    
    <div class="container-fluid mt-3">
        <div class="row">
       
            <div class="container-fluid mt-3">
                <!-- Attachment Section Header -->
                <div class="row justify-content-center py-3">
                    <div class="col-md-6 text-center">
                        <div class="p-2 shadow-sm rounded bg-light border border-success">
                            <h6 class="mb-0 text-success" style="font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                                <i class="bi bi-paperclip me-3" style="font-size: 9px;"></i>Attachment 
                            </h6>
                        </div>
                    </div>
                </div>
            
                <!-- Attachment Content -->
                <div class="row mt-2">
                    <div class="col">
                        <div class="border rounded p-2 shadow-sm" 
                             style="width:100%; background-color: #f9f9f9; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                            <iframe 
                                src="{{ route('unit.attachments', $unit->unit_id) }}" 
                                width="100%" 
                                height="300px" 
                                style="border: none;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            
           
          
        </div>
      

    </div>
                                                    
    <div class="container-fluid mt-3">
        <div class="row">
       
            <div class="container-fluid mt-3">
                <!-- Remarks Section Header -->
                <div class="row justify-content-center py-3">
                    <div class="col-md-6 text-center">
                        <div class="p-2 shadow-sm rounded bg-light border border-success">
                            <h6 class="mb-0 text-success" style="font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                                <i class="bi bi-highlighter me-1" style="font-size: 9px;"></i>Remarks 
                            </h6>
                        </div>
                    </div>
                </div>
                
            
                <!-- Remarks Content -->
                <div class="row mt-2">
                    <div class="col">
                        <div class="border rounded p-2 shadow-sm" 
                             style="width:100%; background-color: #f9f9f9; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                            <iframe 
                                src="{{ route('units.remarks', $unit->unit_id) }}" 
                                width="100%" 
                                height="300px" 
                                style="border: none;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            
           
          
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
        $('#fileUploadForm').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Display success message using Toastr
            toastr.success(response.message, 'Success');
        },
        error: function(xhr) {
    console.log(xhr); // Log the error response to the console
    toastr.error('File upload failed', 'Error');
}
    });
});

    </script>
   
@include('layouts.script')
</body>