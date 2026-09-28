<?php

session_start();

require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php?error=Access denied");
    exit;
}

$admin_name = $_SESSION["full_name"];


/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$doctor_count = 0;
$nurse_count = 0;
$patient_count = 0;
$staff_count = 0;
$appointment_count = 0;
$department_count = 0;


/*
|--------------------------------------------------------------------------
| Doctors
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM doctors"
);

if ($result) {
    $row = $result->fetch_assoc();
    $doctor_count = (int) $row["total"];
}


/*
|--------------------------------------------------------------------------
| Nurses
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM nurses"
);

if ($result) {
    $row = $result->fetch_assoc();
    $nurse_count = (int) $row["total"];
}


/*
|--------------------------------------------------------------------------
| Patients
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM patients"
);

if ($result) {
    $row = $result->fetch_assoc();
    $patient_count = (int) $row["total"];
}


/*
|--------------------------------------------------------------------------
| Staff
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM staff"
);

if ($result) {
    $row = $result->fetch_assoc();
    $staff_count = (int) $row["total"];
}


/*
|--------------------------------------------------------------------------
| Appointments
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM appointments"
);

if ($result) {
    $row = $result->fetch_assoc();
    $appointment_count = (int) $row["total"];
}


/*
|--------------------------------------------------------------------------
| Departments
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM departments"
);

if ($result) {
    $row = $result->fetch_assoc();
    $department_count = (int) $row["total"];
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        AlphaMed | Admin Dashboard
    </title>


    <!-- Main Admin Stylesheet -->

    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >


    <!-- Dashboard JavaScript -->

    <script
        src="../assets/js/dashboard.js"
        defer
    ></script>

</head>


<body>


<!-- =====================================================
     MOBILE MENU
====================================================== -->

<button
    class="mobile-menu"
    type="button"
    aria-label="Open navigation"
>

    <span></span>
    <span></span>
    <span></span>

</button>


<div class="sidebar-overlay"></div>


<!-- =====================================================
     SIDEBAR
====================================================== -->

<aside class="sidebar">


    <!-- BRAND -->

    <div class="logo">

        <div class="brand-mark">

            <span class="brand-mark-line"></span>

            <span class="brand-mark-line"></span>

            <span class="brand-mark-line"></span>

        </div>


        <div class="brand-text">

            <h1>AlphaMed</h1>

            <p>
                Hospital Intelligence
            </p>

        </div>

    </div>


    <!-- NAVIGATION -->

    <nav class="sidebar-nav">


        <div class="nav-section-title">
            OVERVIEW
        </div>


        <a
            href="dashboard.php"
            class="nav-link active"
        >

            <span class="nav-icon dashboard-icon">
                <span></span>
            </span>

            <span>
                Dashboard
            </span>

        </a>


        <div class="nav-section-title">
            MANAGEMENT
        </div>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon people-icon">
                <span></span>
                <span></span>
            </span>

            <span>
                Doctors
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon nurse-icon">
                <span></span>
            </span>

            <span>
                Nurses
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon patient-icon">
                <span></span>
            </span>

            <span>
                Patients
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon staff-icon">
                <span></span>
            </span>

            <span>
                Staff
            </span>

        </a>


        <a
            href="departments.php"
            class="nav-link"
        >

            <span class="nav-icon department-icon">
                <span></span>
                <span></span>
            </span>

            <span>
                Departments
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon calendar-icon">
                <span></span>
            </span>

            <span>
                Appointments
            </span>

        </a>


        <div class="nav-section-title">
            HOSPITAL SERVICES
        </div>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon records-icon">
                <span></span>
                <span></span>
            </span>

            <span>
                Medical Records
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon lab-icon">
                <span></span>
            </span>

            <span>
                Laboratory
            </span>

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon billing-icon">
                <span></span>
            </span>

            <span>
                Billing
            </span>

        </a>


        <div class="nav-section-title">
            INTELLIGENCE
        </div>


        <a
            href="#"
            class="nav-link ai-nav-link"
        >

            <span class="nav-icon ai-icon">
                <span></span>
            </span>

            <span>
                AI Assistant
            </span>

            <span class="ai-nav-dot"></span>

        </a>

    </nav>


    <!-- SIDEBAR FOOTER -->

    <div class="sidebar-footer">


        <div class="hospital-status">

            <span class="status-dot"></span>

            <div>

                <strong>
                    System Online
                </strong>

                <small>
                    All services operational
                </small>

            </div>

        </div>


        <a
            href="../auth/logout.php"
            class="logout-link"
        >

            <span class="logout-icon">
                <span></span>
            </span>

            <span>
                Sign Out
            </span>

        </a>

    </div>

</aside>


<!-- =====================================================
     MAIN CONTENT
====================================================== -->

<main class="main">


    <!-- =================================================
         HEADER
    ================================================== -->

    <header class="top-header">


        <div class="header-left">


            <div class="mobile-brand">
                AlphaMed
            </div>


            <div>

                <div class="breadcrumb">

                    <span>
                        AlphaMed
                    </span>

                    <span class="breadcrumb-separator">
                        /
                    </span>

                    <span>
                        Administration
                    </span>

                </div>


                <h2>
                    Admin Dashboard
                </h2>


                <p>

                    Welcome back,
                    <strong>
                        <?php
                        echo htmlspecialchars($admin_name);
                        ?>
                    </strong>

                </p>

            </div>

        </div>


        <div class="header-right">


            <div class="live-time-wrapper">

                <span class="live-time-label">
                    LOCAL TIME
                </span>

                <span
                    class="live-time"
                    id="liveClock"
                >
                    --:--
                </span>

            </div>


            <div class="header-divider"></div>


            <div class="admin-profile">

                <div class="profile-avatar">
                    <?php
                    echo strtoupper(
                        substr($admin_name, 0, 1)
                    );
                    ?>
                </div>

                <div class="profile-info">

                    <strong>
                        <?php
                        echo htmlspecialchars($admin_name);
                        ?>
                    </strong>

                    <span>
                        Administrator
                    </span>

                </div>

            </div>

        </div>

    </header>


    <!-- =================================================
         WELCOME BANNER
    ================================================== -->

    <section class="welcome-banner animate-entry">


        <div class="welcome-content">

            <div class="welcome-label">

                <span class="welcome-line"></span>

                ADMINISTRATION CENTER

            </div>


            <h1>
                Hospital operations,
                <span>intelligently organized.</span>
            </h1>


            <p>
                Manage your hospital's people, services,
                appointments and information from one
                centralized platform.
            </p>

        </div>


        <div class="welcome-decoration">

            <div class="orbit orbit-one"></div>

            <div class="orbit orbit-two"></div>

            <div class="orbit orbit-three"></div>

            <div class="center-orb">

                <div class="orb-inner"></div>

            </div>

        </div>

    </section>


    <!-- =================================================
         STATISTICS
    ================================================== -->

    <section class="stats-section">


        <div class="section-heading animate-entry">

            <div>

                <span class="section-eyebrow">
                    HOSPITAL OVERVIEW
                </span>

                <h2>
                    Current statistics
                </h2>

            </div>

            <span class="updated-label">
                LIVE DATA
            </span>

        </div>


        <div class="stats-grid">


            <!-- DOCTORS -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon blue">

                        <span class="icon-person"></span>

                    </div>

                    <span class="stat-status">
                        Active
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        MEDICAL PROFESSIONALS
                    </span>

                    <h3
                        data-count="<?php
                        echo $doctor_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Registered doctors
                    </p>

                </div>


                <div class="stat-line blue-line"></div>

            </div>


            <!-- NURSES -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon cyan">

                        <span class="icon-person"></span>

                    </div>

                    <span class="stat-status">
                        Active
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        NURSING TEAM
                    </span>

                    <h3
                        data-count="<?php
                        echo $nurse_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Registered nurses
                    </p>

                </div>


                <div class="stat-line cyan-line"></div>

            </div>


            <!-- PATIENTS -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon green">

                        <span class="icon-person"></span>

                    </div>

                    <span class="stat-status">
                        Records
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        PATIENT RECORDS
                    </span>

                    <h3
                        data-count="<?php
                        echo $patient_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Registered patients
                    </p>

                </div>


                <div class="stat-line green-line"></div>

            </div>


            <!-- STAFF -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon purple">

                        <span class="icon-person"></span>

                    </div>

                    <span class="stat-status">
                        Active
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        HOSPITAL STAFF
                    </span>

                    <h3
                        data-count="<?php
                        echo $staff_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Registered staff members
                    </p>

                </div>


                <div class="stat-line purple-line"></div>

            </div>


            <!-- APPOINTMENTS -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon orange">

                        <span class="icon-calendar"></span>

                    </div>

                    <span class="stat-status">
                        Scheduled
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        APPOINTMENTS
                    </span>

                    <h3
                        data-count="<?php
                        echo $appointment_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Total appointments
                    </p>

                </div>


                <div class="stat-line orange-line"></div>

            </div>


            <!-- DEPARTMENTS -->

            <div class="stat-card animate-entry">

                <div class="stat-card-top">

                    <div class="stat-icon teal">

                        <span class="icon-building"></span>

                    </div>

                    <span class="stat-status">
                        Organized
                    </span>

                </div>


                <div class="stat-info">

                    <span class="stat-label">
                        DEPARTMENTS
                    </span>

                    <h3
                        data-count="<?php
                        echo $department_count;
                        ?>"
                    >
                        0
                    </h3>

                    <p>
                        Hospital departments
                    </p>

                </div>


                <div class="stat-line teal-line"></div>

            </div>

        </div>

    </section>


    <!-- =================================================
         QUICK ACTIONS
    ================================================== -->

    <section class="quick-section">


        <div class="section-heading animate-entry">

            <div>

                <span class="section-eyebrow">
                    MANAGEMENT
                </span>

                <h2>
                    Quick actions
                </h2>

            </div>

        </div>


        <div class="quick-actions-grid">


            <a
                href="#"
                class="action-card animate-entry"
            >

                <div class="action-icon">

                    <span class="plus-icon"></span>

                </div>

                <div class="action-content">

                    <h3>
                        Add Doctor
                    </h3>

                    <p>
                        Register a medical professional
                        and assign their department.
                    </p>

                </div>

                <span class="action-arrow">
                    →
                </span>

            </a>


            <a
                href="#"
                class="action-card animate-entry"
            >

                <div class="action-icon">

                    <span class="patient-action-icon"></span>

                </div>

                <div class="action-content">

                    <h3>
                        Register Patient
                    </h3>

                    <p>
                        Create a new patient profile
                        and medical record.
                    </p>

                </div>

                <span class="action-arrow">
                    →
                </span>

            </a>


            <a
                href="#"
                class="action-card animate-entry"
            >

                <div class="action-icon">

                    <span class="calendar-action-icon"></span>

                </div>

                <div class="action-content">

                    <h3>
                        Appointments
                    </h3>

                    <p>
                        Review and manage upcoming
                        hospital appointments.
                    </p>

                </div>

                <span class="action-arrow">
                    →
                </span>

            </a>


            <a
                href="#"
                class="action-card animate-entry"
            >

                <div class="action-icon">

                    <span class="building-action-icon"></span>

                </div>

                <div class="action-content">

                    <h3>
                        Departments
                    </h3>

                    <p>
                        Organize departments and
                        hospital services.
                    </p>

                </div>

                <span class="action-arrow">
                    →
                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         AI INTELLIGENCE PANEL
    ================================================== -->

    <section class="ai-card animate-entry">


        <div class="ai-background">

            <div class="ai-ring ring-one"></div>

            <div class="ai-ring ring-two"></div>

            <div class="ai-ring ring-three"></div>

            <div class="ai-core">

                <span></span>

            </div>

        </div>


        <div class="ai-content">


            <div class="ai-status">

                <span class="ai-status-dot"></span>

                AI SYSTEM ACTIVE

            </div>


            <h2>
                AlphaMed Intelligence
            </h2>


            <p>
                Intelligent tools designed to help
                authorized hospital staff organize
                information, summarize records and
                streamline administrative workflows.
            </p>


            <div class="ai-features">

                <span>
                    Intelligent assistance
                </span>

                <span>
                    Information organization
                </span>

                <span>
                    Workflow support
                </span>

            </div>

        </div>


        <div class="ai-action">

            <button
                class="ai-button"
                type="button"
            >

                Open AI Assistant

                <span>
                    →
                </span>

            </button>

        </div>

    </section>


    <!-- =================================================
         FOOTER
    ================================================== -->

    <footer class="dashboard-footer">

        <div>
            AlphaMed Hospital Intelligence System
        </div>

        <div>
            Administrative Portal
        </div>

    </footer>


</main>

</body>

</html>