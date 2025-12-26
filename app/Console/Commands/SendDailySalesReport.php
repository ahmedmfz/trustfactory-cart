<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReportMail;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport extends Command
{
    protected $signature = 'sales:daily-report {--date=}';
    protected $description = 'Send daily sales report to admin email';

    public function handle(): int
    {
        $date = $this->option('date')
            ? now()->parse($this->option('date'))->toDateString()
            : now()->toDateString();

        $items = OrderItem::query()
            ->select('product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(line_total_cents) as total_cents')
            )
            ->whereHas('order', function ($q) use ($date) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->with('product:id,name')
            ->orderByDesc('total_qty')
            ->get();

        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');

        Mail::to($adminEmail)->send(new DailySalesReportMail($date, $items));

        $this->info("Daily sales report sent for {$date} to {$adminEmail}");

        return self::SUCCESS;
    }
}
