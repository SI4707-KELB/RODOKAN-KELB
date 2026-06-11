import L from 'leaflet';
import 'leaflet.heat';
import 'leaflet.markercluster';

const BANDUNG_AREA_CENTER = [-6.9586, 107.4812];
const BANDUNG_AREA_BOUNDS = [
    [-7.32, 106.85],
    [-6.55, 107.95],
];

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

const parseJsonData = (element, key, fallback = []) => {
    try {
        return JSON.parse(element.dataset[key] || JSON.stringify(fallback));
    } catch {
        return fallback;
    }
};

const createBaseMap = (element, options = {}) => {
    const map = L.map(element, {
        maxBounds: L.latLngBounds(BANDUNG_AREA_BOUNDS).pad(0.4),
        maxBoundsViscosity: 0.7,
        scrollWheelZoom: options.scrollWheelZoom ?? false,
        zoomControl: options.zoomControl ?? true,
        dragging: options.dragging ?? true,
        doubleClickZoom: options.doubleClickZoom ?? true,
        touchZoom: options.touchZoom ?? true,
    }).setView(options.center || BANDUNG_AREA_CENTER, options.zoom || 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    return map;
};

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

const createReportIcon = (color) => L.divIcon({
    className: 'report-marker',
    html: `<span class="report-marker__dot" style="--marker-color: ${color}"></span>`,
    iconSize: [22, 22],
    iconAnchor: [11, 11],
    popupAnchor: [0, -10],
});

const createClusterIcon = (cluster) => {
    const count = cluster.getChildCount();
    const size = count >= 50 ? 'large' : count >= 10 ? 'medium' : 'small';
    const pixels = size === 'large' ? 56 : size === 'medium' ? 46 : 38;

    return L.divIcon({
        className: `report-cluster report-cluster--${size}`,
        html: `<span>${count}</span>`,
        iconSize: [pixels, pixels],
        iconAnchor: [pixels / 2, pixels / 2],
    });
};

const createReportHeatLayer = (reports) => L.heatLayer(reports.map((report) => [
    Number(report.lat),
    Number(report.lng),
    0.45,
]), {
    blur: 26,
    gradient: {
        0.18: '#fde68a',
        0.42: '#fb923c',
        0.68: '#ef4444',
        1: '#991b1b',
    },
    max: 1,
    maxZoom: 16,
    minOpacity: 0.28,
    radius: 36,
});

const popupContentFor = (report) => `
    <div class="laporan-map-popup">
        <div class="laporan-map-popup__title">${escapeHtml(report.title || 'Laporan Warga')}</div>
        <div class="laporan-map-popup__meta">${escapeHtml(report.category || 'Lainnya')} &middot; ${escapeHtml(report.status || 'Status belum tersedia')}</div>
        <div class="laporan-map-popup__meta">${escapeHtml(report.district || 'Kabupaten Bandung Raya')}</div>
    </div>
`;

const validReportsFrom = (element) => parseJsonData(element, 'reports').filter((report) => (
    Number.isFinite(Number(report.lat)) && Number.isFinite(Number(report.lng))
));

const initializeClusterReportMap = () => {
    const element = document.getElementById('laporan-map');

    if (!element || element.dataset.leafletReady === 'true') {
        return;
    }

    element.dataset.leafletReady = 'true';

    const map = createBaseMap(element, {
        center: BANDUNG_AREA_CENTER,
        zoom: 10,
        scrollWheelZoom: false,
    });

    const reports = validReportsFrom(element);
    const heatLayer = reports.length > 0 ? createReportHeatLayer(reports) : null;
    const clusters = L.markerClusterGroup({
        chunkedLoading: true,
        chunkInterval: 120,
        chunkDelay: 40,
        disableClusteringAtZoom: 17,
        iconCreateFunction: createClusterIcon,
        maxClusterRadius: (zoom) => (zoom < 11 ? 74 : 52),
        showCoverageOnHover: false,
        spiderfyOnMaxZoom: true,
        zoomToBoundsOnClick: true,
    });

    reports.forEach((report) => {
        const latLng = [Number(report.lat), Number(report.lng)];
        const marker = L.marker(latLng, {
            icon: createReportIcon(markerColorFor(report)),
            keyboard: true,
            title: report.title || 'Laporan Warga',
        }).bindPopup(popupContentFor(report));

        clusters.addLayer(marker);
    });

    heatLayer?.addTo(map);
    map.addLayer(clusters);

    if (reports.length > 0) {
        map.fitBounds(clusters.getBounds(), {
            padding: [32, 32],
            maxZoom: 14,
        });
    } else {
        L.marker(BANDUNG_AREA_CENTER, {
            icon: createReportIcon('#3b82f6'),
            title: 'Kabupaten Bandung Raya',
        })
            .addTo(map)
            .bindPopup('<div class="laporan-map-popup__title">Kabupaten Bandung Raya</div><div class="laporan-map-popup__meta">Belum ada laporan dengan koordinat.</div>');
    }

    requestAnimationFrame(() => map.invalidateSize());
};

const coordinateText = (latLng) => `${latLng.lat.toFixed(6)}, ${latLng.lng.toFixed(6)}`;

const inputHasNumber = (input) => input?.value.trim() !== '' && Number.isFinite(Number(input.value));

const initializeReportLocationPicker = () => {
    const element = document.getElementById('laporan-location-map');

    if (!element || element.dataset.leafletReady === 'true') {
        return;
    }

    element.dataset.leafletReady = 'true';

    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const coordinateOutput = document.getElementById('selected-coordinate');
    const currentLocationToggle = document.getElementById('use_current_location');

    if (!latitudeInput || !longitudeInput || !coordinateOutput) {
        return;
    }

    const initialLat = Number(latitudeInput.value);
    const initialLng = Number(longitudeInput.value);
    const hasInitialCoordinate = inputHasNumber(latitudeInput) && inputHasNumber(longitudeInput);
    const initialPosition = hasInitialCoordinate ? [initialLat, initialLng] : BANDUNG_AREA_CENTER;
    const map = createBaseMap(element, {
        center: initialPosition,
        zoom: hasInitialCoordinate ? 15 : 11,
        scrollWheelZoom: true,
    });

    let marker = null;
    let geocodeTimer = null;

    const reverseGeocode = (latLng) => {
        const alamatInput = document.getElementById('alamat');
        if (!alamatInput) return;

        clearTimeout(geocodeTimer);
        geocodeTimer = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latLng.lat}&lon=${latLng.lng}&addressdetails=1&accept-language=id`, {
                headers: { 'Accept': 'application/json' }
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data?.display_name) {
                        alamatInput.value = data.display_name;
                    }
                })
                .catch(() => {});
        }, 300);
    };

    const setSelectedLocation = (latLng, zoom = 15) => {
        if (!marker) {
            marker = L.marker(latLng, {
                draggable: true,
                icon: createReportIcon('#2563eb'),
                title: 'Lokasi laporan',
            }).addTo(map);

            marker.on('dragend', () => {
                setSelectedLocation(marker.getLatLng(), map.getZoom());
            });
        } else {
            marker.setLatLng(latLng);
        }

        latitudeInput.value = latLng.lat.toFixed(8);
        longitudeInput.value = latLng.lng.toFixed(8);
        coordinateOutput.textContent = coordinateText(latLng);
        map.setView(latLng, Math.max(map.getZoom(), zoom));
        reverseGeocode(latLng);
    };

    if (hasInitialCoordinate) {
        setSelectedLocation(L.latLng(initialLat, initialLng), 15);
    }

    map.on('click', (event) => {
        setSelectedLocation(event.latlng);
    });

    currentLocationToggle?.addEventListener('change', () => {
        if (!currentLocationToggle.checked || !navigator.geolocation) {
            return;
        }

        navigator.geolocation.getCurrentPosition((position) => {
            setSelectedLocation(L.latLng(position.coords.latitude, position.coords.longitude), 16);
        }, () => {
            currentLocationToggle.checked = false;
        }, {
            enableHighAccuracy: true,
            maximumAge: 30000,
            timeout: 10000,
        });
    });

    requestAnimationFrame(() => map.invalidateSize());
};

const initializeLoginDashboardMap = () => {
    const element = document.getElementById('login-dashboard-map');

    if (!element || element.dataset.leafletReady === 'true') {
        return;
    }

    element.dataset.leafletReady = 'true';

    const map = createBaseMap(element, {
        center: [-6.9175, 107.6191],
        zoom: 11,
        scrollWheelZoom: false,
        zoomControl: false,
        dragging: false,
        doubleClickZoom: false,
        touchZoom: false,
    });

    [
        { title: 'Banjir Gedebage', category: 'Bencana', status: 'Darurat', lat: -6.9574, lng: 107.6986 },
        { title: 'Jalan rusak', category: 'Infrastruktur', status: 'Diproses', lat: -6.9351, lng: 107.6043 },
        { title: 'Sampah menumpuk', category: 'Kebersihan', status: 'Terverifikasi', lat: -6.9039, lng: 107.6186 },
    ].forEach((report) => {
        L.marker([report.lat, report.lng], {
            icon: createReportIcon(markerColorFor(report)),
            title: report.title,
        })
            .addTo(map)
            .bindPopup(popupContentFor(report));
    });

    requestAnimationFrame(() => map.invalidateSize());
};

const initializeScrollSpy = () => {
    const navLinks = document.querySelectorAll('[data-nav]');
    if (navLinks.length === 0) return;

    const header = document.querySelector('nav');
    const headerHeight = header?.offsetHeight || 80;

    const sections = [...navLinks].map((link) => {
        return document.getElementById(link.getAttribute('data-nav'));
    }).filter(Boolean);

    const visibilityMap = new Map();

    const setActiveSection = (activeId) => {
        navLinks.forEach((link) => {
            const isActive = link.getAttribute('data-nav') === activeId;
            link.className = isActive
                ? 'text-blue-600 font-medium'
                : 'text-gray-500 hover:text-gray-900 font-medium transition';
        });
    };

    const updateActiveSection = () => {
        let bestId = null;
        let maxRatio = 0;

        visibilityMap.forEach((ratio, id) => {
            if (ratio > maxRatio) {
                maxRatio = ratio;
                bestId = id;
            }
        });

        if (bestId) {
            setActiveSection(bestId);
        }
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            visibilityMap.set(entry.target.id, entry.intersectionRatio);
        });
        updateActiveSection();
    }, {
        rootMargin: `-${headerHeight + 10}px 0px -40% 0px`,
        threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
    });

    sections.forEach((section) => observer.observe(section));
};

document.addEventListener('DOMContentLoaded', () => {
    initializeLoginDashboardMap();
    initializeClusterReportMap();
    initializeReportLocationPicker();
    initializeScrollSpy();
});
