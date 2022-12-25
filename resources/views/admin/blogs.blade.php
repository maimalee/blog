@extends('layouts.app')
@section('content')

         <div class="container mt-5">
            <div class="card col-md-10">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Blog Owner</th>
                            <th>USER ID</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{$blog->id}}</td>
                                <td><a href="{{Route('blog.show', $blog['id'])}}"
                                       style="text-decoration: none">{{$blog->blog_content}}</a></td>
                                <td>{{$blog->name}}</td>
                                <td>{{$blog->userId}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="col-md-10 mt-2">
                {{$blogs->links('pagination::bootstrap-5')}}
            </div>
        </div>

@endsection
