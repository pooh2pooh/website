    <link href="/lib/codemirror/codemirror.css" rel="stylesheet">
    <link href="/lib/codemirror/monokai.css" rel="stylesheet">
</head>
<body>
    %{header}%
    <main>
    <div class="container">
      <div class="row">
        %{toasts}%
        <div class="my-5">
          {editor_content}
        </div>
      </div>
    </div>
  </main>
  %{footer}%
  <!-- CodeMirror JS -->
  <script src="/lib/codemirror/codemirror.js"></script>
  <script src="/lib/codemirror/matchbrackets.js"></script>
  <script src="/lib/codemirror/multiplex.js"></script>
  <script src="/lib/codemirror/htmlmixed.js"></script>
  <script src="/lib/codemirror/xml.js"></script>
  <script src="/lib/codemirror/javascript.js"></script>
  <script src="/lib/codemirror/css.js"></script>
  <script src="/lib/codemirror/clike.js"></script>
  <script src="/lib/codemirror/php.js"></script>
  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: 'application/x-httpd-php',
        indentUnit: 4,
        indentWithTabs: true,
        theme: 'monokai',
        viewportMargin: Infinity,
    });
  </script>
</body>