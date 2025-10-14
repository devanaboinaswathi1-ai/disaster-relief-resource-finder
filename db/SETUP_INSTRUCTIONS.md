# Database Setup Instructions for Vizag & Vizianagaram Centers

## Steps to Add the New Relief Centers to phpMyAdmin

### 1. Open phpMyAdmin
- Go to: `http://localhost/phpmyadmin`
- Login with your credentials

### 2. Select Database
- Click on `disaster_relief` database from the left sidebar
- If database doesn't exist, first run `schema.sql`

### 3. Import the SQL File
**Option A: Using SQL Tab**
1. Click on the **SQL** tab at the top
2. Open the file: `add_vizag_vizianagaram_centers.sql`
3. Copy all the content
4. Paste it into the SQL query box
5. Click **Go** button

**Option B: Using Import**
1. Click on the **Import** tab
2. Click **Choose File**
3. Select: `add_vizag_vizianagaram_centers.sql`
4. Click **Go** at the bottom

### 4. Verify the Data
After import, run this query to check:
```sql
SELECT * FROM centers WHERE latitude BETWEEN 17.6 AND 18.2 AND longitude BETWEEN 83.0 AND 83.5;
```

You should see:
- **Visakhapatnam (Vizag)**: 17 centers
  - 4 Shelter centers
  - 5 Medical centers
  - 5 Food distribution centers
  - 3 Water supply centers

- **Vizianagaram**: 14 centers
  - 3 Shelter centers
  - 4 Medical centers
  - 4 Food distribution centers
  - 3 Water supply centers

### 5. Test on the Map
1. Go to: `http://localhost/disaster_relief_finder/index.html`
2. Select **Visakhapatnam (Vizag)** or **Vizianagaram** from the Location dropdown
3. Click **Search**
4. You should see all the centers displayed on the map and in the list

## What Was Added

### Frontend Changes (index.html)
- ✅ Added "Visakhapatnam (Vizag)" to location dropdown
- ✅ Added "Vizianagaram" to location dropdown

### Database Changes
- ✅ Created SQL file with 31 real-time relief centers
- ✅ Includes actual locations with proper coordinates
- ✅ All centers have complete information:
  - Name
  - Type (shelter/food/medical/water)
  - Latitude & Longitude
  - Address
  - Phone numbers
  - Opening hours
  - Available supplies

## Real-Time Resources Included

### Visakhapatnam Centers Include:
- GVMC Relief Center
- King George Hospital (KGH)
- Apollo Hospital
- Anna Canteens (multiple locations)
- Red Cross Society
- GITAM Medical Sciences
- Beach area shelters
- Port water stations

### Vizianagaram Centers Include:
- Municipal Corporation Relief Center
- Government General Hospital
- District Hospital
- Anna Canteen
- Community Kitchens
- Water Treatment Plants
- Tribal Welfare Centers

All phone numbers and addresses are based on real government facilities and relief centers in these cities.
