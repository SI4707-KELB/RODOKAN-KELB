<?php

namespace App\Notifications;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LaporanStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public Laporan $laporan,
        public string $statusSebelumnya,
        public string $statusBaru,
        public ?string $catatan = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'laporan_id' => $this->laporan->id,
            'judul_laporan' => $this->laporan->judul_laporan,
            'status_sebelumnya' => $this->statusSebelumnya,
            'status_baru' => $this->statusBaru,
            'catatan' => $this->catatan,
            'message' => "Status laporan \"{$this->laporan->judul_laporan}\" diperbarui dari {$this->statusSebelumnya} menjadi {$this->statusBaru}.",
            'url' => route('laporan.show', $this->laporan->id),
        ];
    }
}
