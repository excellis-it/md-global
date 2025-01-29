<div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1">
    @foreach($speciliaztions as $speciliaztion)
    <div class="col">
        <div class="app-doc-box">
            <a href="{{ route('doctors', ['type'=>'speciaization', 'slug'=>$speciliaztion['slug']]) }}">
                <div class="app-doc-img">
                    <img src="{{ Storage::url($speciliaztion['image']) }}" alt="">
                </div>
            </a>
            <div class="app-doc-text">
                <h3>{{ $speciliaztion['name'] }}</h3>
                <p>{{ $speciliaztion['description'] }}
                </p>
            </div>
            <div class="doc-avl d-flex">
                <div class="doc-avl-img">
                    <img src="{{ asset('frontend_assets/images/doc-v.png') }}" alt="">
                </div>
                @if($speciliaztion['doctor_count'] > 0)
                <div class="doc-avl-text">
                    <h4>{{ $speciliaztion['doctor_count'] }}Medical Stuff available</h4>
                </div>
                @else
                <div class="doc-avl-text">
                    <h4>NoMedical Stuff available</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
