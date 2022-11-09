@extends('layouts.app')
@section('content')
    <div class="container-fluid col-md-10 mt3">


        <div class="card mt-3">

            <div class="card-header text-uppercase">Users</div>
            <div class="card-body">
                <div class="text-end">


                    <a href="" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i>
                        Add User
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>{{$u->id}}</td>

                            <td><a href="{{Route('users.show', $u->id)}}" style="text-decoration: none" class="">
                                    {{$u->name}} </a></td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->role}}</td>
                            <div class="row">
                                <td>
                                    <a href="{{Route('users.edit', $u->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>

                                    <a href="{{Route('user.delete', $u->id)}}" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </a>
                                </td>

                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class=" p-2">
                {{$users->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
@endsection
