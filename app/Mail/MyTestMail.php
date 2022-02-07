<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pegawai;
    public $gaji;
    public $potongan;
    public $in;
    public $out;
    public $setting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pegawai, $gaji, $potongan, $in, $out, $setting)
    {
        //
        $this->pegawai = $pegawai;
        $this->gaji = $gaji;
        $this->potongan = $potongan;
        $this->in = $in;
        $this->out = $out;
        $this->setting = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Yeay Selamat Gaji Anda Sudah Masuk GOCAY Project')
                    ->view('gocay.emails.MyTestMail');
    }
}
