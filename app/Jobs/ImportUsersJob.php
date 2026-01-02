<?php

namespace App\Jobs;

use App\Imports\UsersImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;   // ✅ CORRECT
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ImportUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $filePath) {}


public function handle()
{
    Excel::import(
        new UsersImport,
        $this->filePath,
        'local',                 // disk name
        ExcelExcel::CSV          // auto works for xlsx too
    );
}

}
