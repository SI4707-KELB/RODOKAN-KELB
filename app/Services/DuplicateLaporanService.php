<?php

namespace App\Services;

use App\Models\Laporan;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DuplicateLaporanService
{
    public function findSimilar(array $criteria, int $limit = 5): Collection
    {
        $judul = trim($criteria['judul_laporan'] ?? '');
        $deskripsi = trim($criteria['deskripsi'] ?? '');
        $kategoriId = $criteria['kategori_id'] ?? null;
        $alamat = trim($criteria['alamat'] ?? '');
        $latitude = $criteria['latitude'] ?? null;
        $longitude = $criteria['longitude'] ?? null;

        if ($judul === '' && $deskripsi === '' && $alamat === '') {
            return collect();
        }

        $query = Laporan::with('kategori')
            ->whereNotIn('status', ['Ditolak'])
            ->where('created_at', '>=', now()->subDays(30));

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($alamat !== '') {
            $alamatToken = Str::limit($alamat, 40, '');
            $query->where(function ($q) use ($alamat, $alamatToken) {
                $q->where('alamat', 'like', '%'.$alamatToken.'%')
                    ->orWhere('kecamatan', 'like', '%'.$alamatToken.'%');
            });
        }

        $candidates = $query->orderByDesc('created_at')->limit(30)->get();

        return $candidates
            ->map(function (Laporan $laporan) use ($judul, $deskripsi, $latitude, $longitude) {
                $score = $this->calculateSimilarityScore($laporan, $judul, $deskripsi, $latitude, $longitude);

                return [
                    'id' => $laporan->id,
                    'judul_laporan' => $laporan->judul_laporan,
                    'alamat' => $laporan->alamat ?? $laporan->kecamatan,
                    'status' => $laporan->status,
                    'kategori' => $laporan->kategori->nama ?? '-',
                    'created_at' => $laporan->created_at->format('d M Y'),
                    'similarity' => $score,
                    'url' => route('laporan.show', $laporan->id),
                ];
            })
            ->filter(fn (array $item) => $item['similarity'] >= 55)
            ->sortByDesc('similarity')
            ->take($limit)
            ->values();
    }

    private function calculateSimilarityScore(
        Laporan $laporan,
        string $judul,
        string $deskripsi,
        ?float $latitude,
        ?float $longitude,
    ): int {
        $scores = [];

        if ($judul !== '') {
            similar_text(
                Str::lower($judul),
                Str::lower($laporan->judul_laporan ?? ''),
                $titlePercent
            );
            $scores[] = (int) round($titlePercent);
        }

        if ($deskripsi !== '' && $laporan->deskripsi) {
            $inputWords = $this->significantWords($deskripsi);
            $existingWords = $this->significantWords($laporan->deskripsi);
            if (count($inputWords) > 0) {
                $overlap = count(array_intersect($inputWords, $existingWords));
                $scores[] = (int) round(($overlap / count($inputWords)) * 100);
            }
        }

        if ($latitude && $longitude && $laporan->latitude && $laporan->longitude) {
            $distanceKm = $this->haversineKm(
                (float) $latitude,
                (float) $longitude,
                (float) $laporan->latitude,
                (float) $laporan->longitude
            );
            if ($distanceKm <= 0.5) {
                $scores[] = 95;
            } elseif ($distanceKm <= 2) {
                $scores[] = 75;
            } elseif ($distanceKm <= 5) {
                $scores[] = 50;
            }
        }

        return count($scores) > 0 ? (int) max($scores) : 0;
    }

    private function significantWords(string $text): array
    {
        $stopWords = ['yang', 'dan', 'di', 'ke', 'dari', 'pada', 'dengan', 'untuk', 'adalah', 'ini', 'itu', 'saya', 'ada'];

        return collect(preg_split('/\s+/', Str::lower($text)))
            ->map(fn ($w) => preg_replace('/[^a-z0-9]/', '', $w))
            ->filter(fn ($w) => strlen($w) >= 4 && ! in_array($w, $stopWords))
            ->unique()
            ->values()
            ->all();
    }

    private function haversineKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
