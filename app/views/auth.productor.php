<body class="sb-nav-fixed">
%{header}%
<div id="layoutSidenav">
    %{sidenav}%
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid my-4">
                %{toasts}%
                %{widget_productor}%
            </div>
        </main>
        %{footer}%
    </div>
</div>
<script>
    (function($) {
        "use strict";

        // Add active state to sidbar nav links
        let path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });
        // Toggle the side navigation
        $("#sidebarToggle").on("click", function(e) {
            e.preventDefault();
            $("body").toggleClass("sb-sidenav-toggled");
        });
    })(jQuery);
</script>
</body>