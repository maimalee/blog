@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card col-md-9">
            <div class="card-header">
                <div class="text-uppercase">
                    User Details
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>UserID#</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Content</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$blog->userId}}</td>
                        <td>{{$blog->name}}</td>
                        <td>{{$blog->blog_title}}</td>
                        <td>{{$blog->blog_content}}</td>

                    </tr>
                    </tbody>

                </table>
                <hr>
                <sm><u><b>Comments</b></u></sm>
                <br>

                @foreach($comment as $c)
                    <div class="m-2">
                        <img class="rounded-circle" src="/images/{{$c['profile']}}" alt="" style="width: 40px; height: 40px;">
                        By <b><i>{{$c->name}}</i></b><br>

                        {{$c->comment_content}}
                           </div>
                @endforeach
                <br>

                <a type="button" href="{{Route('allBlogs')}}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i>
                    Go BAck
                </a>

                <div class="text-end">
                    <a type="button" href="{{Route('comment', $blog->id)}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Add Comment
                    </a>
                </div>

            </div>

        </div>

@endsection

