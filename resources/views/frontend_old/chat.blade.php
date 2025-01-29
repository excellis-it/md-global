@if (isset($chat_call))
    <div class="container">
        <div class="chat-sec-wrap">
            @if ($chats->count() > 0)
                <div class="chat-sec-box chat-srl_1 infinite-scroll" id="chat-container">
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
                </div>
                <form action="javascript:void(0);" id="chat-form">
                    <input type="hidden" class="reciver_id" value="{{ $doctor['id'] }}">
                    <div class="type-sec d-flex justify-content-between align-items-center">
                        <div class="type-div">
                            <div class="form-group">
                                <input type="text" class="form-control" id="user-chat" value=""
                                    placeholder="Type here..." required="">
                            </div>
                        </div>
                        <div class="send-div">
                            <button type="submit" value="Submit"><img
                                    src="{{ asset('frontend_assets/images/send.png') }}" alt=""></button>
                        </div>
                    </div>
                </form>
            @else
                <!-- <div class="chat-sec-box chat-srl_1" id="chat-container">
                    {{-- show no chat found --}}
                    <div class="chat-not-available">
                        <h4 class="text-center">No Chat Yet ... </h4>
                        <p class="text-center">
                            Start messaging with {{ $doctor['name'] }} to get your queries answered.
                        </p>
                    </div>

                </div> -->
                <section class="chat-request">
                    <div class="container">
                        <div class="chat-request-wrap">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-12">
                                    <div class="chat-request-img-div">
                                        <div class="chat-request-img">
                                            @if ($doctor['profile_picture'])
                                                <img src="{{ Storage::url($doctor->profile_picture) }}" alt="">
                                            @else
                                                <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <div class="chat-request-name">
                                            <h3>{{ $doctor['name'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-6">
                                            <div class="main-btn-p pt-4 text-center">
                                                <input type="submit" @if($friendRequestStatus !='' && $friendRequestStatus == 0) value="Chat request sent"  @else value="Send Chat request"  id="send_request"  @endif
                                                    class="sub-btn chat-request-button">
                                                <input type="hidden" name="chat_count" value="{{ $chat_count }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="doc-busy" id="doctor-busy">
                            @if ($friendRequestStatus!='' && $friendRequestStatus == 2)
                            <p>Medical Stuff Busy right now. Please try again latar</p>
                            @endif
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endif

<script>
    $(document).ready(function() {
        // if chat count 0 then hide chat box
        var chat_count = $("input[name='chat_count']").val();
        if (chat_count == 0) {
            $("#chat-container").hide();
        }


        $(document).on("click", "#send_request", function() {
            var senderUserId = "{{ Auth::user()->id }}";
            var recipientUserId = "{{ $doctor['id'] }}";
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
            axios.post('/send-chat-request', {
                sender: senderUserId,
                recipient: recipientUserId
            }).then(response => {
                // remove id from send request button
                $("#send_request").val('Chat request sent')
                $("#send_request").removeAttr("id");
                $('#doctor-busy').html('')
                $('#loading').removeClass('loading');
                $('#loading-content').removeClass('loading-content');
                // redirect to chat page after 2 seconds
                setTimeout(function() {
                    $("#chat-container").show();
                }, 1000);

            }).catch(error => {
                console.error(error);
            });
        });
    });
</script>
