@php
    use App\Helpers\Helper;
@endphp
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
                    {{-- <div class="mdl-cam">
                        <i class="fa-sharp fa-solid fa-video"></i>
                    </div> --}}
                    @if (count(Helper::video_call_prices()) > 0)
                        @foreach (Helper::video_call_prices() as $key => $video_call_price)
                            <div class="col-xl-12">
                                <input type="radio" name="telehealth_plan" id="tele-{{$key}}" value="{{ $video_call_price['id'] }}" class="video-call-price d-none" {{$key == 0 ? 'checked' : ''}}>
                                <label for="tele-{{$key}}" class="w-100">
                                    <div class="telehealth_plan">
                                        <span>{{ $video_call_price['title'] }}</span>
                                        <h5>{{ $video_call_price['price'] > 0 ? '$' . $video_call_price['price'] : 'Free' }}
                                            /
                                            {{ $video_call_price['duration'] ? $video_call_price['duration'] . ' Min' : 'Free' }}
                                        </h5>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    @else
                        <div class="col-xl-12">
                            <div class="d-flex justify-content-center align-items-center">
                                <h5>No Telehealth Plan Available</h5>
                            </div>
                        </div>
                    @endif
                    <div class="mdl-btn">
                        <a href="javascript:void(0)" id="payment_now" class="pay-now"
                            data-receiverid="{{ Auth::user()->id }}" data-id="{{ $videocall_id }}"><span>Pay &
                                continue</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
