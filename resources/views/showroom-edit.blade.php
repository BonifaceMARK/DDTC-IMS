{{-- @include('layouts.header')

<body>
    <div class="container-fluid mt-2">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
        <!-- Form to edit a unit -->
        <form action="{{ route('update-unit', ['id' => $unit->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Table for organized input fields -->
            <table class="table table-bordered" style="font-size: 12px;">
                <tr>
                    <th>Brand 
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $unit->brand }}">

                    </th>
                    <th>Model
                        <input type="text" class="form-control" id="model" name="model" value="{{ $unit->model }}">

                    </th>
                    <th>Remarks
                        <textarea type="text" class="form-control" id="remarks" name="remarks" rows="1" value="{{ $unit->remarks }}"></textarea>

                    </th>
                </tr>
                <tr>
                    <th>Device Type
                        <input type="text" class="form-control" id="dev_type" name="dev_type" value="{{ $unit->dev_type }}">
                    </th>
                
                    <th>Serial Number
                        <input type="text" class="form-control" id="ser_no" name="ser_no" value="{{ $unit->ser_no }}">

                    </th>
                  
                </tr>
              <tr>

                <th>Area
                    <input type="text" class="form-control" id="area" name="area" value="{{ $unit->area }}">

                </th>
                <th>Quantity
                    <input type="number" class="form-control" id="qty" name="qty" value="{{ $unit->qty }}">

                </th>
                <th>Age - Stock Period
                    <input type="text" class="form-control" id="age" name="age" value="{{ $unit->age }}" readonly>
                </th>
                
               
              </tr>
                <tr>
                    <th>Property Tag
                        <input type="text" class="form-control" id="prop_tag" name="prop_tag" value="{{ $unit->prop_tag }}">
    
                    </th>
                    <th>Status
                        <input type="text" class="form-control" id="stats" name="stats" value="{{ $unit->stats }}">

                    </th>
                   
                    
                </tr>
                <tr>
                    <th>Location
                        <input type="text" class="form-control" id="location" name="location" value="{{ $unit->location }}">

                    </th>
                    <th>Description
                        <input type="text" class="form-control" id="descript" name="descript" value="{{ $unit->descript }}">

                    </th>
                    
                </tr>
                <tr>
                    <th>Date Added
                        <input type="date" class="form-control" id="date_add" name="date_add" value="{{ $unit->date_add }}">

                    </th>
                    <th>Date Pullout
                        <input type="date" class="form-control" id="date_pull" name="date_pull" value="{{ $unit->date_pull }}">

                    </th>
               
                </tr>
                <tr>
                    <th>File Attachment
                        @if($unit->file_att)
                        <small class="text-muted">Current file: {{ $unit->file_att }}</small>
                    @endif
                    </th>
                    <td>
                        <input type="file" class="form-control" id="file_att" name="file_att">
                      
                    </td>
                   
                    <th>Unit Status
                        <input type="text" class="form-control" id="unit_stat" name="unit_stat" value="{{ $unit->unit_stat }}">

                    </th>
                </tr>
            </table>

            <!-- Action buttons -->
            <div class="mt-3">
                <button type="submit" class="btn btn-success" style="font-size: 12px;">Update Unit</button>
                <a href="javascript:history.back();" class="btn btn-secondary" style="font-size: 12px;">Cancel</a>
            </div>
        </form>
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
      @include('layouts.footer')
@include('layouts.script')
</body>
 --}}
