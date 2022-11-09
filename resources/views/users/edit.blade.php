@extends('layouts.app')
@section('content')
<div class="container-fluid mt-3">
    <div class="card col-md-7">
        <div class="card-header text-uppercase">Edit Users</div>
        <div class="card-body">
            <form action="" method="post" class="">
                @csrf
                {{$errors}}
                <div class="form-group">
                    <label for="name" class="mt-2">Name</label>
                    <input type="text" id="name" name="name" class="form-control"
                    value="{{old('name', $user['name'])}}">
                </div>

                <div class="form-group">
                    <label for="email" class="mt-2">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                    value="{{old('email', $user['email'])}}">
                </div>

                <div class="form-group">
                    <label for="role" class="mt-2">Role</label>
                    <input type="text" id="role" name="role" class="form-control"
                    value="{{old('role', $user['role'])}}">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary mt-3">
                        <i class="fa fa-update"></i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
