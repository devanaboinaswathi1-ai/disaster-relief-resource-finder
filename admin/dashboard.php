<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Disaster Relief</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="admin-header">
        <h1>Relief Centers Admin</h1>
        <nav>
            <a href="../index.html" target="_blank">View Public Site</a>
            <a href="?logout=1">Logout</a>
        </nav>
    </header>

    <main class="admin-main">
        <section class="controls">
            <button id="addBtn" class="btn-primary">+ Add New Center</button>
            <button id="refreshBtn">Refresh</button>
        </section>

        <section id="formSection" class="form-section" style="display:none;">
            <h2 id="formTitle">Add Center</h2>
            <form id="centerForm">
                <input type="hidden" id="centerId">
                <div class="form-grid">
                    <label>
                        Name *
                        <input type="text" id="name" required>
                    </label>
                    <label>
                        Type *
                        <select id="type" required>
                            <option value="shelter">Shelter</option>
                            <option value="food">Food</option>
                            <option value="medical">Medical</option>
                            <option value="water">Water</option>
                        </select>
                    </label>
                    <label>
                        Latitude *
                        <input type="number" step="0.0000001" id="latitude" required>
                    </label>
                    <label>
                        Longitude *
                        <input type="number" step="0.0000001" id="longitude" required>
                    </label>
                    <label>
                        Address
                        <input type="text" id="address">
                    </label>
                    <label>
                        Phone
                        <input type="text" id="phone">
                    </label>
                    <label>
                        Opening Hours
                        <input type="text" id="opening_hours" placeholder="e.g., 24/7 or 09:00-18:00">
                    </label>
                    <label>
                        Supplies
                        <textarea id="supplies" rows="2"></textarea>
                    </label>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save</button>
                    <button type="button" id="cancelBtn" class="btn-secondary">Cancel</button>
                </div>
            </form>
        </section>

        <section class="table-section">
            <h2>All Centers</h2>
            <div id="status" class="status"></div>
            <table id="centersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="centersBody">
                    <tr><td colspan="7">Loading...</td></tr>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        const API_BASE = '../php';
        let editingId = null;

        function setStatus(msg, type = 'info') {
            const el = document.getElementById('status');
            el.textContent = msg;
            el.className = `status ${type}`;
            setTimeout(() => el.textContent = '', 3000);
        }

        async function loadCenters() {
            try {
                const res = await fetch(`${API_BASE}/get_centers.php`);
                const json = await res.json();
                const centers = json.data || [];
                renderTable(centers);
            } catch (e) {
                setStatus('Error loading centers', 'error');
            }
        }

        function renderTable(centers) {
            const tbody = document.getElementById('centersBody');
            if (centers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7">No centers found</td></tr>';
                return;
            }
            tbody.innerHTML = centers.map(c => `
                <tr>
                    <td>${c.id}</td>
                    <td>${c.name}</td>
                    <td>${c.type}</td>
                    <td>${c.latitude}, ${c.longitude}</td>
                    <td>${c.phone || '-'}</td>
                    <td>${c.opening_hours || '-'}</td>
                    <td>
                        <button class="btn-edit" onclick="editCenter(${c.id})">Edit</button>
                        <button class="btn-delete" onclick="deleteCenter(${c.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        function showForm(isEdit = false) {
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('formTitle').textContent = isEdit ? 'Edit Center' : 'Add Center';
        }

        function hideForm() {
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('centerForm').reset();
            document.getElementById('centerId').value = '';
            editingId = null;
        }

        async function editCenter(id) {
            try {
                const res = await fetch(`${API_BASE}/get_centers.php`);
                const json = await res.json();
                const center = json.data.find(c => c.id == id);
                if (!center) return;

                editingId = id;
                document.getElementById('centerId').value = id;
                document.getElementById('name').value = center.name;
                document.getElementById('type').value = center.type;
                document.getElementById('latitude').value = center.latitude;
                document.getElementById('longitude').value = center.longitude;
                document.getElementById('address').value = center.address || '';
                document.getElementById('phone').value = center.phone || '';
                document.getElementById('opening_hours').value = center.opening_hours || '';
                document.getElementById('supplies').value = center.supplies || '';
                showForm(true);
            } catch (e) {
                setStatus('Error loading center', 'error');
            }
        }

        async function deleteCenter(id) {
            if (!confirm('Delete this center?')) return;
            try {
                const res = await fetch(`${API_BASE}/delete_center.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                });
                const json = await res.json();
                if (json.success) {
                    setStatus('Center deleted', 'success');
                    loadCenters();
                } else {
                    setStatus(json.error || 'Delete failed', 'error');
                }
            } catch (e) {
                setStatus('Error deleting center', 'error');
            }
        }

        document.getElementById('centerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = {
                name: document.getElementById('name').value,
                type: document.getElementById('type').value,
                latitude: parseFloat(document.getElementById('latitude').value),
                longitude: parseFloat(document.getElementById('longitude').value),
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                opening_hours: document.getElementById('opening_hours').value,
                supplies: document.getElementById('supplies').value
            };

            const isEdit = !!editingId;
            if (isEdit) data.id = editingId;

            try {
                const endpoint = isEdit ? 'update_center.php' : 'add_center.php';
                const url = `${API_BASE}/${endpoint}`;
                console.log('Posting to:', url);
                console.log('Data:', data);
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                console.log('Response status:', res.status);
                const text = await res.text();
                console.log('Response text:', text);
                const json = JSON.parse(text);
                if (json.success) {
                    setStatus(json.message, 'success');
                    hideForm();
                    loadCenters();
                } else {
                    setStatus(json.error || 'Save failed', 'error');
                    console.error('API Error:', json);
                }
            } catch (e) {
                setStatus('Error saving center: ' + e.message, 'error');
                console.error('Save error:', e);
            }
        });

        document.getElementById('addBtn').addEventListener('click', () => showForm(false));
        document.getElementById('cancelBtn').addEventListener('click', hideForm);
        document.getElementById('refreshBtn').addEventListener('click', loadCenters);

        loadCenters();
    </script>
</body>
</html>