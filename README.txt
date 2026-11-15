DRY SEASON FEED & SILAGE PLANNER
================================

Requirements:
- XAMPP (Apache + MySQL)
- PHP 8+
- A browser
- VS Code (optional)

INSTALLATION
1. Extract dry_season_feed_planner.zip.
2. Copy the folder `dry_season_feed_planner` into:
   C:\xampp\htdocs\
3. Open XAMPP Control Panel and start Apache and MySQL.
4. Open http://localhost/phpmyadmin
5. Click Import and import database.sql, OR open the SQL tab and run its contents.
6. Open app/config.php and confirm the database settings:
   host = localhost
   database = dry_season_planner
   username = root
   password = empty by default in many XAMPP installations
7. Visit:
   http://localhost/dry_season_feed_planner/

IMPORTANT
- Change the default database credentials if your MySQL setup differs.
- This is a starter/MVP. The calculations are transparent estimates, not a trained AI model.
- Feed quantities vary by animal weight, milk production, forage quality and the rest of the ration.
  Have a livestock extension officer or nutritionist validate farm feeding decisions.
- Before public deployment, add authentication, authorization, CSRF protection, backups,
  input validation appropriate to your deployment, HTTPS and security review.
