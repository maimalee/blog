@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card col-md-7">
            <div class="card-header">
                <div class="text-uppercase">
                    User Details
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID#</th>

                        <th>Title</th>
                        <th>Content</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$blog->id}}</td>
                        <td>{{$blog->blog_title}}</td>
                        <td>{{$blog->blog_content}}</td>

                    </tr>

                    </tbody>


                </table>
                <div class="text-end">
                    <a href="{{Route('blog.edit', $blog['id'])}}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>Edit</a>
                    <a href="{{Route('blog.delete', $blog['id'])}}" class="btn btn-danger">
                        <i class="fa fa-trash"></i>Delete</a>
                </div>
                <br>

                <sm><b><u>Comments</u></b></sm>
                <br>
                @foreach($comment as $c)
                    {{$c->comment_content}}
                    <br>By <b><i>{{$c->name}}</i></b>
                @endforeach
                <br>
                @if(Auth()->user()->role =='admin')
                    <a type="button" href="{{Route('admin.blog')}}" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-left"></i>
                        Go BAck admin
                    </a>
                @elseif(Auth()->user()->role =='user')
                    <a type="button" href="{{Route('blogs.index')}}" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-left"></i>
                        Go Back user
                    </a>

                @endif
            </div>
        </div>
    </div>
@endsection
