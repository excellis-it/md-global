@php
    use App\Models\User;
@endphp
<section class="doc-list">
    <div class="container">
        <div class="doc-list-wrap">
            <div class="doc-list-head">
                <div class="head-1 h-b">
                    @if ($type == 'specialization')
                        <h2>{{ $data['name'] }}</h2>
                    @else
                        <h2>{{ $data['symptom_name'] }}</h2>
                    @endif
                </div>
                <div class="doc-avl d-flex mt-2">
                    <div class="doc-avl-img">
                        <img src="{{ asset('frontend_assets/images/doc-v.png') }}" alt="">
                    </div>
                    <div class="doc-avl-text">
                        @if ($doctors->count() > 0)
                            <h4>{{ $doctors->count() }}Medical Stuff available</h4>
                        @else
                            <h4>NoMedical Stuff available</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if (count($doctors) > 0)
                @foreach ($doctors as $doctor)
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="doc-spl-wrap-box">
                            <div class="doc-spl">
                                <div class="doc-spl-img-box">
                                    @if ($doctor['profile_picture'])
                                        <img src="{{ Storage::url($doctor->profile_picture) }}" alt="">
                                    @else
                                        <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="find-doc-slide-text">
                                    <h3>{{ $doctor->name }}</h3>
                                    <h4>{{ User::getDoctorSpecializations($doctor['id']) }}</h4>
                                    <h5></h5>
                                    <div class="pec-div">
                                        <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                        <span class="exp"><span class="dot-1"></span>
                                            {{ $doctor->year_of_experience }} Years Exp</span>
                                    </div>
                                </div>
                                <div class="bk-btn">
                                    <a href="{{ route('booking-and-consultancy', encrypt($doctor->id)) }}"><span>book an
                                            appointment</span></a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="doc-spl-wrap-box">
                        <div class="doc-spl">
                            <div class="doc-spl-img-box">
                                <img src="{{ asset('frontend_assets/images/no-data-found-removebg-preview.png') }}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>NoMedical Stuff available</h3>
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</section>
