# Disaster Relief Resource Finder

A web-based application to help people locate disaster relief centers (shelters, food distribution, medical aid, and water supply) during emergencies. Built with PHP, MySQL, and Leaflet.js for interactive mapping.

## Features

### Public Interface
- **Interactive Map**: View relief centers on an interactive Leaflet map
- **Location-based Search**: Search by current location or select from predefined cities
- **Filter by Type**: Filter centers by type (shelter, food, medical, water)
- **Radius Search**: Customize search radius (1-100 km)
- **Detailed Information**: View center details including address, phone, hours, and available supplies
- **Responsive Design**: Works on desktop and mobile devices

### Admin Dashboard
- **Secure Login**: Password-protected admin access
- **CRUD Operations**: Create, Read, Update, and Delete relief centers
- **Real-time Updates**: Changes reflect immediately on the public map
- **Data Management**: Manage all center information from a single dashboard

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Mapping**: Leaflet.js 1.9.4
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB
- **Server**: Apache (XAMPP/WAMP/LAMP)

## Project Structure

```
disaster_relief_finder/
├── admin/
│   ├── dashboard.php       # Admin dashboard with CRUD interface
│   ├── login.php          # Admin login page
│   └── style.css          # Admin-specific styles
├── assets/
│   └── icons/             # Map marker icons
├── css/
│   └── style.css          # Main stylesheet
├── db/
│   ├── schema.sql         # Database schema and seed data
│   ├── add_andhra_centers.sql
│   ├── add_vizag_vizianagaram_centers.sql
│   └── SETUP_INSTRUCTIONS.md
├── js/
│   └── app.js             # Main application logic
├── php/
│   ├── config.php         # Database configuration
│   ├── get_centers.php    # Fetch centers API
│   ├── add_center.php     # Add center API
│   ├── update_center.php  # Update center API
│   ├── delete_center.php  # Delete center API
│   ├── test_db.php        # Database connection test
│   └── test_add.php       # API testing utility
├── index.html             # Main public interface
├── about.html             # About page
├── contact.html           # Contact page
└── README.md              # This file
```

## Installation

### Prerequisites
- XAMPP/WAMP/LAMP stack installed
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser with JavaScript enabled

### Setup Steps

1. **Clone/Copy the project** to your web server directory:
   ```
   c:\xampp\htdocs\disaster_relief_finder\
   ```

2. **Start Apache and MySQL** from XAMPP Control Panel

3. **Create the database**:
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Import `db/schema.sql` to create the database and tables
   - Optionally import additional SQL files for sample data:
     - `db/add_andhra_centers.sql`
     - `db/add_vizag_vizianagaram_centers.sql`

4. **Configure database connection** (if needed):
   - Edit `php/config.php`
   - Update database credentials:
     ```php
     define('DB_HOST', '127.0.0.1');
     define('DB_USER', 'root');
     define('DB_PASS', '');  // Add password if set
     define('DB_NAME', 'disaster_relief');
     ```

5. **Test the setup**:
   - Visit `http://localhost/disaster_relief_finder/php/test_db.php`
   - Should show "Database connection successful"

6. **Access the application**:
   - Public site: `http://localhost/disaster_relief_finder/`
   - Admin dashboard: `http://localhost/disaster_relief_finder/admin/dashboard.php`
   - Default admin credentials: `admin` / `admin123` (configured in `admin/login.php`)

## Usage

### For Public Users

1. **Open the application** in your web browser
2. **Choose a location**:
   - Click "Use My Location" to use GPS
   - OR select a city from the dropdown
3. **Filter results**:
   - Select resource type (shelter, food, medical, water)
   - Adjust search radius
4. **Click "Search"** to find nearby centers
5. **View results**:
   - Click markers on the map for details
   - Browse the list panel on the right

### For Administrators

1. **Login** at `/admin/dashboard.php`
2. **Add a new center**:
   - Click "+ Add New Center"
   - Fill in required fields (name, type, latitude, longitude)
   - Add optional details (address, phone, hours, supplies)
   - Click "Save"
3. **Edit a center**:
   - Click "Edit" button in the table
   - Modify fields
   - Click "Save"
4. **Delete a center**:
   - Click "Delete" button
   - Confirm deletion

## API Endpoints

### GET /php/get_centers.php
Fetch all relief centers
- **Response**: `{ "data": [...] }`

### POST /php/add_center.php
Add a new relief center
- **Body**: JSON with `name`, `type`, `latitude`, `longitude`, optional fields
- **Response**: `{ "success": true, "id": 123 }`

### POST /php/update_center.php
Update an existing center
- **Body**: JSON with `id` and fields to update
- **Response**: `{ "success": true }`

### POST /php/delete_center.php
Delete a center
- **Body**: JSON with `id`
- **Response**: `{ "success": true }`

## Database Schema

### Table: `centers`
| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED | Primary key, auto-increment |
| name | VARCHAR(120) | Center name |
| type | ENUM | 'shelter', 'food', 'medical', 'water' |
| latitude | DECIMAL(10,7) | GPS latitude |
| longitude | DECIMAL(10,7) | GPS longitude |
| address | VARCHAR(255) | Street address (optional) |
| phone | VARCHAR(40) | Contact phone (optional) |
| opening_hours | VARCHAR(120) | Operating hours (optional) |
| supplies | TEXT | Available supplies (optional) |
| updated_at | TIMESTAMP | Last update timestamp |

## Security Considerations

⚠️ **Important**: This is a development version. For production deployment:

1. **Change admin credentials** in `admin/login.php`
2. **Use environment variables** for database credentials
3. **Implement proper session management** with secure cookies
4. **Add CSRF protection** to forms
5. **Use prepared statements** (already implemented)
6. **Enable HTTPS** for secure communication
7. **Implement rate limiting** on API endpoints
8. **Add input validation** and sanitization
9. **Set proper file permissions** on the server
10. **Regular security audits** and updates

## Customization

### Adding New Cities
Edit `index.html` and add options to the location dropdown:
```html
<option value="LAT,LNG">City Name</option>
```

### Changing Map Styles
Modify the Leaflet tile layer in `js/app.js`:
```javascript
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '...'
}).addTo(map);
```

### Adding New Resource Types
1. Update database enum in `db/schema.sql`
2. Add option in `index.html` and `admin/dashboard.php`
3. Update validation in `php/add_center.php`

## Troubleshooting

### Database Connection Failed
- Check if MySQL is running in XAMPP
- Verify credentials in `php/config.php`
- Ensure database `disaster_relief` exists

### Map Not Loading
- Check browser console for JavaScript errors
- Verify Leaflet CDN is accessible
- Check internet connection (for map tiles)

### API Errors
- Check Apache error logs: `xampp/apache/logs/error.log`
- Enable PHP error reporting in `php.ini`
- Test endpoints with `php/test_add.php`

### Admin Login Not Working
- Check session configuration in PHP
- Verify credentials in `admin/login.php`
- Clear browser cookies and cache

## Future Enhancements

- [ ] User registration and authentication
- [ ] Real-time updates using WebSockets
- [ ] Mobile app (React Native/Flutter)
- [ ] SMS/Email notifications
- [ ] Multi-language support
- [ ] Offline mode with service workers
- [ ] Advanced analytics dashboard
- [ ] Integration with emergency services APIs
- [ ] Crowdsourced updates and verification
- [ ] Accessibility improvements (WCAG compliance)

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available for educational and humanitarian purposes.

## Support

For issues, questions, or suggestions:
- Open an issue on the repository
- Contact via the contact page
- Email: [Your contact email]

## Acknowledgments

- **Leaflet.js** for the mapping library
- **OpenStreetMap** for map tiles
- **XAMPP** for the development environment
- All contributors and testers

---

**Built with ❤️ for disaster relief efforts**
