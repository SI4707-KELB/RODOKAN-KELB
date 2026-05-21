<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Laporan RODOKAN</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; }
        h1 { font-size: 16px; margin-bottom: 4px; }
        p.meta { font-size: 9px; color: #64748b; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 4px; text-align: left; }
        th { background: #eff6ff; font-weight: bold; }
        tr:nth-child(even) { background: #f8fafc; }
    </style>
</head>
<body>
    <h1>Data Laporan RODOKAN</h1>
    <p class="meta">Diekspor pada: {{ $generatedAt }} | Total: {{ $laporans->count() }} laporan</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Kecamatan</th>
                <th>Status</th>
                <th>Urgensi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $laporan)
            <tr>
                <td>{{ $laporan->id }}</td>
                <td>{{ $laporan->judul_laporan }}</td>
                <td>{{ $laporan->user->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama ?? '-' }}</td>
                <td>{{ $laporan->kecamatan }}</td>
                <td>{{ $laporan->status }}</td>
                <td>{{ $laporan->urgensi }}</td>
                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
