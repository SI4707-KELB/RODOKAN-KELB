<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\ValidasiLaporan;
use Illuminate\Support\Facades\DB;

class ValidasiLaporanService
{
    public function performAutoValidation(Laporan $laporan): ValidasiLaporan
    {
        $validasi = $laporan->validasi ?? new ValidasiLaporan(['laporan_id' => $laporan->id]);

        $validasi->deskripsi_lengkap = $this->checkDeskripsiLengkap($laporan);
        $validasi->foto_tersedia = $this->checkFotoTersedia($laporan);
        $validasi->lokasi_gps = $this->checkLokasiGPS($laporan);
        $validasi->lokasi_bandung = $this->checkLokasiBandung($laporan);
        $validasi->kategori_sesuai = $this->checkKategoriSesuai($laporan);
        $validasi->tidak_duplikasi = $this->checkTidakDuplikasi($laporan);
        $validasi->foto_relevan = $this->checkFotoRelevan($laporan);
        $validasi->urgensi_sesuai = $this->checkUrgensiSesuai($laporan);

        $validasi->total_passed = $this->calculateTotalPassed($validasi);
        $validasi->total_items = 8;

        return $validasi;
    }

    private function checkDeskripsiLengkap(Laporan $laporan): bool
    {
        if (!$laporan->deskripsi) {
            return false;
        }

        $wordCount = str_word_count($laporan->deskripsi);
        return $wordCount >= 20;
    }

    private function checkFotoTersedia(Laporan $laporan): bool
    {
        return !empty($laporan->foto);
    }

    private function checkLokasiGPS(Laporan $laporan): bool
    {
        return !is_null($laporan->latitude) && !is_null($laporan->longitude) &&
               $laporan->latitude != 0 && $laporan->longitude != 0;
    }

    private function checkLokasiBandung(Laporan $laporan): bool
    {
        if (!$this->checkLokasiGPS($laporan)) {
            return false;
        }

        $lat = (float)$laporan->latitude;
        $lng = (float)$laporan->longitude;

        $minLat = -7.5;
        $maxLat = -6.8;
        $minLng = 107.3;
        $maxLng = 107.9;

        return $lat >= $minLat && $lat <= $maxLat && $lng >= $minLng && $lng <= $maxLng;
    }

    private function checkKategoriSesuai(Laporan $laporan): bool
    {
        return !is_null($laporan->kategori_id) && $laporan->kategori()->exists();
    }

    private function checkTidakDuplikasi(Laporan $laporan): bool
    {
        $duplikat = Laporan::where('id', '!=', $laporan->id)
            ->where('user_id', $laporan->user_id)
            ->where('kategori_id', $laporan->kategori_id)
            ->where('kecamatan', $laporan->kecamatan)
            ->whereBetween('created_at', [
                $laporan->created_at->copy()->subMinutes(30),
                $laporan->created_at->copy()->addMinutes(30)
            ])
            ->exists();

        return !$duplikat;
    }

    private function checkFotoRelevan(Laporan $laporan): bool
    {
        if (!$this->checkFotoTersedia($laporan)) {
            return false;
        }

        $deskripsi = strtolower($laporan->deskripsi ?? '');
        $judul = strtolower($laporan->judul_laporan ?? '');

        $keywords = ['jalan', 'banjir', 'sampah', 'lampu', 'pipa', 'kabel', 'rusak', 'lubang', 'polusi', 'kemacetan'];

        foreach ($keywords as $keyword) {
            if (strpos($deskripsi, $keyword) !== false || strpos($judul, $keyword) !== false) {
                return true;
            }
        }

        return strlen($deskripsi) > 50;
    }

    private function checkUrgensiSesuai(Laporan $laporan): bool
    {
        if (empty($laporan->urgensi)) {
            return false;
        }

        $validUrgensi = ['Rendah', 'Sedang', 'Tinggi'];
        return in_array($laporan->urgensi, $validUrgensi);
    }

    private function calculateTotalPassed(ValidasiLaporan $validasi): int
    {
        $items = [
            'deskripsi_lengkap',
            'foto_tersedia',
            'lokasi_gps',
            'lokasi_bandung',
            'kategori_sesuai',
            'tidak_duplikasi',
            'foto_relevan',
            'urgensi_sesuai',
        ];

        $passed = 0;
        foreach ($items as $item) {
            if ($validasi->$item) {
                $passed++;
            }
        }

        return $passed;
    }

    public function updateValidasiManual(ValidasiLaporan $validasi, array $data): ValidasiLaporan
    {
        $fields = [
            'deskripsi_lengkap',
            'foto_tersedia',
            'lokasi_gps',
            'lokasi_bandung',
            'kategori_sesuai',
            'tidak_duplikasi',
            'foto_relevan',
            'urgensi_sesuai',
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $validasi->$field = (bool)$data[$field];
            }
        }

        $validasi->total_passed = $this->calculateTotalPassed($validasi);
        $validasi->status_validasi = 'completed';
        $validasi->admin_id = auth()->id();

        $validasi->save();

        return $validasi;
    }

    public function getValidationReport(Laporan $laporan): array
    {
        $validasi = $laporan->validasi;

        if (!$validasi) {
            return [
                'status' => 'not_validated',
                'message' => 'Laporan belum divalidasi',
            ];
        }

        $percentage = $validasi->getProgressPercentage();
        $status = $this->determineStatus($percentage, $validasi);

        return [
            'status' => $status,
            'percentage' => $percentage,
            'passed' => $validasi->total_passed,
            'total' => $validasi->total_items,
            'items' => $this->getDetailedItems($validasi),
        ];
    }

    private function determineStatus(int $percentage, ValidasiLaporan $validasi): string
    {
        if ($percentage >= 88) {
            return 'excellent';
        } elseif ($percentage >= 75) {
            return 'good';
        } elseif ($percentage >= 50) {
            return 'fair';
        } else {
            return 'poor';
        }
    }

    private function getDetailedItems(ValidasiLaporan $validasi): array
    {
        $items = $validasi->getValidationItems();
        $result = [];

        foreach ($items as $key => $label) {
            $result[] = [
                'key' => $key,
                'label' => $label,
                'passed' => $validasi->$key,
            ];
        }

        return $result;
    }
}
