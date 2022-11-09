
@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Comment</div>

                <div class="card-body col-md-8 position-relative">
                    <form action="" method="post">
                        @csrf
                        {{$errors}}

                        <div class="form-group">
                            <input type="hidden" value="{{Auth()->user()['id']}}" name="user_id" id="user_id" class="form-control">
                        </div>
                         <div class="form-group">
                            <input type="hidden" value="{{$blogs->id}}" name="blog_id" id="blog_id" class="form-control">
                        </div>



                        <div class="form-group">
                            <label for="blog_content" class="">Blog Comment</label>
                            <textarea name="comment_content" class="form-control" id="comment_content" cols="30" rows="10"></textarea>
                        </div>

                        <div class="text-end mt-2">
                            <button class="btn btn-primary">
                                <i class="fa fa-plus"></i>Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
