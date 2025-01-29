@if (isset($accept))
    <div class="modal on-modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="mdl-img">
                    <div class="find-doc-slide-img">
                        @if ($doctor['profile_picture'])
                            <img src="{{ Storage::url($doctor['profile_picture']) }}" alt="">
                        @else
                            <img src="{{ asset('frontend_assets/images/fd-2.png') }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $doctor['name'] }}</h5>
                </div>
                <div class="modal-body">
                    <div class="mdl-cam">
                        <i class="fa-sharp fa-solid fa-video"></i>
                    </div>
                    <div class="mdl-btn">
                        <a href="javascript:void(0)" id="payment_now" class="pay-now" data-receiverid="{{ Auth::user()->id }}"
                            data-id="{{ $videocall_id }}"><span>Pay & continue</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
