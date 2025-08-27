<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Preview File TXT - {{ $filename }}</title>
    <style>
        body {
            background-color: #1e1e2f;
            color: #eee;
            font-family: monospace;
            padding: 20px;
        }
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #2a2b3d;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #444;
        }
        h3 {
            color: #4e9af1;
        }
        a {
            color: #4e9af1;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h3>📄 Isi File TXT: {{ $filename }}</h3>
    <hr />
    <pre>{{ htmlspecialchars($content) }}</pre>
    <p><a href="{{ url()->previous() }}">← Kembali</a></p>
</body>
</html>
