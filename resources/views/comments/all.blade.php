@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="card col-md-12">
            <div class="card-header text-uppercase">Comments</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Blog Id</th>
                        <th>User Name</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($comment as $c)
                    <tr>
                        <td>{{$c->id}}</td>
                        <td>{{$c->blog_id}}</td>
                        <td>{{$c->name}}</td>
                        <td><a href="{{Route('comment.all', $c['id'])}}" style="text-decoration: none">{{$c->comment_content}}</a></td>
                        <td>
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>

                            <a href="{{Route('comment.delete', $c->id)}}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="">
                {{$comment->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
@endsection
