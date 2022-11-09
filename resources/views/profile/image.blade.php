@extends('layouts.app')
@section('content')
    <div class="container-fluid p-4">
        <div class="card col-md-7">
            <div class="card-header">Add Profile Image</div>

            <form action="" class="p-3" method="post" enctype="multipart/form-data">
                @csrf
                {{$errors}}
                <div class="form-group">
                    <label for="img" class="">Select Photo</label>
                    <input type="file" class="form-control" name="img" id="img">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary mt-3">Add Photo</button>
                </div>
            </form>
        </div>
    </div>
@endsection
