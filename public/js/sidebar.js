document.addEventListener("DOMContentLoaded", function () {
    let menuItems = document.querySelectorAll(".iocn-link");
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    let homeContent = document.querySelector(".home-content");
    let mainContent = document.querySelector(".home-section");
    let dropdownMenu = document.querySelector(".dropdown-menu");

    function adjustSidebar() {
        if (window.innerWidth <= 768) { 
            // Mobile view: Sidebar closed by default
            sidebar.classList.add("close");
            homeContent.style.left = "0";
            homeContent.style.width = "100%";
            mainContent.style.left = "0";
            mainContent.style.width = "100%";
        } else {
            // Desktop view: Sidebar closed by default with 78px width
            sidebar.classList.add("close");
            homeContent.style.left = "78px";
            homeContent.style.width = "calc(100% - 78px)";
        }
    }

    // Run this function on page load and when the window resizes
    adjustSidebar();
    window.addEventListener("resize", adjustSidebar);

    // Sidebar Toggle
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");

        if (window.innerWidth <= 768) {
            // Mobile: Sidebar opens full screen
            if (sidebar.classList.contains("close")) {
                sidebar.style.width = "0"
                homeContent.style.left = "0";
                homeContent.style.width = "100%";
                mainContent.style.left = "0";
                mainContent.style.width = "100%";
            } else {
                sidebar.style.width = "0"
                homeContent.style.left = "260px";
                homeContent.style.width = "calc(100% - 260px)";
            }
        } else {
            // Desktop: Adjust width based on sidebar state
            if (sidebar.classList.contains("close")) {
                homeContent.style.left = "78px";
                homeContent.style.width = "calc(100% - 78px)";
            } else {
                homeContent.style.left = "260px";
                homeContent.style.width = "calc(100% - 260px)";
            }
        }
        adjustDropdownPosition();
    });

    // Toggle Sub-Menus, ensuring only one is open at a time
    menuItems.forEach(item => {
        item.addEventListener("click", (e) => {
            let parentLi = item.parentElement;

            document.querySelectorAll(".nav-links li").forEach(li => {
                if (li !== parentLi) {
                    li.classList.remove("showMenu");
                }
            });

            parentLi.classList.toggle("showMenu");
        });
    });

    // Close sidebar when clicking outside (only in mobile view)
    document.addEventListener("click", (event) => {
        if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !sidebarBtn.contains(event.target)) {
            sidebar.classList.add("close");
            homeContent.style.left = "0";
            homeContent.style.width = "100%";
            adjustDropdownPosition();
        }
    });
});
