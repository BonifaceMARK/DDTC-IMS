@include('layouts.header')
<body>
    

<div class="container mt-2">
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
                <th>Device Type
                    <input type="text" class="form-control" id="dev_type" name="dev_type" value="{{ $unit->dev_type }}">

                </th>
            </tr>
            <tr>
                <th>Serial Number
                    <input type="text" class="form-control" id="serial_no" name="serial_no" value="{{ $unit->serial_no }}">

                </th>
                <th>Area
                    <input type="text" class="form-control" id="area" name="area" value="{{ $unit->area }}">

                </th>
                <th>Property Tag
                    <input type="text" class="form-control" id="property_tag" name="property_tag" value="{{ $unit->property_tag }}">

                </th>
            </tr>
          
            <tr>
                <th>Status
                    <input type="text" class="form-control" id="status" name="status" value="{{ $unit->status }}">

                </th>
                <th>Description
                    <input type="text" class="form-control" id="descript" name="descript" value="{{ $unit->descript }}">

                </th>
                <th>Date Added
                    <input type="date" class="form-control" id="date_added" name="date_added" value="{{ $unit->date_added }}">

                </th>
                
            </tr>
            <tr>
                <th>File Attachment
                    @if($unit->file_attach)
                    <small class="text-muted">Current file: {{ $unit->file_attach }}</small>
                @endif
                </th>
                <td>
                    <input type="file" class="form-control" id="file_attach" name="file_attach">
                  
                </td>
                <th>Remarks
                    <textarea type="text" class="form-control" id="remarks" name="remarks" rows="1" value="{{ $unit->remarks }}"></textarea>

                </th>
            </tr>
        </table>

        <!-- Action buttons -->
        <div class="mt-3">
            <button type="submit" class="btn btn-success" style="font-size: 12px;">Update Unit</button>
            <a href="{{ route('view-units', ['limit' => 10]) }}" class="btn btn-secondary" style="font-size: 12px;">Cancel</a>
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
