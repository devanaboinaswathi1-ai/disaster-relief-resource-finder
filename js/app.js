/* Frontend logic for Disaster Relief Resource Finder */

const state = {
  map: null,
  markers: [],
  userMarker: null,
  centerLat: 17.3850, // fallback
  centerLng: 78.4867,
};

function initMap() {
  state.map = L.map('map').setView([state.centerLat, state.centerLng], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors',
  }).addTo(state.map);
}

function setStatus(msg, type = 'info') {
  const el = document.getElementById('status');
  el.textContent = msg || '';
  el.className = `status ${type}`;
}

async function fetchCenters(params = {}) {
  const url = new URL('php/get_centers.php', window.location.href);
  Object.entries(params).forEach(([k, v]) => {
    if (v !== undefined && v !== null && v !== '') url.searchParams.set(k, v);
  });
  const res = await fetch(url.toString());
  if (!res.ok) {
    const text = await res.text();
    console.error('Server error:', text);
    throw new Error('Failed to load centers: ' + res.status);
  }
  const json = await res.json();
  if (json.error) {
    console.error('API error:', json);
    throw new Error(json.error + (json.detail ? ': ' + json.detail : ''));
  }
  return json.data || [];
}

function clearMarkers() {
  state.markers.forEach((m) => state.map.removeLayer(m));
  state.markers = [];
}

function renderList(items) {
  const list = document.getElementById('list');
  list.innerHTML = '';
  if (items.length === 0) {
    list.innerHTML = '<p>No centers found.</p>';
    return;
  }
  items.forEach((c) => {
    const div = document.createElement('div');
    div.className = 'card';
    div.innerHTML = `
      <h3>${c.name}</h3>
      <p><strong>Type:</strong> ${c.type}</p>
      ${c.address ? `<p><strong>Address:</strong> ${c.address}</p>` : ''}
      ${c.phone ? `<p><strong>Phone:</strong> ${c.phone}</p>` : ''}
      ${c.opening_hours ? `<p><strong>Hours:</strong> ${c.opening_hours}</p>` : ''}
      ${c.distance_km !== undefined ? `<p><strong>Distance:</strong> ${c.distance_km.toFixed(2)} km</p>` : ''}
    `;
    div.addEventListener('click', () => {
      state.map.setView([c.latitude, c.longitude], 15);
    });
    list.appendChild(div);
  });
}

function renderMarkers(items) {
  clearMarkers();
  items.forEach((c) => {
    const marker = L.marker([c.latitude, c.longitude])
      .addTo(state.map)
      .bindPopup(
        `<b>${c.name}</b><br/>Type: ${c.type}` +
          (c.address ? `<br/>${c.address}` : '') +
          (c.distance_km !== undefined
            ? `<br/>${c.distance_km.toFixed(2)} km away`
            : '')
      );
    state.markers.push(marker);
  });
}

async function doSearch() {
  try {
    setStatus('Loading...', 'info');
    const type = document.getElementById('typeFilter').value;
    const radiusKm = parseFloat(document.getElementById('radiusInput').value || '10');
    const params = { type };
    if (state.centerLat && state.centerLng) {
      params.lat = state.centerLat;
      params.lng = state.centerLng;
      params.radiusKm = radiusKm;
    }
    const centers = await fetchCenters(params);
    renderMarkers(centers);
    renderList(centers);
    setStatus(`${centers.length} center(s) found`, 'success');
  } catch (e) {
    console.error(e);
    setStatus(e.message || 'Error loading centers', 'error');
  }
}

function setUserLocation(lat, lng) {
  state.centerLat = lat;
  state.centerLng = lng;
  if (state.userMarker) state.map.removeLayer(state.userMarker);
  state.userMarker = L.marker([lat, lng], { title: 'You' }).addTo(state.map);
  state.map.setView([lat, lng], 13);
}

async function geolocate() {
  if (!navigator.geolocation) {
    setStatus('Geolocation not supported', 'error');
    return;
  }
  setStatus('Getting your location...', 'info');
  navigator.geolocation.getCurrentPosition(
    (pos) => {
      const { latitude, longitude } = pos.coords;
      setUserLocation(latitude, longitude);
      doSearch();
    },
    () => setStatus('Failed to get location', 'error'),
    { enableHighAccuracy: true, timeout: 10000 }
  );
}

function initUI() {
  document.getElementById('searchBtn').addEventListener('click', doSearch);
  document.getElementById('locateBtn').addEventListener('click', geolocate);
  document.getElementById('locationFilter').addEventListener('change', (e) => {
    const value = e.target.value;
    if (value) {
      const [lat, lng] = value.split(',').map(parseFloat);
      setUserLocation(lat, lng);
      doSearch();
    }
  });
}

window.addEventListener('DOMContentLoaded', () => {
  initMap();
  initUI();
  // initial load near default center
  doSearch();
});

