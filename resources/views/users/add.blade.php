@extends('layouts.app')
@section('content')
    <div class="container-fluid col-md-8 mt-3">
        <div class="card">
            <div class="card-header text-uppercase">Create New User</div>

            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    {{$errors}}
                    <div class="form-group">
                        <label for="name" class="mt-2">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="email" class="mt-2">Email:</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="role" class="mt-2">Role:</label>
                        <select name="role" id="role" class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password" class="mt-2">Password</label>
                        <input type="password" class="form-control" id="passowrd" name="password">
                    </div>

                    <div class="text-end">
                        <button class="btn btn-sm btn-primary mt-3">
                            <i class="fa fa-plus m-lg-1"></i>Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
