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
                                            </div>
                                        </div>

                                        <div class="dr-chat-box-1 srl-2" id="srl-2">
                                            @if (!empty($friends) && $friends->count() > 0)
                                                @foreach ($friends as $key => $value)
                                                    <div class="dr-chat-box-1 mb-3 user-list" id="userList"
                                                        data-id="{{ $value->id }}" data-query="0">
                                                        <div
                                                            class="profile-div-box dr-chat mb-3 d-flex justify-content-between align-items-center">
                                                            <div
                                                                class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                                <div class="profile-img">
                                                                    @if ($value->profile_picture)
                                                                        <img src="{{ Storage::url($value->profile_picture) }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                            alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="profile-text">
                                                                    <h2>
                                                                        {{ $value->name }}
                                                                    </h2>

                                                                    <p id="{{ $value->id }}-userStatus"><span
                                                                            class="offline-user"></span>Offline</p>
                                                                </div>
                                                            </div>
                                                            <div class="patient-age">
                                                                <h3><span>
                                                                        {{ date('d M Y', strtotime($value->created_at)) }}
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

@endpush
