@extends('layouts.app')
@section('content')

    @if(Auth()->check())
        <div class="container mt-5">
            <div class="card col-md-10">
                <div class="card-header">{{Auth()->user()['name' ]}}'s Blogs</div>


                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td>{{$blog->id}}</td>
                                <td><a href="{{Route('blog.show', $blog['id'])}}"
                                       style="text-decoration: none">{{$blog->blog_title}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>

                        <div class="text-end">
                            <a href="{{Route('blog.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus m-lg-1"></i>Create Blog</a>
                        </div>
                    </table>
                </div>
            </div>
            <div class="col-md-10 mt-2">
                {{$blogs->links('pagination::bootstrap-5')}}
            </div>
        </div>
    @endif
@endsection
