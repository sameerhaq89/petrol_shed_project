// Super Admin Panel JavaScript

document.addEventListener("DOMContentLoaded", function () {
    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById("mobileMenuToggle");
    const sidebar = document.getElementById("sidebar");

    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener("click", function () {
            sidebar.classList.toggle("active");
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener("click", function (event) {
            if (window.innerWidth <= 768) {
                if (
                    !sidebar.contains(event.target) &&
                    !mobileMenuToggle.contains(event.target)
                ) {
                    sidebar.classList.remove("active");
                }
            }
        });
    }

    // Sidebar Dropdown Menu
    const dropdownItems = document.querySelectorAll(".nav-item.has-dropdown");

    dropdownItems.forEach((item) => {
        const link = item.querySelector(".nav-link");

        link.addEventListener("click", function (e) {
            e.preventDefault();
            item.classList.toggle("open");

            // Close other dropdowns
            dropdownItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    otherItem.classList.remove("open");
                }
            });
        });
    });

    // User Profile Dropdown
    const userProfileBtn = document.getElementById("userProfileBtn");
    const profileDropdownMenu = document.getElementById("profileDropdownMenu");

    if (userProfileBtn && profileDropdownMenu) {
        userProfileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            profileDropdownMenu.classList.toggle("active");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (
                !userProfileBtn.contains(event.target) &&
                !profileDropdownMenu.contains(event.target)
            ) {
                profileDropdownMenu.classList.remove("active");
            }
        });
    }

    // Search functionality (placeholder)
    const searchInput = document.querySelector(".search-input");

    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            const searchTerm = e.target.value.toLowerCase();
            // Implement your search logic here
            console.log("Searching for:", searchTerm);
        });
    }

    // Notification click handler
    const notificationIcon = document.querySelector(".notification-icon");

    if (notificationIcon) {
        notificationIcon.addEventListener("click", function () {
            // Implement notification panel logic here
            console.log("Notifications clicked");
        });
    }
});
