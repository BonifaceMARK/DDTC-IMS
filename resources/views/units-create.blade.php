@include('layouts.header')
<body>
        @if(session('success'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('success') }}");
                });
            </script>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid mt-3">
            <div class="row">
               
                <script>
                    document.getElementById("file_att").addEventListener("change", function (event) {
                        const file = event.target.files[0];
                        const reader = new FileReader();
                
                        reader.onload = function (e) {
                            document.getElementById("profilePreview").src = e.target.result;
                        };
                
                        if (file) {
                            reader.readAsDataURL(file);
                        }
                    });
                </script>
                                
                <!-- Adjusted Table Width -->
                <div class="col-lg-6">
        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <table class="table table-bordered mt-3" style="font-size: 9px; border-collapse: collapse; width: 100%;">
                <tr>
                    <th>🏢 Company
                        <select class="form-control" style="font-size: 10px; padding: 4px; border-radius: 5px; border: 1px solid #ced4da;" id="Company" name="company" required>
                            <option value="" selected></option>
                            <option value="DOSC">🏢 DOSC</option>
                            <option value="DDTC">📊 DDTC</option>
                            <option value="DBIC">🌐 DBIC</option>
                        </select>
                    </th>
                    <th>🏷️ Brand
                        <input type="text" class="form-control" style="font-size: 10px;" id="Brand" name="brand" required>
                    </th>
                    <th>📱 Model
                        <input type="text" class="form-control" style="font-size: 10px;" id="Model" name="model" required>
                    </th>
                </tr>
                <tr>
                    <th>🖥️ Device Type
                        <input type="text" class="form-control" style="font-size: 10px;" id="Device Type" name="dev_type" required>
                    </th>
                    <th>🔢 SKU
                        <input type="text" class="form-control" style="font-size: 10px;" id="Stock Keeping Unit" name="sku" required>
                    </th>
                    <th>📦 Bundle Item
                        <input type="text" class="form-control" style="font-size: 10px;" id="Bundle Item" name="bundle_item">
                    </th>
                </tr>
                <tr>
                    <th>📝 Description
                        <input type="text" class="form-control" style="font-size: 10px;" id="Description" name="desc" required>
                    </th>
                    <th>🔍 Serial Number
                        <input type="text" class="form-control" style="font-size: 10px;" id="Serial Number" name="ser_no" required>
                    </th>
                    <th>🌍 Area
                        <input type="text" class="form-control" style="font-size: 10px;" id="Area" name="area" required>
                    </th>
                </tr>
                <tr>
                    <th>🏬 Vendor Company
                        <input type="text" class="form-control" style="font-size: 10px;" id="Vendor Company" name="vendor_com" required>
                    </th>
                    <th>🔢 Quantity
                        <input type="number" class="form-control" style="font-size: 10px;" id="Quantity" name="qty" required>
                    </th>
                    <th>📤 Allocation
                        {{-- <input type="text" class="form-control" style="font-size: 10px;" id="Allocation" name="allocation"> --}}
                       <select class="form-control" style="font-size: 10px;" name="allocation" id="Allocation">
                        <option value="" selected></option>
                        <option value="Louwie Espiritu">Louwie Espiritu</option>
                        <option value="Dyan Dimaculangan">Dyan Dimaculangan</option>
                        <option value="Maya Cruz">Maya Cruz</option>
                        <option value="Andy Salenga">Andy Salenga</option>
                        <option value="Larry Bernardo">Larry Bernardo</option>
                        <option value="ICT">ICT</option>
                        <option value="Rey Plaza">Rey Plaza</option>
                        <option value="Lincy Flores">Lincy Flores</option>
                        <option value="Stephanie Machan">Stephanie Machan</option>
                        <option value="Gae Ann Cunanan">Gae Ann Cunanan</option>
                        <option value="Run Rate Stocks">Run Rate Stocks</option>
                        <option value="Cyril Pita">Cyril Pita</option>
                        <option value="Rexel Tabamo">Rexel Tabamo</option>
                        <option value="Mark Guererro">Mark Guererro</option>
                        <option value="Ricky Tamayo">Ricky Tamayo</option>
                        <option value="Rodel Lozano">Rodel Lozano</option>
                        <option value="Weynard Fetesio">Weynard Fetesio</option>
                        <option value="Apple Arcaina">Apple Arcaina</option>
                        <option value="Sheryl De Guzman">Sheryl De Guzman</option>
                        <option value="Service Unit/ Demo Unit/">Service Unit/ Demo Unit/</option>
                        <option value="NONE">NONE</option>
                        <option value="Earl Nicdao">Earl Nicdao</option>
                        <option value="Cherry Liwag">Cherry Liwag</option>
                        <option value="DOSC">DOSC</option>
                        <option value="Merylle Adelantar">Merylle Adelantar</option>
                        <option value="Cristen Gabriel">Cristen Gabriel</option>
                        <option value="AR Lim">AR Lim</option>
                    </select>
                    </th>
                </tr>
                <tr>
                    <th>🏷️ Property Tag
                        <input type="text" class="form-control" style="font-size: 10px;" id="Property Tag" name="prop_tag" required>
                    </th>
                    <th>📄 Customer PO Ref
                        <input type="text" class="form-control" style="font-size: 10px;" id="Customer PO Reference" name="cust_po_ref" required>
                    </th>
                    <th>📁 Category
                        <select class="form-control" style="font-size: 10px; padding: 4px; border-radius: 5px; border: 1px solid #ced4da;" id="Category" name="categ" required>
                            <option value="" selected></option>
                            <option value="Audio Visual">🎵 Audio Visual</option>
                            <option value="Computing Products">💻 Computing Products</option>
                            <option value="Document & Data Management">📄 Document & Data Management</option>
                            <option value="Retail Solution">🛒 Retail Solution</option>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>🗨️ Sales Remarks
                        <input type="text" class="form-control" style="font-size: 10px;" id="Sales Remarks" name="sales_remarks">
                    </th>
                    <th>✍️ Input by
                        <input type="text" class="form-control" style="font-size: 10px;" id="Input By" name="input_by">
                    </th>
                    <th>📦 Unit Status
                        <select class="form-control" style="font-size: 10px;" id="Unit Status" name="unit_stat">
                            <option value=""></option>
                            <option value="Brand New" style="background-color: #d4edda;">✨ Brand New</option>
                            <option value="Good Unit" style="background-color: #d1ecf1;">👍 Good Unit</option>
                            <option value="Demo Unit" style="background-color: #fff3cd;">🔧 Demo Unit</option>
                            <option value="Service Unit" style="background-color: #f8d7da;">🛠️ Service Unit</option>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>🏢 Vendor Type
                        <input type="text" class="form-control" style="font-size: 10px;" id="Vendor Type" name="vendor_type">
                    </th>
                    <th>📊 PM Status
                        <input type="text" class="form-control" style="font-size: 10px;" id="Product Management Status" name="pmg_stats">
                    </th>
                    <th>💼 Sales Status
                        <input type="text" class="form-control" style="font-size: 10px;" id="Sales Status" name="sales_stats">
                    </th>
                </tr>
                <tr>
                    <th>📅 Date Added
                        <input type="date" class="form-control" style="font-size: 10px;" id="Date Added" name="date_add">
                    </th>
                    <th>📦 Date Pullout
                        <input type="date" class="form-control" style="font-size: 10px;" id="Date Pullout" name="date_pull">
                    </th>
                    <th>📍 Location
                        <input type="text" class="form-control" style="font-size: 10px;" id="Location" name="location">
                    </th>
                </tr>
            </table>
            
            
            {{-- <a href="{{ route('import.form') }}" class="btn btn-success" style="font-size: 10px;">Import Excel</a> --}}

         
    
    </div>
    <div class="col-lg-6">
        <div class="card" style="border: 1px solid #ced4da; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #f8f9fa; padding: 20px;">
                
    
                <div class="row">
                    <!-- First Table -->
                    <div class="col-lg-6" style="padding-right: 10px;">
                        <div style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                           
                            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                                <tbody id="preview-part1" style="background-color: #fff; font-size: 10px;">
                                    <!-- First half of the values will dynamically appear here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                    <!-- Second Table -->
                    <div class="col-lg-6" style="padding-left: 10px;">
                        <div style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                           
                            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                                <tbody id="preview-part2" style="background-color: #fff; font-size: 10px;">
                                    <!-- Second half of the values will dynamically appear here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="mt-4 text-center" style="position: fixed; bottom: 10px; right: 10px; z-index: 999;">
            <!-- Submit Button -->
            <button 
              type="submit" 
              class="btn btn-primary btn-sm p-2 d-flex justify-content-center align-items-center" 
              style="width: 40px; height: 40px; border-radius: 50%; padding: 0;"
            >
            <i class="bi bi-floppy-fill"></i>
            </button>
          
            <!-- Back Button -->
            {{-- <a 
              href="javascript:history.back();" 
              class="btn btn-secondary btn-sm p-2 d-flex justify-content-center align-items-center mt-2" 
              style="width: 40px; height: 40px; border-radius: 50%; padding: 0;"
            >
              <i class="bi bi-arrow-left-circle-fill" style="font-size: 18px;"></i>
            </a> --}}
          </div>
          
          
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll("form input, form select");
            const previewPart1 = document.getElementById("preview-part1");
            const previewPart2 = document.getElementById("preview-part2");
        
            inputs.forEach((input, index) => {
                input.addEventListener("input", function() {
                    const rowId = `preview-${input.id}`;
                    const existingRow = document.getElementById(rowId);
        
                    const value = input.value.trim(); // Remove any unnecessary whitespace
        
                    if (value) { // Only proceed if the value is non-empty
                        if (!existingRow) {
                            // Create a new row
                            const newRow = document.createElement("tr");
                            newRow.id = rowId;
        
                            const cell = document.createElement("td");
                            cell.style.border = "1px solid #dee2e6";
                            cell.style.padding = "8px";
                            cell.style.color = "#495057";
        
                            // Add the label (field name) above the value
                            const label = document.createElement("div");
                            label.style.fontSize = "10px"; // Smaller font size for the label
                            label.style.color = "#6c757d"; // Muted text color
                            label.style.marginBottom = "4px";
                            label.textContent = input.id || input.id; // Use 'name' or 'id' as label
        
                            const valueDiv = document.createElement("div");
                            valueDiv.style.fontSize = "12px"; // Standard font size for the value
                            valueDiv.textContent = value;
        
                            cell.appendChild(label);
                            cell.appendChild(valueDiv);
        
                            newRow.appendChild(cell);
        
                            // Assign rows to Part 1 or Part 2 tables based on index
                            if (index < 12) {
                                previewPart1.appendChild(newRow); // First half
                            } else {
                                previewPart2.appendChild(newRow); // Second half
                            }
                        } else {
                            // Update the existing row's value
                            const cell = existingRow.children[0];
                            cell.children[1].textContent = value; // Update the value
                        }
                    } else if (existingRow) {
                        // Remove the row if the value becomes empty
                        existingRow.remove();
                    }
                });
            });
        });
        </script>
        
        
            
@include('layouts.script')


</body>
</html>