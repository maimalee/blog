@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header text-uppercase">`User Info</div>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created_At</th>
                    <th>No Blog(s) Created</th>
                    <th>comments</th>
                    <th>Like(s)</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->created_at}}</td>
                    <td><b><i>{{$blogCount}}</i></b></td>
                    <td><b><i>{{$totalComment}}</i></b></td>
                    <td><b><i>{{$totalLike}}</i></b></td>
                </tr>
                </tbody>

            </table>

        </div>
        <a href="{{Route('users.all')}}" class="btn btn-primary btn-sm mt-4">
            <i class="fa fa-arrow-left"></i>
            Go Back
        </a>
    </div>

@endsection
