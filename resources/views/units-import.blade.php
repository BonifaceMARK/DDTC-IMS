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

        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control" name="file" required>
                            <button type="submit" class="btn btn-primary" style="font-size: 12px">Upload</button>
                        </form>
                        
                    </td>
                   
                </tr>
            </tbody>
        </table>

        <div class="mt-3">
            {{-- <button type="submit" class="btn btn-primary">Import</button> --}}
            {{-- <a href="{{ url('users') }}" class="btn btn-secondary" style="font-size: 12px;">Cancel</a> --}}
        </div>
</div>

@include('layouts.script')