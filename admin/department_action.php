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

    header(
        "Location: ../auth/login.php?error=Access denied"
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| Request validation
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: departments.php");

    exit;

}


$action =
    $_POST["action"] ?? "";


/*
|--------------------------------------------------------------------------
| ADD DEPARTMENT
|--------------------------------------------------------------------------
*/

if ($action === "add") {


    $name =
        trim(
            $_POST["name"] ?? ""
        );


    $description =
        trim(
            $_POST["description"] ?? ""
        );


    if ($name === "") {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Department name is required."
            )
        );

        exit;

    }


    /*
     * Check duplicate
     */

    $check =
        $conn->prepare(
            "SELECT id
             FROM departments
             WHERE LOWER(name) = LOWER(?)
             LIMIT 1"
        );


    $check->bind_param(
        "s",
        $name
    );


    $check->execute();


    $result =
        $check->get_result();


    if ($result->num_rows > 0) {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "A department with this name already exists."
            )
        );

        exit;

    }


    /*
     * Insert
     */

    $stmt =
        $conn->prepare(
            "INSERT INTO departments
             (name, description)
             VALUES (?, ?)"
        );


    $stmt->bind_param(
        "ss",
        $name,
        $description
    );


    if ($stmt->execute()) {

        header(
            "Location: departments.php?type=success&message="
            . urlencode(
                "Department created successfully."
            )
        );

    } else {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Unable to create the department."
            )
        );

    }


    exit;

}


/*
|--------------------------------------------------------------------------
| EDIT DEPARTMENT
|--------------------------------------------------------------------------
*/

if ($action === "edit") {


    $department_id =
        (int)
        ($_POST["department_id"] ?? 0);


    $name =
        trim(
            $_POST["name"] ?? ""
        );


    $description =
        trim(
            $_POST["description"] ?? ""
        );


    if (
        $department_id <= 0 ||
        $name === ""
    ) {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Invalid department information."
            )
        );

        exit;

    }


    /*
     * Check duplicate excluding current department
     */

    $check =
        $conn->prepare(
            "SELECT id
             FROM departments
             WHERE LOWER(name) = LOWER(?)
             AND id != ?
             LIMIT 1"
        );


    $check->bind_param(
        "si",
        $name,
        $department_id
    );


    $check->execute();


    $result =
        $check->get_result();


    if ($result->num_rows > 0) {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Another department already uses this name."
            )
        );

        exit;

    }


    /*
     * Update
     */

    $stmt =
        $conn->prepare(
            "UPDATE departments
             SET name = ?,
                 description = ?
             WHERE id = ?"
        );


    $stmt->bind_param(
        "ssi",
        $name,
        $description,
        $department_id
    );


    if ($stmt->execute()) {

        header(
            "Location: departments.php?type=success&message="
            . urlencode(
                "Department updated successfully."
            )
        );

    } else {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Unable to update the department."
            )
        );

    }


    exit;

}


/*
|--------------------------------------------------------------------------
| DELETE DEPARTMENT
|--------------------------------------------------------------------------
*/

if ($action === "delete") {


    $department_id =
        (int)
        ($_POST["department_id"] ?? 0);


    if ($department_id <= 0) {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Invalid department."
            )
        );

        exit;

    }


    /*
     * Check whether doctors are assigned
     */

    $check =
        $conn->prepare(
            "SELECT COUNT(*) AS total
             FROM doctors
             WHERE department_id = ?"
        );


    $check->bind_param(
        "i",
        $department_id
    );


    $check->execute();


    $result =
        $check->get_result();


    $row =
        $result->fetch_assoc();


    $doctor_count =
        (int)
        $row["total"];


    if ($doctor_count > 0) {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "This department cannot be deleted because doctors are assigned to it."
            )
        );

        exit;

    }


    /*
     * Delete
     */

    $stmt =
        $conn->prepare(
            "DELETE FROM departments
             WHERE id = ?"
        );


    $stmt->bind_param(
        "i",
        $department_id
    );


    if ($stmt->execute()) {

        header(
            "Location: departments.php?type=success&message="
            . urlencode(
                "Department deleted successfully."
            )
        );

    } else {

        header(
            "Location: departments.php?type=error&message="
            . urlencode(
                "Unable to delete the department."
            )
        );

    }


    exit;

}


/*
|--------------------------------------------------------------------------
| Invalid action
|--------------------------------------------------------------------------
*/

header(
    "Location: departments.php?type=error&message="
    . urlencode(
        "Invalid department action."
    )
);

exit;

?>