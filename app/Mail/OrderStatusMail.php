<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $kontrak;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $kontrak = null)
    {
        $this->data = $data;
        $this->kontrak = $kontrak;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if($this->data->status == 'Diterima'){
            $title = 'Pesanan Diterima';
        }elseif($this->data->status == 'Berlangsung'){
            $title = 'Pesanan Diproses';
        }elseif($this->data->status == 'Selesai'){
            $title = 'Pesanan Selesai';
        }elseif($this->data->status == 'Ditolak'){
            $title = 'Pesananan Ditolak';
        }
        return new Envelope(
            subject: $title,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        
        if($this->data->status == 'Diterima'){
            $view = 'email.diterima';
        }elseif($this->data->status == 'Berlangsung'){
            $view = 'email.diproses';
        }elseif($this->data->status == 'Selesai'){
            $view = 'email.selesai';
        }elseif($this->data->status == 'Ditolak'){
            $view = 'email.ditolak';
        }

        return new Content(
            markdown: $view,
            with: ['data' => $this->data],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        if($this->kontrak){
            return [
                Attachment::fromData(fn () => $this->kontrak, 'Surat Kontrak.pdf')
                        ->withMime('application/pdf'),
            ];
        }else{
            return [];
        }
    }
}
