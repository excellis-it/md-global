@if (isset($chat_call))
    <div class="dr-chat-request-box">
        <div class="dr-cam-img">
            <a href="javascript:void(0);" id="zoom-video-{{ $reciver->id }}" data-id="{{ $reciver->id }}"
                class="video-call-deactive">
                <div class="cam-img">
                    <span><i class="fa-solid fa-video"></i></span>
                </div>
            </a>
        </div>
        <div class="profile-text">
            <div id="{{ $reciver->id }}-chatStatus" class="dr-chat-request-img">
                @if ($reciver->profile_picture)
                    <img src="{{ Storage::url($reciver->profile_picture) }}" alt="">
                @else
                    <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                @endif
            </div>
            <div class="dr-chat-request-name">
                <h2>{{ $reciver->name }}</h2>
            </div>

        </div>

        <div class="chat-sec-box chat-srl_1" id="chat-container">
            @if ($chats->count() > 0)
                @foreach ($chats as $key => $chat)
                    @if ($chat->sender_id == Auth::user()->id)
                        <div class="chat-sec-left chat-sec-right pb-1">
                            <div class="chat-sec-left-wrap d-flex justify-content-end">
                                <div class="chat-sec-left-text-box">
                                    <div class="chat-sec-left-text">
                                        <p>
                                            {{ $chat->message }}
                                        </p>
                                    </div>
                                    <div class="tm-div d-block pt-2 text-end">
                                        <h4>
                                            {{ date('h:i A', strtotime($chat->created_at)) }}
                                        </h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="chat-sec-left pb-1">
                            <div class="chat-sec-left-wrap d-flex">

                                <div class="chat-sec-left-text-box">
                                    <div class="chat-sec-left-text">
                                        <p>
                                            {{ $chat->message }}
                                        </p>
                                    </div>
                                    <div class="tm-div d-block pt-2">
                                        <h4>
                                            {{ date('h:i A', strtotime($chat->created_at)) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                {{-- show no chat found --}}
                <div class="chat-not-available">
                    <h4 class="text-center">No Chat Yet ... </h4>
                    <p class="text-center">
                        Start Chatting with your patient now.
                    </p>
                </div>
            @endif

        </div>
        <div class="chat_form-div">
            <form action="javascript:void(0);" id="chat-form">
                <input type="hidden" class="reciver_id" value="{{ $reciver->id }}">
                <div class="type-sec d-flex justify-content-center align-items-center">
                    <div class="type-div">
                        <div class="form-group">
                            <input type="text" class="form-control" id="user-chat" value=""
                                placeholder="Type here..." required="">
                        </div>
                    </div>
                    <div class="send-div">
                        <button type="submit" value="Submit"><img src="{{ asset('frontend_assets/images/send.png') }}"
                                alt=""></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endif
<script src="{{ asset('js/app.js') }}"></script>
<script>
    Echo.join("status-update")
        .here((users) => {
            for (let x = 0; x < users.length; x++) {
                if (users[x].id != sender_id) {
                    $("#zoom-video-" + users[x].id).addClass("video-call-active");
                    $("#zoom-video-" + users[x].id).removeClass(
                        "video-call-deactive"
                    );

                }
            }
        })
        .joining((user) => {
            if (user.id != sender_id) {
                $("#zoom-video-" + user.id).addClass("video-call-active");
                $("#zoom-video-" + user.id).removeClass("video-call-deactive");
            }
        })

        .leaving((user) => {
            if (user.id != sender_id) {
                $("#zoom-video-" + user.id).addClass("video-call-deactive");
                $("#zoom-video-" + user.id).removeClass("video-call-active");
            }
        });
</script>
