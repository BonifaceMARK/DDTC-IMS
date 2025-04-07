@include('layouts.header')
<body>
    <div class="container-fluid">
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

        <form action="{{ route('units.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" style="font-size: 10px;">
                <tr>
                    <th>Brand
                        <input type="text" class="form-control"  style="font-size: 10px;" id="brand" name="brand" required>
                    </th>
                    <th>Model
                        <input type="text" class="form-control"  style="font-size: 10px;" id="model" name="model" required>
                    </th>
                    <th>Device Type
                        <input type="text" class="form-control"  style="font-size: 10px;" id="dev_type" name="dev_type" required>
                    </th>
                </tr>
            
                <tr>
                    <th>Description
                        <input type="text"  style="font-size: 10px;" class="form-control" id="descript" name="descript" required></th>
                    <th>Serial Number
                        <input type="text" class="form-control"  style="font-size: 10px;" id="serial_no" name="serial_no" required>
                    </th>
                    <th>Area<input type="text" class="form-control"  style="font-size: 10px;" id="area" name="area" required></th>
                    <th>Quantity<input type="number"  style="font-size: 10px;" class="form-control" id="qty" name="qty" required></th>

                </tr>

                <tr>
                    <th>Remarks<textarea class="form-control"  style="font-size: 10px;" id="remarks" name="remarks" rows="1"></textarea></th>
                    <th>Property Tag
                        <input type="text" class="form-control"  style="font-size: 10px;" id="property_tag" name="property_tag" required>
                    </th>
                    <th>Status<input type="text" class="form-control"  style="font-size: 10px;" id="status" name="status"></th>
                    <th>Location<input type="text" class="form-control"  style="font-size: 10px;" id="location" name="location"></th>

                </tr>
              
                <tr>
                    <th>Unit Status
                        <select class="form-control" id="unit_stat" name="unit_stat">
                            <option value=""></option>
                            <option value="Brand New" style="background-color: #d4edda;">✨ Brand New</option>
                            <option value="Good Unit" style="background-color: #d1ecf1;">👍 Good Unit</option>
                            <option value="Demo Unit" style="background-color: #fff3cd;">🔧 Demo Unit</option>
                            <option value="Service Unit" style="background-color: #f8d7da;">🛠️ Service Unit</option>
                          </select>
                        </th>
                      
                         
    
                    <th>Date Added<input type="date" class="form-control"  style="font-size: 10px;" id="date_added" name="date_added"></th>
                    <th>Date Pullout<input type="date" class="form-control"  style="font-size: 10px;" id="date_pullout" name="date_pullout"></th>
                    <th style="font-weight: 100">"Attachment work in progress please be advised." 
                        <input type="file"  style="font-size: 10px;" class="form-control" id="file_attach" name="file_attach"></th>
                </tr>
            </table>

            <!-- Submit button -->
            <div class="mt-3 text-center">
                <a href="{{ route('import.form') }}" class="btn btn-success" style="font-size: 10px;">Import Excel</a>

                <button type="submit" class="btn btn-primary btn-sm"  style="font-size: 10px;">Submit</button>
                <a href="javascript:history.back();" class="btn btn-secondary" style="font-size: 10px;">Cancel</a>
            </div>
        </form>
    </div>
    @include('layouts.footer')
    @include('layouts.script')
</body>
</html>