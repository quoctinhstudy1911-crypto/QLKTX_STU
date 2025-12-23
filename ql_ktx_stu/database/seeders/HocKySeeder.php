<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class HocKySeeder extends Seeder
{
    public function run(): void
    {
        $start = Carbon::create(2025, 9, 1)->toDateString();
        $end = Carbon::create(2026, 1, 15)->toDateString();

        $data = [
            'school_year' => '2025-2026',
            'semester' => 1,
            'start_date' => $start,
            'end_date' => $end,
        ];

        if (Schema::hasColumn('hoc_kys', 'is_active')) {
            $data['is_active'] = 1;
        }

        // avoid duplicate if same school_year+semester exists
        $exists = DB::table('hoc_kys')
            ->where('school_year', $data['school_year'])
            ->where('semester', $data['semester'])
            ->first();

        if (!$exists) {
            DB::table('hoc_kys')->insert($data);
            echo "Inserted hoc_ky: {$data['school_year']} semester {$data['semester']}\n";
        } else {
            // if exists and is_active column present, ensure it's active
            if (Schema::hasColumn('hoc_kys', 'is_active')) {
                DB::table('hoc_kys')
                    ->where('id', $exists->id)
                    ->update(['is_active' => 1]);
                echo "Updated existing hoc_ky id {$exists->id} to is_active=1\n";
            } else {
                echo "hoc_ky already exists (id: {$exists->id}), no is_active column to update.\n";
            }
        }
    }
}
