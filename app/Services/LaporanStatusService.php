<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\StatusHistory;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Notifications\LaporanStatusUpdated;

class LaporanStatusService
{
    public function __construct(
        protected NotificationDispatcherService $notificationDispatcher,
    ) {}

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

        $fresh = $laporan->fresh(['instansi']);

        $this->notifyOwner($fresh, $statusSebelumnya, $statusBaru, $catatan);
        $this->notifyAdminsIfNeeded($fresh, $statusSebelumnya, $statusBaru);

        return $laporan;
    }

    private function notifyAdminsIfNeeded(Laporan $laporan, string $statusSebelumnya, string $statusBaru): void
    {
        if ($statusBaru === 'Darurat') {
            $this->notificationDispatcher->notifyAllAdmins(
                new AdminNotification(
                    category: 'darurat',
                    title: 'Laporan Ditandai Darurat',
                    message: "Laporan \"{$laporan->judul_laporan}\" memerlukan penanganan segera.",
                    laporan: $laporan,
                )
            );
        }

        if ($statusBaru === 'Ditindaklanjuti' && $laporan->instansi_id) {
            $instansiName = $laporan->instansi?->nama ?? 'Instansi terkait';
            $this->notificationDispatcher->notifyAdminsOnInstansiUpdate($laporan, $instansiName, $statusBaru);
        }
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
