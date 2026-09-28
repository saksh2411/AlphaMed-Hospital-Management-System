document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       PAGE LOAD
    ===================================================== */

    document.body.classList.add("page-loaded");


    /* =====================================================
       ANIMATED STATISTICS
    ===================================================== */

    const counters =
        document.querySelectorAll("[data-count]");


    counters.forEach(function (counter) {

        const target =
            parseInt(
                counter.getAttribute("data-count"),
                10
            ) || 0;


        let current = 0;


        const duration = 1100;

        const frameRate = 60;

        const totalFrames =
            Math.round(
                duration / (1000 / frameRate)
            );


        let frame = 0;


        function updateCounter() {

            frame++;


            const progress =
                Math.min(
                    frame / totalFrames,
                    1
                );


            /*
             * Ease-out animation
             */

            const easedProgress =
                1 -
                Math.pow(
                    1 - progress,
                    3
                );


            current =
                Math.floor(
                    target * easedProgress
                );


            counter.textContent =
                current.toLocaleString();


            if (progress < 1) {

                requestAnimationFrame(
                    updateCounter
                );

            } else {

                counter.textContent =
                    target.toLocaleString();

            }

        }


        setTimeout(
            updateCounter,
            350
        );

    });


    /* =====================================================
       LIVE CLOCK
    ===================================================== */

    const clock =
        document.getElementById("liveClock");


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


    /* =====================================================
       MOBILE SIDEBAR
    ===================================================== */

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


        /*
         * Close sidebar after selecting
         * a navigation item on mobile.
         */

        const navLinks =
            sidebar.querySelectorAll(
                ".nav-link"
            );


        navLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function () {

                        if (
                            window.innerWidth <= 900
                        ) {

                            sidebar.classList.remove(
                                "open"
                            );

                            overlay.classList.remove(
                                "show"
                            );

                        }

                    }
                );

            }
        );

    }


    /* =====================================================
       ACTION CARD MICRO-INTERACTION
    ===================================================== */

    const actionCards =
        document.querySelectorAll(
            ".action-card"
        );


    actionCards.forEach(
        function (card) {

            card.addEventListener(
                "mousemove",
                function (event) {

                    const rect =
                        card.getBoundingClientRect();


                    const x =
                        event.clientX -
                        rect.left;


                    const y =
                        event.clientY -
                        rect.top;


                    const centerX =
                        rect.width / 2;


                    const centerY =
                        rect.height / 2;


                    const rotateX =
                        (
                            y - centerY
                        ) / 35;


                    const rotateY =
                        (
                            centerX - x
                        ) / 35;


                    card.style.transform =
                        `
                        translateY(-5px)
                        perspective(700px)
                        rotateX(${rotateX}deg)
                        rotateY(${rotateY}deg)
                        `;

                }
            );


            card.addEventListener(
                "mouseleave",
                function () {

                    card.style.transform =
                        "";

                }
            );

        }
    );


    /* =====================================================
       STAT CARD MICRO-INTERACTION
    ===================================================== */

    const statCards =
        document.querySelectorAll(
            ".stat-card"
        );


    statCards.forEach(
        function (card) {

            card.addEventListener(
                "mousemove",
                function (event) {

                    const rect =
                        card.getBoundingClientRect();


                    const x =
                        event.clientX -
                        rect.left;


                    const y =
                        event.clientY -
                        rect.top;


                    const rotateX =
                        (
                            y -
                            rect.height / 2
                        ) / 60;


                    const rotateY =
                        (
                            rect.width / 2 -
                            x
                        ) / 60;


                    card.style.transform =
                        `
                        translateY(-5px)
                        perspective(900px)
                        rotateX(${rotateX}deg)
                        rotateY(${rotateY}deg)
                        `;

                }
            );


            card.addEventListener(
                "mouseleave",
                function () {

                    card.style.transform =
                        "";

                }
            );

        }
    );


    /* =====================================================
       AI BUTTON
    ===================================================== */

    const aiButton =
        document.querySelector(
            ".ai-button"
        );


    if (aiButton) {

        aiButton.addEventListener(
            "click",
            function () {

                /*
                 * AI functionality will be
                 * connected in a later step.
                 */

                aiButton.classList.add(
                    "button-active"
                );


                setTimeout(
                    function () {

                        aiButton.classList.remove(
                            "button-active"
                        );

                    },
                    500
                );

            }
        );

    }


    /* =====================================================
       WINDOW RESIZE
    ===================================================== */

    window.addEventListener(
        "resize",
        function () {

            if (
                window.innerWidth > 900
            ) {

                if (sidebar) {

                    sidebar.classList.remove(
                        "open"
                    );

                }

                if (overlay) {

                    overlay.classList.remove(
                        "show"
                    );

                }

            }

        }
    );

});