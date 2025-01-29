@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Chats
@endsection
@push('styles')
@endpush

@section('content')
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.doctor.partials.sidebar')

                <!-- Content -->

                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap">
                            <div class="content-head-wrap d-flex justify-content-between align-items-center">
                                <div class="content-head mb-4">
                                    <h2>Chat History</h2>
                                    <h3>Chat / Chat History</h3>
                                </div>
                            </div>

                            <div class="dr-chat-box-wrap">
                                <div class="row">
                                    <div class="col-xl-5 col-12">
                                        <div class="btn-group d-flex justify-content-end" id="requestBox">
                                            <button type="button" id="btn" class="friend-request"><img
                                                    class="user-img-1"
                                                    src="{{ asset('frontend_assets/images/users.svg') }}"><span
                                                    id="chat-count-{{ Auth::user()->id }}">{{ count($requests) }}</span>
                                            </button>
                                            <!-- <div class="frnd-srl" id="frnd-srl"> -->
                                            <div class="friend-request-box frnd-srl chat-pop"
                                                id="friendbox-{{ Auth::user()->id }}" style="display: none;">
                                                @if (count($requests) == 0)
                                                    <div
                                                        class="no-friend profile-div profile-div-2 profile-div-3 friend-request-div d-flex align-items-center justify-content-center">
                                                        <div class="profile-text">
                                                            <h2>No Friend Request</h2>
                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach ($requests as $friend1)
                                                        <div id="deletebtn" onclick="dltFun();">
                                                        </div>
                                                        <div class="profile-div profile-div-2 profile-div-3 friend-request-div d-flex align-items-center justify-content-center"
                                                            id="friendProfile{{ $friend1->friend_id }}">
                                                            <div class="profile-img">
                                                                @if (isset($friend1->friend->profile_picture))
                                                                    <img src="{{ Storage::url($friend1->friend->profile_picture) }}"
                                                                        alt="">
                                                                @else
                                                                    <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                        alt="">
                                                                @endif
                                                            </div>
                                                            <div class="profile-text">
                                                                @if (isset($friend1->friend->name))
                                                                    <h2>{{ $friend1->friend->name }}</h2>
                                                                @endif
                                                            </div>
                                                            <div id="userId"></div>
                                                            <div class="confirm-btn" data-id="{{ $friend1->id }}">
                                                                <a href="javascript:void(0);">
                                                                    <h4> <span><i class="fa-solid fa-check"
                                                                                id="acceptRequest"></i></span>Confirm
                                                                    </h4>
                                                                </a>
                                                            </div>
                                                            <div class="delete-btn" data-id="{{ $friend1->id }}">
                                                                <a href="javascript:void(0);">
                                                                    <h4> <span><i class="fa-solid fa-trash-can"></i></span>
                                                                    </h4>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="dr-chat-box-1 srl-2 group-manage-{{ Auth::user()->id }}"
                                            id="srl-2">
                                            @if (!empty($friends) && count($friends) > 0)
                                                @foreach ($friends as $key => $value)
                                                    <div class="dr-chat-box-1 mb-3 user-list" id="userList"
                                                        data-id="{{ $value['friend']['id'] }}" data-query="0">
                                                        <div
                                                            class="profile-div-box dr-chat mb-3 d-flex justify-content-between align-items-center">
                                                            <div
                                                                class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                                <div class="profile-img">
                                                                    @if (isset($value['friend']['profile_picture']))
                                                                        <img src="{{ Storage::url($value['friend']['profile_picture']) }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                            alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="profile-text">
                                                                    <h2>
                                                                        {{ isset($value['friend']['name']) ? $value['friend']['name'] : '' }}
                                                                    </h2>

                                                                    {{-- <p id="{{ $value['friend']['id'] }}-userStatus"><span
                                                                            class="offline-user"></span>Offline</p> --}}
                                                                            <p>
                                                                                <span>
                                                                                    {{ $value['last_message']['message'] }}
                                                                                </span>

                                                                            </p>
                                                                </div>
                                                            </div>
                                                            <div class="patient-age">
                                                                <h3><span>
                                                                        {{ $value['last_message']['created_at'] ? date('d M Y', strtotime($value['last_message']['created_at'])) : '' }}
                                                                    </span></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="dr-chat-box-1 mb-3 user-list" data-query="0">

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-12 chat-first-page">
                                        <div class="dr-chat-request-box d-flex align-items-center justify-content-center">
                                            <div class="get-clear-path">
                                                <div class="get-clear-path-img">
                                                    <img src="{{ asset('frontend_assets/images/clear-chat.svg') }}"
                                                        alt="">
                                                </div>
                                                <div class="get-clear-text">
                                                    <h3>Get a Clear Path to Securing Lucrative Government Contracts</h3>
                                                    <p>We coach you to successfully bid on government contracts, doing much
                                                        of the work for you</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xl-7 col-12 chat-module">
                                        @include('frontend.doctor.chat.chat-body')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
    <script>
        var x = document.getElementById("btn");
        // x.addEventListener("click", myFunction, false);

        // function myFunction() {
        //     var y = document.getElementById("friendbox");
        //     if (y.className === "active") {
        //         y.className = "";
        //     } else {
        //         y.className = "active";
        //     }

        // };

        function dltFun() {
            var z = document.getElementById("friendbox");

            if (z.className === "active") {
                z.className = "";
            } else {
                z.className = "active";
            }

        }
    </script>

    <script>
        //show/hide friend request box
        $(document).ready(function() {
            $(document).on("click", "#requestBox", function() {
                const id = "{{ Auth::user()->id }}"
                $("#friendbox-" + id).toggle(); // Toggles the visibility of the div
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var sender_id = "{{ Auth::user()->id }}";
            let ip_address = "{{ env('SOCKET_IP_ADDRESS') }}";
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);

            socket.on('sentFriendRequest', function(data) {
                var pendingChatRequest = data.pendingChatRequest;
                var friendRequest = data.friendRequest;
                var sender = data.sender;
                var recipient = data.recipient;

                if (sender_id == recipient) {
                    // show friend request count
                    $('.no-friend').remove();
                    $("#chat-count-" + recipient).text(pendingChatRequest);

                    // show the friend request box
                    var html = `    <div class="profile-div profile-div-2 profile-div-3 friend-request-div d-flex align-items-center justify-content-center" id="friendProfile${sender}">
                                    <div class="profile-img">`;
                    if (friendRequest.friend.profile_picture) {
                        html +=
                            `<img src="{{ Storage::url('${friendRequest.friend.profile_picture}') }}" alt="">`;
                    } else {
                        html += `<img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">`;
                    }

                    html += `</div>
                                    <div class="profile-text">
                                        <h2>${friendRequest.friend.name}</h2>
                                    </div>
                                    <div id="userId"></div>
                                    <div class="confirm-btn" data-id="${friendRequest.id}">
                                        <a href="javascript:void(0);">
                                            <h4> <span><i class="fa-solid fa-check" id="acceptRequest"></i></span>Confirm
                                            </h4>
                                        </a>
                                    </div>
                                    <div class="delete-btn" data-id="${friendRequest.id}">
                                        <a href="javascript:void(0);">
                                            <h4> <span><i class="fa-solid fa-trash-can"></i></span>
                                            </h4>
                                        </a>
                                    </div>
                                </div>`;
                    $(".friend-request-box").append(html);
                }
            });

            $(document).on("click", ".confirm-btn", function() {
                let friendId = $(this).data('id');
                $.ajax({
                    url: "{{ route('doctor.chat.accept') }}",
                    type: "POST",
                    data: {
                        _token: $("input[name=_token]").val(),
                        friendId: friendId
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#friendProfile" + response.acceptedUser.id).remove();

                            let id =
                                sender_id; // Ensure sender_id is defined and available here
                            let chatCount = $("#chat-count-" + id).html();
                            chatCount = parseInt(chatCount) - 1;
                            $("#chat-count-" + id).html(chatCount);

                            let user = response.acceptedUser;

                            $('#srl-2').prepend(`
                    <div class="dr-chat-box-1 mb-3 user-list" id="userList" data-id="${user.id}" data-query="0">
                        <div class="profile-div-box dr-chat mb-3 d-flex justify-content-between align-items-center">
                            <div class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                <div class="profile-img">
                                    <img src="${response.acceptedUser_profile_picture}" alt="">
                                </div>
                                <div class="profile-text">
                                    <h2>${user.name}</h2>
                                     <p> <span>${response.chat.message}</span></p>
                                </div>
                            </div>
                            <div class="patient-age">
                                <h3><span>${response.accepterUser_created_at}</span></h3>
                            </div>
                        </div>
                    </div>
                `);

                            // Ensure socket object is properly initialized
                            if (typeof socket !== 'undefined') {
                                socket.emit('confirmFriendRequest', {
                                    sender: id,
                                    recipient: user.id,
                                    chat: response.chat,
                                });
                            } else {
                                console.log('Socket is not defined');
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();
                var friendId = $(this).data("id");
                var url = "{{ route('doctor.chat.reject') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: $("input[name=_token]").val(),
                        friendId: friendId,
                    },
                    success: function(res) {
                        if (res.status == true) {
                            $("#friendProfile" + res.chatRequest.friend_id).remove();
                            const requestCount = $("#chat-count-" + res.chatRequest.user_id)
                                .text();
                            $("#chat-count-" + res.chatRequest.user_id).text(
                                parseInt(requestCount) - 1
                            );
                            socket.emit('rejectFriendRequest', {
                                sender: res.chatRequest.user_id,
                                recipient: res.chatRequest.friend_id,
                            });

                        } else {
                            console.log(res.msg);
                        }
                    },
                });
            });



            $(document).on("click", ".video-call-active", function(e) {
                var receiver_id = $(this).attr("data-id");
                const id = sender_id;
                // loader
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajax({
                    type: "POST",
                    url: "{{ route('doctor.video-call') }}",
                    data: {
                        _token: $("input[name=_token]").val(),
                        receiver_id: receiver_id,
                        sender_id: id,
                    },
                    // loader: true,
                    success: function(resp) {
                        if (resp.status == true) {
                            // window.location.href = resp.meeting.data.start_url;
                            // open location in new tab
                            window.open(resp.videocall.start_url, '_blank');

                            socket.emit('videoCall', {
                                sender: id,
                                recipient: receiver_id,
                                videocall: resp.videocall,
                            });

                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                        } else {
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                            toastr.error(resp.message);
                        }
                    },
                });
            });

        });
    </script>
@endpush
