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

## 🎨 Frontend — PF-Frontend

A React SPA built with Vite, featuring role-based dashboards for Students, Tutors, Coordinators, and Jury members.

### Stack
- **React** + **JSX**
- **Vite** (build tool)
- **Axios** (HTTP client)
- **React Router** (routing)

### Directory Structure

```
PF-Frontend/
├── public/
├── src/
│   ├── api/
│   │   └── axios.js                  # Axios instance & interceptors
│   ├── app/
│   │   ├── RedirectByRole.jsx        # Role-based redirect logic
│   │   └── Router.jsx                # App routes
│   ├── assets/                       # Static images
│   ├── Auth/
│   │   ├── AuthContext.jsx
│   │   ├── AuthProvider.jsx
│   │   └── useAuth.js
│   ├── components/
│   │   ├── coordinator/
│   │   │   ├── coordQuickAction.jsx
│   │   │   └── coordRecentlyCreatedAccounts.jsx
│   │   ├── dashboard/
│   │   │   ├── HeaderBar.jsx
│   │   │   ├── SideBar.jsx
│   │   │   └── StatCard.jsx
│   │   ├── student/
│   │   │   ├── ProjectInformation.jsx
│   │   │   └── ProjectProgress.jsx
│   │   ├── tutor/
│   │   ├── InfoPanel.jsx
│   │   └── PrivateRoute.jsx
│   ├── config/
│   │   ├── sidebar.config.js
│   │   └── statCard.config.js
│   ├── Layouts/
│   │   ├── AuthLayout.jsx
│   │   └── DashboardLayout.jsx
│   ├── pages/
│   │   ├── auth/
│   │   │   ├── password reset/
│   │   │   │   ├── ForgotPassword.jsx
│   │   │   │   └── resetPassword.jsx
│   │   │   ├── login.jsx
│   │   │   └── register.jsx
│   │   ├── coordinator/
│   │   │   └── CoordinatorDashboard.jsx
│   │   ├── jury/
│   │   │   └── JuryDashboard.jsx
│   │   ├── Student/
│   │   │   ├── StudentDashboard.jsx
│   │   │   ├── StudentDefense.jsx
│   │   │   ├── StudentDeliverables.jsx
│   │   │   ├── StudentProjects.jsx
│   │   │   ├── StudentReports.jsx
│   │   │   └── StudentSettings.jsx
│   │   └── tutor/
│   │       └── TutorDashboard.jsx
│   ├── services/
│   │   ├── auth.service.js
│   │   ├── coordinator.service.js
│   │   ├── stat.service.js
│   │   ├── student.service.js
│   │   └── tutor.service.js
│   ├── styles/
│   │   ├── Auth.css
│   │   └── DashboardStyle.css
│   ├── App.jsx
│   └── main.jsx
├── index.html
├── vite.config.js
└── package.json
```

### Setup

1. **Install dependencies**
   ```bash
   cd PF-Frontend
   npm install
   ```

2. **Configure API base URL**  
   Edit `src/api/axios.js` and set your backend URL:
   ```js
   baseURL: 'http://localhost/PFE/PF-Backend'
   ```

3. **Start the dev server**
   ```bash
   npm run dev
   ```

4. **Build for production**
   ```bash
   npm run build
   ```

---

## 👥 User Roles

| Role          | Description                                      |
|---------------|--------------------------------------------------|
| **Student**   | View project info, deliverables, reports, defense schedule |
| **Tutor**     | Supervise assigned students                      |
| **Coordinator** | Manage accounts, view stats, oversee all projects |
| **Jury**      | Evaluate student defenses                        |

---

## 🔐 Authentication Flow

1. User logs in via `/api/login.php` → receives **JWT access token** + **refresh token**
2. Protected routes use `AuthMiddleware.php` to validate the JWT
3. Expired tokens are renewed via `/api/refresh-token.php`
4. Password reset is handled via email using PHPMailer

---

## 📄 License

This project was developed as part of an end-of-study project (PFE).
