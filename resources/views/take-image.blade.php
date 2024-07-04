@extends('layouts.main')

@section('title', 'Capture Image')
@section('scripts')

@endsection
@section('content')
    <h1>Capture new image</h1>

    <form method="POST" action="{{ route('getEncodings') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <span class="text-danger">{{ $errors->first('image') }}</span>
                <br/>
                <button class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>

</script>
@endsection

