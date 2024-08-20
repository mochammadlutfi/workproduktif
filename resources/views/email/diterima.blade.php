@component('mail::message')


<h3>
    Hello {{ $data->user->nama }}
</h3>
<p>
    Terima kasih telah melakukan pemesanan di Cv. Workproduktif Aapmin dengan 
    senang hati bahwa kami telah menerima pesanan anda dan akan segera kami proses.<br/>
    Kami mengirimkan surat kontrak yang harus dilakukan legalisir. Apabila sudah dilakukan 
    legalisir silahkan untuk upload dengan tekan tombol dibawah ini.<br/>

<x-mail::button url="{{ route('order.show', $data->id)}}" color="primary">
Upload Kontrak
</x-mail::button>
<br/>

Sekali lagi terima kasih telah memilih Cv. Workproduktif Aapmin
<br/><br/>
Salam,<br/>
Persona Public Speaking<br/>

</p>
@endcomponent