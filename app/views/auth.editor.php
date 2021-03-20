<body class="sb-nav-fixed">
%{header}%
<div id="layoutSidenav">
    %{sidenav}%
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid my-4">
                %{toasts}%
                {editor_content}
            </div>
        </main>
        %{footer}%
    </div>
</div>
<script>
    (function($) {
        "use strict";

        // Add active state to sidbar nav links
        var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
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
    $(document).ready( function () {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json'
            }
        });
    } );
</script>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        theme: "monokai",
        viewportMargin: Infinity,
    });
</script>
</body>