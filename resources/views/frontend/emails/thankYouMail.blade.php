@component('mail::message')

<p>Dear {{ $body['appointment']['user']['name'] }},</p>

<p>
I hope this email finds you well. I am writing to express my heartfelt gratitude for booking an appointment with us. We truly appreciate the opportunity to serve you and look forward to providing you with the best experience possible.
</p>
<p>
Your appointment has been scheduled for <b>{{ date('d M,Y',strtotime($body['appointment']['appointment_date'])) }} {{ $body['appointment']['appointment_time'] }} at {{ $body['appointment']['clinic_name'] }} </b>.Service Centers address is {{ $body['appointment']['clinic_address'] }}.  Our dedicated team is committed to ensuring that your needs are met and that you receive the highest level of service during your visit.

</p>
<p>
Should you have any questions or require any further information before your appointment, please don't hesitate to contact us. We are more than happy to assist you in any way we can.

</p>
<p>
Once again, thank you for choosing us. We value your trust and confidence in our services and are eager to make this appointment a positive and rewarding experience for you.

</p>
<p>
We are eagerly awaiting your visit and are confident that you will leave with a smile on your face.

</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
