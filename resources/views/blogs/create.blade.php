@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Create A New Blog</div>

            <div class="card-body col-md-8 position-relative">
                <form action="" method="post">
                    @csrf
                    {{$errors}}
    @if(Auth()->check())
                    <div class="form-group">
                        <input type="hidden" value="{{Auth()->user()['id']}}" name="user_id" id="user_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="blog_title" class="">Title</label>
                        <input type="text" id="blog_title" name="blog_title" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="blog_content" class="">Blog Content</label>
                        <textarea name="blog_content" class="form-control" id="blog_content" cols="30" rows="10"></textarea>
                    </div>

                    <div class="text-end mt-2">
                        <button class="btn btn-primary">Create Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>@endif
@endsection
