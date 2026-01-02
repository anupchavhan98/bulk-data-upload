<?php

namespace App\Imports;

use App\Models\UserData;


use Maatwebsite\Excel\Concerns\{
    ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
};

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public function model(array $row)
    {
        return new UserData([
            'name'   => $row['name'],
            'email'  => $row['email'],
            'mobile' => $row['mobile'],
        ]);
    }

    // Process 1000 rows at a time
    public function chunkSize(): int
    {
        return 1000;
    }

    // Insert 1000 rows per query
    public function batchSize(): int
    {
        return 1000;
    }
}



