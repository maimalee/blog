@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create A New Blog</div>

                <div class="card-body col-md-8 position-relative">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{$errors}}
                        @if(Auth()->check())
                            <div class="form-group">
                                <input type="hidden" value="{{Auth()->user()['id']}}" name="user_id" id="user_id"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="blog_content" class="">Blog Content</label>
                                <textarea name="blog_content" class="form-control" id="blog_content" cols="30"
                                          rows="10"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="" class="">Add Image(s)</label>
                                <input type="file" class="form-control" name="filename[]" id="filename" multiple>
                            </div>
                            <div class="form-group">
                                <label for="tags" class="mt-2">Tags</label>
                                <select class="tags form-control" id="tags" name="tags[]" multiple="multiple">
                                    @foreach($friends as $f)
                                        <option value="{{$f->userId}}">{{$f->name}}</option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="text-end mt-2">
                                <button class="btn btn-primary">Create Blog</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.tags').select2();
        })
    </script>
@endsection
