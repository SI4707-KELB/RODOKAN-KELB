<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\StatusHistory;
use App\Models\User;
use App\Notifications\LaporanStatusUpdated;

class LaporanStatusService
{
    public function updateStatus(
        Laporan $laporan,
        string $statusBaru,
        ?int $adminId = null,
        ?string $catatan = null,
        array $extra = [],
    ): Laporan {
        $statusSebelumnya = $laporan->status;

        if ($statusSebelumnya === $statusBaru) {
            return $laporan;
        }

        $laporan->update(array_merge([
            'status' => $statusBaru,
            'admin_id' => $adminId ?? $laporan->admin_id,
        ], $extra));

        StatusHistory::create([
            'laporan_id' => $laporan->id,
            'user_id' => $adminId ?? auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $statusBaru,
            'catatan' => $catatan,
        ]);

        $this->notifyOwner($laporan->fresh(), $statusSebelumnya, $statusBaru, $catatan);

        return $laporan;
    }

    private function notifyOwner(Laporan $laporan, string $statusSebelumnya, string $statusBaru, ?string $catatan): void
    {
        if (! $laporan->user_id) {
            return;
        }

        $owner = User::find($laporan->user_id);

        if (! $owner) {
            return;
        }

        $owner->notify(new LaporanStatusUpdated($laporan, $statusSebelumnya, $statusBaru, $catatan));
    }
}
