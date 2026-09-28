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


/*
|--------------------------------------------------------------------------
| Fetch Departments
|--------------------------------------------------------------------------
*/

$departments = [];

$sql = "
    SELECT
        d.id,
        d.name,
        d.description,
        d.created_at,
        COUNT(doc.id) AS doctor_count
    FROM departments d
    LEFT JOIN doctors doc
        ON d.id = doc.department_id
    GROUP BY
        d.id,
        d.name,
        d.description,
        d.created_at
    ORDER BY d.name ASC
";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $departments[] = $row;

    }

}


/*
|--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
*/

$message = $_GET["message"] ?? "";

$message_type = $_GET["type"] ?? "";

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
        AlphaMed | Departments
    </title>


    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >

    <link
        rel="stylesheet"
        href="../assets/css/departments.css"
    >


    <script
        src="../assets/js/departments.js"
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


    <nav class="sidebar-nav">


        <div class="nav-section-title">
            OVERVIEW
        </div>


        <a
            href="dashboard.php"
            class="nav-link"
        >

            <span class="nav-icon dashboard-icon">
                <span></span>
            </span>

            Dashboard

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

            Doctors

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon nurse-icon">
                <span></span>
            </span>

            Nurses

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon patient-icon">
                <span></span>
            </span>

            Patients

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon staff-icon">
                <span></span>
            </span>

            Staff

        </a>


        <a
            href="departments.php"
            class="nav-link active"
        >

            <span class="nav-icon department-icon">
                <span></span>
                <span></span>
            </span>

            Departments

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon calendar-icon">
                <span></span>
            </span>

            Appointments

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

            Medical Records

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon lab-icon">
                <span></span>
            </span>

            Laboratory

        </a>


        <a
            href="#"
            class="nav-link"
        >

            <span class="nav-icon billing-icon">
                <span></span>
            </span>

            Billing

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

            AI Assistant

            <span class="ai-nav-dot"></span>

        </a>

    </nav>


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

            Sign Out

        </a>

    </div>

</aside>


<!-- =====================================================
     MAIN
====================================================== -->

<main class="main">


    <!-- =================================================
         HEADER
    ================================================== -->

    <header class="top-header">

        <div class="header-left">

            <div>

                <div class="breadcrumb">

                    <span>AlphaMed</span>

                    <span class="breadcrumb-separator">
                        /
                    </span>

                    <span>Administration</span>

                    <span class="breadcrumb-separator">
                        /
                    </span>

                    <span>Departments</span>

                </div>


                <h2>
                    Department Management
                </h2>


                <p>
                    Organize and manage hospital departments.
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
                        substr(
                            $_SESSION["full_name"],
                            0,
                            1
                        )
                    );

                    ?>

                </div>


                <div class="profile-info">

                    <strong>
                        <?php

                        echo htmlspecialchars(
                            $_SESSION["full_name"]
                        );

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
         PAGE HEADER
    ================================================== -->

    <section class="page-introduction animate-entry">

        <div>

            <span class="section-eyebrow">
                HOSPITAL ORGANIZATION
            </span>

            <h1>
                Departments
            </h1>

            <p>
                Manage the clinical and administrative
                departments within AlphaMed.
            </p>

        </div>


        <button
            class="primary-button"
            id="openDepartmentModal"
            type="button"
        >

            <span class="button-plus">
                +
            </span>

            Add Department

        </button>

    </section>


    <!-- =================================================
         NOTIFICATION
    ================================================== -->

    <?php if (!empty($message)): ?>

        <div
            class="notification
            <?php echo htmlspecialchars($message_type); ?>"
            id="notification"
        >

            <div class="notification-icon">

                <?php

                echo $message_type === "success"
                    ? "✓"
                    : "!";

                ?>

            </div>


            <div>

                <strong>

                    <?php

                    echo $message_type === "success"
                        ? "Completed"
                        : "Action required";

                    ?>

                </strong>


                <p>

                    <?php

                    echo htmlspecialchars($message);

                    ?>

                </p>

            </div>


            <button
                type="button"
                class="notification-close"
                onclick="closeNotification()"
            >
                ×
            </button>

        </div>

    <?php endif; ?>


    <!-- =================================================
         DEPARTMENT SUMMARY
    ================================================== -->

    <section class="department-summary">

        <div class="summary-card">

            <div class="summary-icon">
                D
            </div>

            <div>

                <span>
                    TOTAL DEPARTMENTS
                </span>

                <strong>
                    <?php echo count($departments); ?>
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon doctors">
                M
            </div>

            <div>

                <span>
                    ASSIGNED DOCTORS
                </span>

                <strong>

                    <?php

                    $total_doctors = 0;

                    foreach ($departments as $department) {

                        $total_doctors +=
                            (int) $department["doctor_count"];

                    }

                    echo $total_doctors;

                    ?>

                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon status">
                A
            </div>

            <div>

                <span>
                    SYSTEM STATUS
                </span>

                <strong>
                    Active
                </strong>

            </div>

        </div>

    </section>


    <!-- =================================================
         DEPARTMENT LIST
    ================================================== -->

    <section class="department-section">


        <div class="section-toolbar">

            <div>

                <span class="section-eyebrow">
                    DEPARTMENT DIRECTORY
                </span>

                <h2>
                    Hospital departments
                </h2>

            </div>


            <div class="search-wrapper">

                <span class="search-icon"></span>

                <input
                    type="text"
                    id="departmentSearch"
                    placeholder="Search departments..."
                    autocomplete="off"
                >

            </div>

        </div>


        <?php if (count($departments) > 0): ?>


            <div
                class="department-grid"
                id="departmentGrid"
            >


                <?php foreach ($departments as $index => $department): ?>


                    <article
                        class="department-card animate-entry"
                        data-name="<?php
                        echo strtolower(
                            htmlspecialchars(
                                $department["name"]
                            )
                        );
                        ?>"
                    >


                        <div class="department-card-header">

                            <div class="department-symbol">

                                <?php

                                echo strtoupper(
                                    substr(
                                        $department["name"],
                                        0,
                                        1
                                    )
                                );

                                ?>

                            </div>


                            <div class="department-actions">

                                <button
                                    type="button"
                                    class="icon-button edit-button"
                                    title="Edit department"

                                    data-id="<?php
                                    echo $department["id"];
                                    ?>"

                                    data-name="<?php
                                    echo htmlspecialchars(
                                        $department["name"],
                                        ENT_QUOTES
                                    );
                                    ?>"

                                    data-description="<?php
                                    echo htmlspecialchars(
                                        $department["description"] ?? "",
                                        ENT_QUOTES
                                    );
                                    ?>"
                                >

                                    Edit

                                </button>


                                <button
                                    type="button"
                                    class="icon-button delete-button"
                                    title="Delete department"

                                    data-id="<?php
                                    echo $department["id"];
                                    ?>"

                                    data-name="<?php
                                    echo htmlspecialchars(
                                        $department["name"],
                                        ENT_QUOTES
                                    );
                                    ?>"
                                >

                                    Delete

                                </button>

                            </div>

                        </div>


                        <div class="department-card-body">

                            <h3>

                                <?php

                                echo htmlspecialchars(
                                    $department["name"]
                                );

                                ?>

                            </h3>


                            <p>

                                <?php

                                if (
                                    !empty(
                                        $department["description"]
                                    )
                                ) {

                                    echo htmlspecialchars(
                                        $department["description"]
                                    );

                                } else {

                                    echo "No department description has been added yet.";

                                }

                                ?>

                            </p>

                        </div>


                        <div class="department-card-footer">

                            <div class="doctor-count">

                                <span class="mini-person"></span>

                                <strong>

                                    <?php

                                    echo
                                        (int)
                                        $department["doctor_count"];

                                    ?>

                                </strong>

                                <span>
                                    doctors
                                </span>

                            </div>


                            <div class="department-status">

                                Active

                            </div>

                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


            <div
                class="empty-search"
                id="emptySearch"
            >

                <div class="empty-search-icon">
                    Search
                </div>

                <h3>
                    No departments found
                </h3>

                <p>
                    Try a different department name.
                </p>

            </div>


        <?php else: ?>


            <div class="empty-state">

                <div class="empty-state-symbol">
                    D
                </div>

                <h3>
                    No departments yet
                </h3>

                <p>
                    Create your first hospital department
                    to begin organizing AlphaMed.
                </p>

                <button
                    type="button"
                    class="primary-button"
                    onclick="openDepartmentModal()"
                >
                    Add First Department
                </button>

            </div>


        <?php endif; ?>


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


<!-- =====================================================
     DEPARTMENT MODAL
====================================================== -->

<div
    class="modal-overlay"
    id="departmentModal"
>


    <div
        class="department-modal"
        role="dialog"
        aria-modal="true"
    >


        <div class="modal-header">

            <div>

                <span class="section-eyebrow">
                    HOSPITAL CONFIGURATION
                </span>

                <h2 id="modalTitle">
                    Add Department
                </h2>

            </div>


            <button
                type="button"
                class="modal-close"
                id="closeDepartmentModal"
            >
                ×
            </button>

        </div>


        <form
            action="department_action.php"
            method="POST"
            id="departmentForm"
        >


            <input
                type="hidden"
                name="action"
                id="formAction"
                value="add"
            >


            <input
                type="hidden"
                name="department_id"
                id="departmentId"
                value=""
            >


            <div class="form-field">

                <label for="departmentName">
                    Department Name
                </label>

                <input
                    type="text"
                    id="departmentName"
                    name="name"
                    placeholder="e.g. Cardiology"
                    maxlength="100"
                    required
                >

                <small>
                    Enter the official hospital department name.
                </small>

            </div>


            <div class="form-field">

                <label for="departmentDescription">
                    Description
                </label>

                <textarea
                    id="departmentDescription"
                    name="description"
                    rows="5"
                    maxlength="500"
                    placeholder="Describe the department and its primary services..."
                ></textarea>

                <small>
                    Optional. Maximum 500 characters.
                </small>

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="secondary-button"
                    id="cancelDepartment"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="primary-button"
                >

                    <span id="submitText">
                        Create Department
                    </span>

                </button>

            </div>


        </form>

    </div>

</div>


<!-- =====================================================
     DELETE CONFIRMATION MODAL
====================================================== -->

<div
    class="modal-overlay"
    id="deleteModal"
>


    <div class="delete-modal">


        <div class="delete-symbol">
            !
        </div>


        <h2>
            Delete department?
        </h2>


        <p>

            You are about to delete

            <strong id="deleteDepartmentName">
            </strong>.

            This action cannot be undone.

        </p>


        <form
            action="department_action.php"
            method="POST"
        >

            <input
                type="hidden"
                name="action"
                value="delete"
            >


            <input
                type="hidden"
                name="department_id"
                id="deleteDepartmentId"
            >


            <div class="modal-actions">

                <button
                    type="button"
                    class="secondary-button"
                    id="cancelDelete"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="danger-button"
                >
                    Delete Department
                </button>

            </div>

        </form>

    </div>

</div>


</body>

</html>