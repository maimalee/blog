@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header text-uppercase">Update User Info</div>
         <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                 <th>Created_At</th>
                <th>No Blog(s) Created</th>
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
               </tr>
            </tbody>
        </table>
    </div>
    </div>

@endsection
