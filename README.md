# PFE — Plateforme de Gestion de Projets de Fin d'Études

A full-stack web application for managing end-of-study projects (PFE), built with a **PHP backend** and a **React frontend**.

---

## 📁 Project Structure

```
PFE/
├── PF-Backend/          # PHP REST API
└── PF-Frontend/         # React + Vite application
```

---

## 🔧 Backend — PF-Backend

A PHP-based REST API with JWT authentication, role-based access control, and email support.

### Stack
- **PHP** (no framework)
- **XAMPP** (local development server)
- **MariaDB** (via PDO)
- **JWT** for authentication
- **PHPMailer** for email sending
- **Firebase** integration
- **Composer** for dependency management

### Directory Structure

```
PF-Backend/
├── api/                        # API entry points (endpoints)
│   ├── forgot-password.php
│   ├── getRecentlyCreatedAccounts.php
│   ├── getStudentProjectData.php
│   ├── getTutorStudents.php
│   ├── login.php
│   ├── logout.php
│   ├── protected-example.php
│   ├── public-stats.php
│   ├── refresh-token.php
│   ├── register.php
│   ├── reset-password.php
│   └── stats.php
├── config/
│   ├── database.php            # Database connection
│   └── jwt.php                 # JWT configuration
├── controllers/
│   ├── AuthController.php
│   ├── coordinatorController.php
│   ├── StatsController.php
│   ├── StudentController.php
│   └── TutorController.php
├── mail/                       # Email templates/helpers
├── middlewares/
│   └── AuthMiddleware.php      # JWT auth middleware
├── models/
│   ├── PasswordReset.php
│   ├── RefreshToken.php
│   └── User.php
├── Services/
│   ├── AuthService.php
│   ├── coordinatorService.php
│   ├── PublicStatsService.php
│   ├── StatsService.php
│   ├── StudentService.php
│   └── TutorService.php
├── vendor/                     # Composer dependencies
├── .env                        # Environment variables
├── cors.php                    # CORS configuration
├── hash.php                    # Password hashing utility
├── autoload.php
└── pf_db.sql                   # Database schema
```

### Prerequisites
- **XAMPP** installed and running (Apache + MariaDB)

### Setup

1. **Clone the repository**  
   Open a terminal in any empty folder and run:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   ```

2. **Start XAMPP**  
   Open the XAMPP Control Panel and start **Apache** and **MySQL (MariaDB)**.

3. **Import the database**  
   - Open **MariaDB** and create a new database named `pf_db`
   - Import the schema by running:
   ```bash
   mysql -u root -p pf_db < pf_db.sql
   ```

4. **Install dependencies**
   ```bash
   composer install
   ```

5. **Configure environment**  
   For security reasons, the `.env` file is not included in this repository.

   Please create a ".env" file and use the following structure:
   ```env
   DB_HOST=localhost
   DB_NAME=pf_db
   DB_USER=root
   DB_PASS=
   JWT_SECRET=your_secret_key
   ```
   «⚠️ The actual ".env" file with real credentials will be sent to the instructor via email.»

6. **Access the API**  
   ```
   http://localhost/PFE/PF-Backend/api/login.php
   ```

---

