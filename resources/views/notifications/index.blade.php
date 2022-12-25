@extends('layouts.app')
@section('content')
    Notifications page
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">Notifications</div>

            <div class="p-2">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Message</th>
                    </tr>
                    </thead>
                    @foreach($notification as $n)
                        <tr data-id="{{$n['id']}}">
                            <td>
                                <div class="ms-2">
                                    @if('pending' == $n['status'])
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif('read' == $n['status'])
                                        <span class="badge bg-info">Read</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted">
                                {{$n->content}}<br>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            $('table tr').on('click', e => {
                const notificationId = e.currentTarget.dataset.id;
                window.location.href = `/notifications/${notificationId}`
            })
        })
    </script>
@endsection
