<body class="sb-nav-fixed">
    %{header}%
    <div id="layoutSidenav">
        %{sidenav}%
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid my-4">
                    %{toasts}%
                    %{widget_products}%
                </div>
            </main>
            %{footer}%
        </div>
    </div>
    <script>
        function delProduct(id) {
            $.ajax({
                type: 'POST',
                cache: false,
                dataType: 'json',
                url: '/auth/dashboard',
                data: { id: id },
                success: function(data) {
                    if(data.result === "success") {
                        let node = document.querySelector('#id'+id);
                        node.parentNode.removeChild(node);
                        $('#status').html('Запись с ID '+id+' удалена!');
                        $('.toast').toast('show');
                    }
                },
                error: function() {
                    $('#status').html('error delete id = '+id);
                }
            }).done();
        }
    </script>
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