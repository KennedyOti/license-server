// Toggle sidebar collapse/expand
const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const sidebarOverlay = document.getElementById('sidebarOverlay');

toggleSidebar.addEventListener('click', function() {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');

    // Change icon based on state
    const icon = toggleSidebar.querySelector('i');
    if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('bi-arrow-left-circle');
        icon.classList.add('bi-arrow-right-circle');
    } else {
        icon.classList.remove('bi-arrow-right-circle');
        icon.classList.add('bi-arrow-left-circle');
    }
});

// Mobile menu toggle
mobileMenuBtn.addEventListener('click', function() {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('active');
});

// Close sidebar when clicking on overlay
sidebarOverlay.addEventListener('click', function() {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('active');
});

// Auto-collapse sidebar on small screens
function handleResize() {
    if (window.innerWidth <= 768) {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('expanded');
    }
}

window.addEventListener('resize', handleResize);
handleResize(); // Run on initial load