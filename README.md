🏥 MedicalFlow

MedicalFlow is a lightweight clinic management system built using vanilla PHP with a clean and modular MVC (Model-View-Controller) architecture. Designed for small to mid-sized clinics, it streamlines daily operations like appointment requests, user and schedule management, and patient record tracking.

The system features role-based access: Admins and Doctors can securely log in to manage the clinic via dedicated dashboards, while Patients can request appointments without logging in. MedicalFlow leverages Composer for autoloading and package management, making it maintainable, scalable, and aligned with modern PHP development practices.|

----------------------------------------
✨ Features

- User Authentication (Register / Login / Middleware Protected)
- Admin Dashboard
  - Manage doctors
  - View appointment statistics
- Doctor Dashboard
  - Manage patient records
  - View work schedules & appointments
  - Set working days and hours
  - View patient history
  - Print patient history
- Patient Dashboard
  - Request appointments
- Appointment System with scheduling logic
- SCSS-powered modular styling
- Responsive layout with reusable UI components
- Organized MVC-inspired structure (Controllers, Views, Models)

----------------------------------------
🚀 Getting Started

Requirements:
- PHP 8.x
- MySQL
- XAMPP or PHP's built-in server

Installation:

1. Clone the repository:
   git clone https://github.com/tasevskinaum/MedicalFlow.git
   cd MedicalFlow

2. Start the server:
   If you're not using XAMPP, start the built-in PHP server:
   php -S localhost:8000

3. Import the database:
   Import the SQL file (in /database/medicalflow.sql) into your MySQL server.

4. Configure the database:
   Edit the databases.php file with your DB credentials.

5. Done:
   Visit http://localhost:8000 in your browser.

----------------------------------------
🔐 Test Credentials

**Doctor Account:**
- Email: doctor@doctor.com
- Password: doctor

**Admin Account:**
- Email: admin@admin.com
- Password: admin

----------------------------------------
📸 Screenshots

Add screenshots of:
- Login/Register page
https://imgur.com/HpWa0Rc

- Admin dashboard
https://imgur.com/YDJ9mGw

- Doctor's schedule management view
https://imgur.com/FaAZosK

- Patient appointment request form
https://imgur.com/CG8SgMy
https://imgur.com/P0XOF9X
https://imgur.com/yvDP2cP

----------------------------------------
💡 Future Features

- Email notifications for appointments
----------------------------------------
👨‍💻 Author

Naum Tasevski
Junior PHP Developer | Vanilla PHP Enthusiast
GitHub: https://github.com/tasevskinaum

----------------------------------------
📄 License

This project is open-source and available under the MIT License.
