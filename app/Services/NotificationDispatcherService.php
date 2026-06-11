<?php

namespace App\Services;

use App\Models\Komentar;
use App\Models\Laporan;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Notifications\Notification;

class NotificationDispatcherService
{
    public function notifyAdminsOnNewLaporan(Laporan $laporan): void
    {
        $isDarurat = $laporan->status === 'Darurat'
            || in_array($laporan->urgensi, ['Tinggi', 'Darurat'], true);

        if ($isDarurat) {
            $this->notifyAllAdmins(new AdminNotification(
                category: 'darurat',
                title: 'Laporan Darurat Baru Masuk',
                message: $laporan->deskripsi
                    ? \Illuminate\Support\Str::limit($laporan->deskripsi, 120)
                    : $laporan->judul_laporan,
                laporan: $laporan,
            ));
        } else {
            $this->notifyAllAdmins(new AdminNotification(
                category: 'verifikasi',
                title: 'Laporan Menunggu Verifikasi',
                message: $laporan->deskripsi
                    ? \Illuminate\Support\Str::limit($laporan->deskripsi, 120)
                    : $laporan->judul_laporan,
                laporan: $laporan,
                url: route('verifikasi.show', $laporan->id),
            ));

            $this->notifyAllAdmins(new AdminNotification(
                category: 'biasa',
                title: 'Laporan Baru dari Warga',
                message: 'Warga melaporkan: '.$laporan->judul_laporan
                    .($laporan->kecamatan ? ', '.$laporan->kecamatan : ''),
                laporan: $laporan,
            ));
        }
    }

    public function notifyAdminsOnKomentar(Komentar $komentar): void
    {
        $komentar->loadMissing(['user', 'laporan']);

        $this->notifyAllAdmins(new AdminNotification(
            category: 'komentar',
            title: 'Komentar Baru dari Warga',
            message: ($komentar->user->name ?? 'Warga')
                .' mengomentari: "'
                .\Illuminate\Support\Str::limit($komentar->isi_komentar, 100)
                .'"',
            laporan: $komentar->laporan,
        ));
    }

    public function notifyAdminsOnInstansiUpdate(Laporan $laporan, string $instansiName, string $statusBaru): void
    {
        $this->notifyAllAdmins(new AdminNotification(
            category: 'instansi',
            title: 'Update dari Instansi',
            message: "{$instansiName} memperbarui status laporan \"{$laporan->judul_laporan}\" menjadi \"{$statusBaru}\"",
            laporan: $laporan,
            extra: [
                'instansi_name' => $instansiName,
                'status_baru' => $statusBaru,
            ],
        ));
    }

    public function notifyAllAdmins(Notification $notification): void
    {
        User::where('role', 'admin')->each(
            fn (User $admin) => $admin->notify($notification)
        );
    }
}
