@component('mail::message')
<p>Hi,</p>
<p>Please use the following One Time Password(OTP) to access the form. {{ $details['otp'] }}. <b>Do not share this OTP with anyone</b>.</p>
@component('mail::button', ['url' => route('otp.verification',['id'=> $details['id']])])
    OTP Verification Page
@endcomponent


<p>The allowed duration of the code is one hour from the time the message was sent.</p>
@endcomponent

