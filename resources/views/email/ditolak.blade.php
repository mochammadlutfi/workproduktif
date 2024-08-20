@component('mail::message')


<h3>
    Hello {{ $data->user->nama }}
</h3>
<p>
    Terima kasih telah melakukan pemesanan di Cv. Workproduktif Aapmin.<br/>
    Mohon maaf pesanan kamu tidak dapat dilanjut untuk saat ini.<br/>
<br/><br/>
Salam,<br/>
Persona Public Speaking<br/>

</p>
@endcomponent