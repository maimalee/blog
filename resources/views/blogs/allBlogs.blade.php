@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="card col-md-8">
            <div class="card-header text-center">All Blogs</div>


            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>User Name</th>
                        <th>Title</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td>{{$blog->id}}</td>
                            <td>{{$blog->name}}</td>
                            <td><a href="{{Route('allblog.show', $blog['id'])}}" style="text-decoration: none">{{$blog->blog_title}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8 mt-2">
            {{$blogs->links('pagination::bootstrap-5')}}
        </div>



@endsection
