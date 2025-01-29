@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
Privacy Policy
@endsection
@push('styles')
@endpush

@section('content')
<section class="inr-bnr">
    <div class="inr-bnr-img">
        <img src="{{ asset('frontend_assets/images/blog-bg.jpg') }}" alt="" />
        <div class="inr-bnr-text">
            <h1>Delete Your Account</h1>
        </div>
    </div>
</section>
<section class="q-acc">
    <div class="container">
        <div class="head-1 h-b text-center" data-aos="fade-up" data-aos-duration="1000">
            {{-- <h2>Privacy Policy</span></h2>
            <p>We have curated a list of general FAQs covering all your queries.</p> --}}
        </div>
        <div class="q-acc" data-aos="fade-up" data-aos-duration="1000">
            <div class="accordion" id="accordionExample">
                <div class="row justify-content-between">
                    <div class="col-xl-12">
                        <h4>Are you sure you want to proceed with deleting your account?</h4>
                        <h6> Please be aware that this action is irreversible. Once you confirm, your page will be permanently deleted, and all associated data will be lost. There is no way to recover the information or restore the page after deletion.</h6>

                        <h6>If you are certain about this decision, click "Confirm Delete" below. If not, you can choose to cancel and retain your account as it is. Please make this choice wisely, as we cannot undo the deletion process.</h6>
                    </div>
                    <div class="text-center mt-5">
                        <button class="btn btn-yes confirm-delete sub-btn">Confirm Delete</button>
                        <button class="btn btn-yes btn-no not-delete sub-btn">No</button>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.confirm-delete').click(function() {
            swal({
                title: 'Are you sure?',
                text: "You want to delete your account!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location = "{{ route('doctor.delete-account.permission') }}"
                } else if (result.dismiss === 'cancel') {
                    swal(
                        'Cancelled',
                        'Your stay here :)',
                        'error'
                    )
                }
            })
        });
        $('.not-delete').click(function() {
            window.location.href = "{{ route('doctor.dashboard') }}";
        });
    });
</script>
@endpush
