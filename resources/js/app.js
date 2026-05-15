import L from 'leaflet';

const BANDUNG_CENTER = [-6.9175, 107.6191];
const CATEGORY_COLORS = [
    { match: 'bencana', color: '#ef4444' },
    { match: 'infrastruktur', color: '#3b82f6' },
    { match: 'kebersihan', color: '#22c55e' },
    { match: 'keamanan', color: '#eab308' },
    { match: 'energi', color: '#f97316' },
    { match: 'air', color: '#f97316' },
];

const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
}[character]));

const markerColorFor = (report) => {
    const category = String(report.category ?? '').toLowerCase();
    const match = CATEGORY_COLORS.find((item) => category.includes(item.match));

    if (match) {
        return match.color;
    }

    if (String(report.urgency ?? '').toLowerCase() === 'tinggi') {
        return '#ef4444';
    }

    return '#64748b';
};

const popupContentFor = (report) => `
    <div class="laporan-map-popup">
        <div class="laporan-map-popup__title">${escapeHtml(report.title || 'Laporan Warga')}</div>
        <div class="laporan-map-popup__meta">${escapeHtml(report.category || 'Lainnya')} · ${escapeHtml(report.status || 'Status belum tersedia')}</div>
        <div class="laporan-map-popup__meta">${escapeHtml(report.district || 'Kota Bandung')}</div>
    </div>
`;

const parseReports = (element) => {
    try {
        return JSON.parse(element.dataset.reports || '[]');
    } catch {
        return [];
    }
};

const initializeLaporanMap = () => {
    const element = document.getElementById('laporan-map');

    if (!element || element.dataset.leafletReady === 'true') {
        return;
    }

    element.dataset.leafletReady = 'true';

    const map = L.map(element, {
        scrollWheelZoom: false,
        zoomControl: true,
    }).setView(BANDUNG_CENTER, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    const reports = parseReports(element).filter((report) => (
        Number.isFinite(Number(report.lat)) && Number.isFinite(Number(report.lng))
    ));

    const bounds = [];

    reports.forEach((report) => {
        const latLng = [Number(report.lat), Number(report.lng)];
        const color = markerColorFor(report);

        L.circleMarker(latLng, {
            radius: String(report.urgency ?? '').toLowerCase() === 'tinggi' ? 8 : 6,
            color: '#ffffff',
            weight: 2,
            fillColor: color,
            fillOpacity: 0.92,
        })
            .addTo(map)
            .bindPopup(popupContentFor(report));

        bounds.push(latLng);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, {
            padding: [32, 32],
            maxZoom: 14,
        });
    } else {
        L.circleMarker(BANDUNG_CENTER, {
            radius: 7,
            color: '#ffffff',
            weight: 2,
            fillColor: '#3b82f6',
            fillOpacity: 0.9,
        })
            .addTo(map)
            .bindPopup('<div class="laporan-map-popup__title">Kota Bandung</div><div class="laporan-map-popup__meta">Belum ada laporan dengan koordinat.</div>');
    }

    requestAnimationFrame(() => map.invalidateSize());
};

document.addEventListener('DOMContentLoaded', initializeLaporanMap);
