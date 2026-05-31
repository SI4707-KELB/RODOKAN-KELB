<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evidence;

class EvidenceSeeder extends Seeder
{
    public function run()
    {
        // Create sample evidences for first few reports (if exist)
        $reports = \App\Models\Laporan::take(5)->get();
        $users = \App\Models\User::take(5)->get();

        foreach ($reports as $i => $report) {
            $user = $users->get($i % $users->count());
            Evidence::create([
                'report_id' => $report->id,
                'user_id' => $user?->id,
                'evidence_type' => 'photo',
                'file_path' => 'evidences/sample.jpg',
                'description' => 'Contoh bukti tambahan untuk laporan.',
            ]);
        }
    }
}
