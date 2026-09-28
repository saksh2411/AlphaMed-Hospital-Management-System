document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =================================================
           PAGE
        ================================================= */

        document.body.classList.add(
            "page-loaded"
        );


        /* =================================================
           LIVE CLOCK
        ================================================= */

        const clock =
            document.getElementById(
                "liveClock"
            );


        function updateClock() {

            if (!clock) {
                return;
            }


            const now =
                new Date();


            clock.textContent =
                now.toLocaleTimeString(
                    [],
                    {
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit"
                    }
                );

        }


        updateClock();

        setInterval(
            updateClock,
            1000
        );


        /* =================================================
           MOBILE SIDEBAR
        ================================================= */

        const menuButton =
            document.querySelector(
                ".mobile-menu"
            );


        const sidebar =
            document.querySelector(
                ".sidebar"
            );


        const overlay =
            document.querySelector(
                ".sidebar-overlay"
            );


        if (
            menuButton &&
            sidebar &&
            overlay
        ) {


            menuButton.addEventListener(
                "click",
                function () {

                    sidebar.classList.toggle(
                        "open"
                    );

                    overlay.classList.toggle(
                        "show"
                    );

                }
            );


            overlay.addEventListener(
                "click",
                function () {

                    sidebar.classList.remove(
                        "open"
                    );

                    overlay.classList.remove(
                        "show"
                    );

                }
            );

        }


        /* =================================================
           ADD DEPARTMENT MODAL
        ================================================= */

        const modal =
            document.getElementById(
                "departmentModal"
            );


        const openButton =
            document.getElementById(
                "openDepartmentModal"
            );


        const closeButton =
            document.getElementById(
                "closeDepartmentModal"
            );


        const cancelButton =
            document.getElementById(
                "cancelDepartment"
            );


        const form =
            document.getElementById(
                "departmentForm"
            );


        const modalTitle =
            document.getElementById(
                "modalTitle"
            );


        const formAction =
            document.getElementById(
                "formAction"
            );


        const departmentId =
            document.getElementById(
                "departmentId"
            );


        const departmentName =
            document.getElementById(
                "departmentName"
            );


        const departmentDescription =
            document.getElementById(
                "departmentDescription"
            );


        const submitText =
            document.getElementById(
                "submitText"
            );


        function showDepartmentModal(
            editMode = false,
            id = "",
            name = "",
            description = ""
        ) {


            if (!modal) {
                return;
            }


            if (editMode) {

                modalTitle.textContent =
                    "Edit Department";

                formAction.value =
                    "edit";

                departmentId.value =
                    id;

                departmentName.value =
                    name;

                departmentDescription.value =
                    description;

                submitText.textContent =
                    "Save Changes";

            } else {

                modalTitle.textContent =
                    "Add Department";

                formAction.value =
                    "add";

                departmentId.value =
                    "";

                departmentName.value =
                    "";

                departmentDescription.value =
                    "";

                submitText.textContent =
                    "Create Department";

            }


            modal.classList.add(
                "show"
            );


            setTimeout(
                function () {

                    departmentName.focus();

                },
                200
            );


            document.body.style.overflow =
                "hidden";

        }


        window.openDepartmentModal =
            function () {

                showDepartmentModal();

            };


        function closeDepartmentModal() {

            if (!modal) {
                return;
            }


            modal.classList.remove(
                "show"
            );


            document.body.style.overflow =
                "";

        }


        if (openButton) {

            openButton.addEventListener(
                "click",
                function () {

                    showDepartmentModal();

                }
            );

        }


        if (closeButton) {

            closeButton.addEventListener(
                "click",
                closeDepartmentModal
            );

        }


        if (cancelButton) {

            cancelButton.addEventListener(
                "click",
                closeDepartmentModal
            );

        }


        if (modal) {

            modal.addEventListener(
                "click",
                function (event) {

                    if (
                        event.target === modal
                    ) {

                        closeDepartmentModal();

                    }

                }
            );

        }


        /* =================================================
           EDIT BUTTONS
        ================================================= */

        const editButtons =
            document.querySelectorAll(
                ".edit-button"
            );


        editButtons.forEach(
            function (button) {

                button.addEventListener(
                    "click",
                    function () {

                        showDepartmentModal(
                            true,
                            button.dataset.id,
                            button.dataset.name,
                            button.dataset.description
                        );

                    }
                );

            }
        );


        /* =================================================
           DELETE MODAL
        ================================================= */

        const deleteModal =
            document.getElementById(
                "deleteModal"
            );


        const deleteId =
            document.getElementById(
                "deleteDepartmentId"
            );


        const deleteName =
            document.getElementById(
                "deleteDepartmentName"
            );


        const cancelDelete =
            document.getElementById(
                "cancelDelete"
            );


        const deleteButtons =
            document.querySelectorAll(
                ".delete-button"
            );


        deleteButtons.forEach(
            function (button) {

                button.addEventListener(
                    "click",
                    function () {

                        deleteId.value =
                            button.dataset.id;

                        deleteName.textContent =
                            button.dataset.name;

                        deleteModal.classList.add(
                            "show"
                        );

                        document.body.style.overflow =
                            "hidden";

                    }
                );

            }
        );


        function closeDeleteModal() {

            deleteModal.classList.remove(
                "show"
            );

            document.body.style.overflow =
                "";

        }


        if (cancelDelete) {

            cancelDelete.addEventListener(
                "click",
                closeDeleteModal
            );

        }


        if (deleteModal) {

            deleteModal.addEventListener(
                "click",
                function (event) {

                    if (
                        event.target === deleteModal
                    ) {

                        closeDeleteModal();

                    }

                }
            );

        }


        /* =================================================
           SEARCH
        ================================================= */

        const searchInput =
            document.getElementById(
                "departmentSearch"
            );


        const cards =
            document.querySelectorAll(
                ".department-card"
            );


        const emptySearch =
            document.getElementById(
                "emptySearch"
            );


        if (searchInput) {

            searchInput.addEventListener(
                "input",
                function () {

                    const searchTerm =
                        searchInput.value
                            .trim()
                            .toLowerCase();


                    let visibleCount = 0;


                    cards.forEach(
                        function (card) {

                            const name =
                                card.dataset.name
                                    .toLowerCase();


                            if (
                                name.includes(
                                    searchTerm
                                )
                            ) {

                                card.style.display =
                                    "";

                                visibleCount++;

                            } else {

                                card.style.display =
                                    "none";

                            }

                        }
                    );


                    if (emptySearch) {

                        emptySearch.style.display =
                            visibleCount === 0
                            ? "block"
                            : "none";

                    }

                }
            );

        }


        /* =================================================
           KEYBOARD ESCAPE
        ================================================= */

        document.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key !== "Escape"
                ) {

                    return;

                }


                if (
                    modal &&
                    modal.classList.contains(
                        "show"
                    )
                ) {

                    closeDepartmentModal();

                }


                if (
                    deleteModal &&
                    deleteModal.classList.contains(
                        "show"
                    )
                ) {

                    closeDeleteModal();

                }

            }
        );

    }
);


/* =====================================================
   NOTIFICATION
===================================================== */

function closeNotification() {

    const notification =
        document.getElementById(
            "notification"
        );


    if (!notification) {
        return;
    }


    notification.style.opacity =
        "0";


    notification.style.transform =
        "translateY(-10px)";


    setTimeout(
        function () {

            notification.remove();

        },
        300
    );

}