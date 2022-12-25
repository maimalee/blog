@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-2">
            <hr>
            <div class="col-md-1">
                @if($blog->profile === null)
                    <img class="rounded-circle" src="/images/th.webp" alt="" style="width: 60px; height: 60px;">
                @else
                    <img class="rounded-circle" src="/images/{{$blog->profile}}" alt=""
                         style="width: 60px; height: 60px;">
                @endif
            </div>
            <div class="col-md-11">
                <b>@ {{$blog->name}}</b>
                {{$blog->created_at}}
                <span class="text-end">
                        <a href="" style="text-decoration: none" class="m-lg-2">
                            ...
                        </a>
                    </span>
                <br>
                <a href="{{Route('allblog.show', $blog['id'])}}"
                   style="text-decoration: none">{{$blog->blog_content}}</a>
                <div class="mt-4" style="display: table">
                    <div class="container text-center">
                        @foreach($blog['image_chunks'] as $chunk)
                            <div class="row mb-1">
                                @foreach($chunk as $src)
                                    <div class="col-md-4" style="margin: 0 12px">
                                        <img
                                            style="width: 150px;height: 150px; border-radius: 4px;"
                                            src="/images/{{$src}}" alt="">

                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
            <div class="mt-2 col-md-6 p-lg-4">
                <hr>
                <span id="like-count">{{$likes}}</span> Likes
                {{$comm}} Comments
                <hr>
            </div>
            <div class="mt-2">

                    <button class="btn btn-link  btn-like">
                     <span class="mt-1" id="like-button">
                        <i class="fa fa-heart m-lg-4"></i>
                     </span>
                    </button>


                    <span class="p-1">
                            <a href="" class=" text-decoration-none">
                                <i class="fa fa-share-alt m-lg-4"></i>
                            </a>
                            <a href="{{Route('comment', $blog->id)}}" class="text-decoration-none">
                                 <i class="fa fa-comment m-lg-4"></i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fa fa-retweet m-lg-4"></i>
                            </a>

                    </span>


            </div>
        </div>

        @if($comm==0)
            No Comment for this post
        @elseif($comm > 0)

            @foreach($comment as $c)

                <div class=" mt-4 col-md-6">
                    <hr>
                    <div class="m-2">
                        @if($c->profile)
                            <img class="rounded-circle" src="/images/{{$c['profile']}}" alt=""
                                 style="width: 40px; height: 40px;">
                        @else
                            <img class="rounded-circle" src="/images/th.webp" alt=""
                                 style="width: 40px; height: 40px;">
                        @endif
                        <span class="">
                        {{$c->id}}
                        <b><i>{{$c->name}} </i></b>
                        Posted On <b><i>{{$c->created_at}}</i></b><br>
                         replying to @ <a href="{{Route('friend.profile', $blog->userId)}}"
                                          class="text-decoration-none">



                            {{$blog->name}}
                        </a>
                                <br>
                        {{$c->comment_content}}



                                <div class="mt-2" style="margin-left: 20px">
                                    <span class="" id="comment-count-{{$c['id']}}">
                                        {{$c['total_likes']}}
                                    </span>
                                    <button type="button" class="btn btn-link btn-comment-like"
                                            data-comment-id="{{$c['id']}}">
                                          <i class="fa fa-heart m-lg-4"></i>
                                    </button>
                                    <a href="" class="text-decoration-none">
                                        <i class="fa fa-retweet m-lg-4"></i>
                                    </a>

                                   <a href="" data-toggle="modal" data-target="#reply-modal-{{$c->id}}">
                                        <i class="fa fa-comment m-lg-4"></i>
                                   </a>

                                    <a href="" class=" text-decoration-none">

                                <i class="fa fa-share-alt m-lg-4">

                                </i>
                            </a>

                                </div>
`
                    </span>
                        <!-- Modal -->
                        <div class="modal fade" id="reply-modal-{{$c->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post" id="reply_form">
                                        <div class="modal-body">
                                            @csrf
                                            {{$errors}}
                                            <div class="form-group">
                                                <input type="hidden" value="{{$blog->id}}" name="blog_id"
                                                       id="blog_id"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" value="{{$blog->userId}}"
                                                       name="user_id"
                                                       id="user_id" class="">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" value="{{$c->id}}" class="form-control"
                                                       name="comment_id"
                                                       id="comment_id">
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" class="form-control"
                                                       value="{{$c->userId}}" name="comment_owner"
                                                       id="comment_owner">
                                            </div>
                                            <div class="form-group">
                                            <textarea name="reply_content" id="" cols="30" rows="10"
                                                      class="form-control"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Close
                                                </button>
                                                <button onclick="form_submit()" class="btn btn-primary">
                                                    Send
                                                </button>
                                            </div>


                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-2 p-2" style="padding-left: 10px">
                                        <span class="mt-1">
                                            <div class="row">
                                                <div class="col-md-1">

                                                </div>
                                            </div>
                                            @foreach($reply as $r)
                                                @if($r->blog_id == $blog->id && $c->id == $r->comment_id  )
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="">
                                                                    @if($r->profile)
                                                                        <img class="rounded-circle"
                                                                             src="/images/{{$r['profile']}}" alt=""
                                                                             style="width: 40px; height: 40px;">
                                                                    @else
                                                                        <img class="rounded-circle"
                                                                             src="/images/th.webp" alt=""
                                                                             style="width: 40px; height: 40px;">
                                                                    @endif
                                                                      <b><i> {{$r->name}}</i></b><br>
                                                                </div>
                                                                <div class="">
                                                                    replying to @
                                                                    <a href="{{Route('friend.profile', $c->userId)}}"
                                                                       class="text-decoration-none">
                                                                        {{$c->name}}
                                                                    </a>
                                                                    <br> {{$r->reply_content}}

                                                                                 <div class="mt-2" style="margin-left: 20px">
                                                                                      <span class="" id="reply-count-{{$r['id']}}">
                                                                                            {{$r->total_reply_likes}}
                                                                                      </span>

                                                                            <button type="button" class="btn btn-link btn-reply-like"
                                                                                    data-reply-id="{{$r['id']}}" data-comment-id="{{$c['id']}}">
                                                                                <i class="fa fa-heart"></i>
                                                                            </button>
                                                                               <a href="" class="text-decoration-none">
                                                                            <i class="fa fa-retweet m-lg-4"></i>
                                                                        </a>

                                                                       <a href="" data-toggle="modal"
                                                                          data-target="#reply-modal-{{$c->id}}">
                                                                            <i class="fa fa-comment m-lg-4"></i>
                                                                       </a>

                                                                         <a href="" class=" text-decoration-none">

                                                                            <i class="fa fa-share-alt m-lg-4">

                                                                            </i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                    </div>
                                                    <hr>
                                                @endif
                                            @endforeach
                    </span>
                            <span style="cursor: pointer" class="" data-toggle="modal"
                                  data-target="#reply-modal-{{$c->id}}">
                        </span>
                        </div>

                    </div>

                </div>

            @endforeach
            {{--            <div class="mt-2">--}}
            {{--                {{$comment->links('pagination::bootstrap-5')}}--}}
            {{--            </div>--}}
        @endif
        <br>

        <a type="button" href="{{Route('allBlogs')}}" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i>
            Go BAck
        </a>
        <div class="text-end">

        </div>
    </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        const loggedUserId = {{\auth()->id()}};
        const blogId = {{$blog['id']}};

        function form_submit() {
            document.getElementById("reply_form").submit();
        }

          $('button.btn-like').on('click', e => {
              const spanLikeCount = document.getElementById('like-count');
              e.preventDefault();
            $.ajax({
                url: '{{url('api/blogs/' . $blog['id'] . '/like')}}?userId={{\auth()->id()}}',
                method: 'POST',
                success(data) {
                    if (data.hasOwnProperty('increment')) {
                        spanLikeCount.innerHTML = parseInt(spanLikeCount.innerHTML) + 1;
                        // spanLikeButton.backgroundColor = color.red;
                    }

                    if (data.hasOwnProperty('decrement')) {
                        spanLikeCount.innerHTML = parseInt(spanLikeCount.innerHTML) - 1;
                    }
                }
            });
        })

        $('button.btn-comment-like').on('click', e => {
            e.preventDefault();
            const button = e.currentTarget;
            const commentId = button.dataset.commentId
            const $spanLikeCount = $(`span#comment-count-${commentId}`);
            $.ajax({
                url: `/api/blogs/${blogId}/comments/${commentId}/like?userId=${loggedUserId}`,
                method: 'POST',
                success(data) {
                    if (data.hasOwnProperty('increment')) {
                        const incremented = parseInt($spanLikeCount.html()) + 1
                        $spanLikeCount.html(incremented)
                    }

                    if (data.hasOwnProperty('decrement')) {
                        const incremented = parseInt($spanLikeCount.html()) - 1
                        $spanLikeCount.html(incremented)
                    }
                }
            });
        })
        $('button.btn-reply-like').on('click', e => {
            e.preventDefault();
            const button = e.currentTarget;
            const commentId = button.dataset.commentId
            const replyId = button.dataset.replyId
            const $spanLikeCount = $(`span#reply-count-${replyId}`)
            $.ajax({
                url: `/api/blogs/${blogId}/comments/${commentId}/replies/${replyId}/like?userId=${loggedUserId}`,
                method: 'POST',
                success(data) {
                    if (data.hasOwnProperty('increment')) {
                        const incremented = parseInt($spanLikeCount.html()) + 1
                        $spanLikeCount.html(incremented)
                    }
                    if (data.hasOwnProperty('decrement')) {
                        const incremented = parseInt($spanLikeCount.html()) - 1
                        $spanLikeCount.html(incremented)
                    }
                }
            });
        })
    </script>
@endsection
