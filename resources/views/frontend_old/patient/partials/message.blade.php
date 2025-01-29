<div class="row">
    @if(count($notifications) > 0)
    @foreach ($notifications as $notification)
    <div class="col-xl-12">
        <div class="notice-p">
            <p>{{nl2br($notification->message)}} </p>
        </div>
        <div class="notice-date">
            <h4>{{ date('d.m.y', strtotime($notification->created_at)) }} | {{ date('H.i A', strtotime($notification->created_at)) }}</h4>
        </div>
    </div>
    @endforeach
    <div class="pagi_1 justify-content-center">
        <nav aria-label="Page navigation example">
            <div class="">
                {{ $notifications->render() }}
            </div>
        </nav>
    </div>
    @else
    <div class="col-xl-12">
        <div class="notice-p">
            <p>No Notification Found</p>
        </div>
    </div>
    @endif
</div>
