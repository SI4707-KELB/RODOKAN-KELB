<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr style="background:#dbeafe;font-weight:bold;">
                <th>ID</th>
                <th>Judul</th>
                <th>Pelapor</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Kecamatan</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Urgensi</th>
                <th>Tanggal Dibuat</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $laporan)
            <tr>
                <td>{{ $laporan->id }}</td>
                <td>{{ $laporan->judul_laporan }}</td>
                <td>{{ $laporan->user->name ?? '-' }}</td>
                <td>{{ $laporan->user->email ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama ?? '-' }}</td>
                <td>{{ $laporan->kecamatan }}</td>
                <td>{{ $laporan->alamat ?? '-' }}</td>
                <td>{{ $laporan->status }}</td>
                <td>{{ $laporan->urgensi }}</td>
                <td>{{ $laporan->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $laporan->catatan_verifikasi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
