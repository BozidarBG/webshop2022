<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class OrderCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $pdf;
    public $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $pdf)
    {
        $this->name=$name;
        $this->pdf=$pdf;
        $this->settings=Cache::get('settings');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->settings->email)->subject('Order confirmation')->markdown(
            'mails.order_confirmation',['name'=>$this->name, 'settings'=>$this->settings])
            ->attach(public_path('pdfs/'.$this->pdf));
    }
}
