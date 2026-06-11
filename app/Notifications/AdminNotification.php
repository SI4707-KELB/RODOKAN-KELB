<?php

namespace App\Notifications;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $category,
        public string $title,
        public string $message,
        public ?Laporan $laporan = null,
        public ?string $url = null,
        public array $extra = [],
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return array_merge([
            'category' => $this->category,
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url ?? ($this->laporan
                ? route('admin.laporan.show', $this->laporan->id)
                : route('notifications.index')),
            'laporan_id' => $this->laporan?->id,
            'kode_laporan' => $this->laporan ? $this->laporanKode($this->laporan) : null,
            'kecamatan' => $this->laporan?->kecamatan ?? $this->laporan?->alamat,
        ], $this->extra);
    }

    private function laporanKode(Laporan $laporan): string
    {
        return 'RK-'.$laporan->created_at->format('Y').'-'.str_pad((string) $laporan->id, 4, '0', STR_PAD_LEFT);
    }
}
