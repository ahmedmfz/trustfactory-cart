<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySalesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $date, public $items) {}

    public function build()
    {
        return $this->subject("Daily Sales Report - {$this->date}")
            ->view('emails.daily-sales-report');

    }
}
