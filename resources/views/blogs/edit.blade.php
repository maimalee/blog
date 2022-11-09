@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-4">
        <di class="card col-lg-6">
            <div class="card-header text-uppercase">Edit Blog</div>
            <div class="card-body">
                <form action="" class="" method="post">
                    @csrf
                    {{$errors}}

                    <div class="form-group">
                        <label for="blog_title" class="mt-2">Title</label>
                        <input type="text" class="form-control" id="blog_title" name="blog_title" value="{{old('blog_title', $blog['blog_title'] )}}">
                    </div>
                    <textarea name="blog_content" id="blog_content" cols="30" rows="10"
                              class="form-control mt-3" >{{value(old('blog_content', $blog['blog_content']))}}</textarea>
                    <div class="text-end">
                        <button class="btn btn-primary mt-3">
                            <i class="fa fa-refresh"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </di>
    </div>
@endsection
