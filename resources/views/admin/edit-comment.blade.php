@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Edit Comment
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        {{$errors}}

                        <div class="form-group">
                            <label for="comment_content" class="">Comment</label>
                            <textarea name="comment_content" id="" cols="30" rows="10" class="form-control mt-3">
                                {{value(old('comment_content', $comment['comment_content']))}}
                            </textarea>
                            <div class="text-end mt-2">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-refresh me-2"></i>
                                    Update
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
