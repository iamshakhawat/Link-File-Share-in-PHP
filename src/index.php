<!doctype html>
<html lang="en">

<head>
    <title>File & URL Share</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


</head>

<body>
    <header>
        <h2 class="text-center">File and URL Share</h2>
    </header>
    <main class="container">
        <div id="urls" class="active card p-3" style="max-height: 250px;overflow-y: scroll;">
        </div>

        <div class="d-flex justify-content-between alignt-items-center my-3">
            <div id="status"></div>
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-primary" id="linkbutton"><i class="bi bi-link-45deg"></i> Links</button>
                <button type="button" class="btn btn-outline-primary" id="copybutton"><i class="bi bi-clipboard-fill"></i> Copy</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="bi bi-cloud-upload-fill"></i> Upload</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#fileManagerModal"><i class="bi bi-cloud-download-fill"></i> Download</button>
            </div>
        </div>

        <?php
        $file = 'text.txt';
        $textContent = '';
        if (file_exists($file)) {
            $textContent = file_get_contents($file); // Read the file content
        }
        ?>


        <textarea name="text" id="textarea" rows="10" class="form-control my-3" placeholder="Type anything"><?php echo htmlspecialchars($textContent); ?></textarea>
    </main>
    <footer class="text-center py-3 mt-4 bg-light">
    <p class="mb-0">
        &copy; <?php echo date('Y'); ?> Created by 
        <a href="https://www.facebook.com/shakhawat.hosen.20" target="_blank" class="text-decoration-none">
            Shakhawat Hosen
        </a>
    </p>
</footer>


    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">File Upload</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Choose File</label>
                            <input type="file" multiple class="form-control" id="fileInput" name="files[]">
                        </div>
                        <div id="uploadStatus" class="my-1"></div>
                        <button type="submit" id="uploadButton" class="btn btn-success mb-3">Upload</button>
                        <div class="progress mb-2 d-none">
                            <div class="progress-bar bg-primary progress-bar-animated progress-bar-striped" id="progressBar" role="progressbar" style="width: 0%;"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </form>
                    <div id="fileAlerts"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Large Modal -->
    <div class="modal fade" id="fileManagerModal" tabindex="-1" aria-labelledby="fileManagerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileManagerModalLabel">Manage Uploaded Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button id="deleteAllBtn" class="btn btn-danger">
                            <i class="bi bi-trash-fill"></i> Delete All Files
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Size</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Download</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="fileTableBody">
                                <!-- Rows will be populated via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#linkbutton").on("click", function() {
                if ($("#urls").hasClass('active')) {
                    $("#urls").hide(400).removeClass('active');
                } else {
                    $("#urls").show(400).addClass('active');
                }
            });
            $("#copybutton").on("click", function() {
                $("#textarea").select();
                if (document.execCommand("copy")) {
                    toastr.success("Text copied to clipboard!");
                } else {
                    toastr.error("Failed to copy text.");
                }
            });
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right", // Change position
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000", // Duration of the message
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            $("#fileInput").on("change", function() {
                const fileAlerts = $("#fileAlerts");
                fileAlerts.empty(); // Clear previous alerts

                // Loop through the selected files
                $.each(this.files, function(index, file) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2); // Convert size to MB
                    const fileType = file.type || "Unknown"; // Get file type
                    let fileIcon;

                    // Determine the file icon based on type
                    if (fileType.startsWith("image/")) {
                        fileIcon = "bi-file-image";
                    } else if (fileType.startsWith("video/")) {
                        fileIcon = "bi-file-play";
                    } else if (fileType.startsWith("audio/")) {
                        fileIcon = "bi-file-music";
                    } else if (fileType === "application/pdf") {
                        fileIcon = "bi-file-earmark-pdf";
                    } else {
                        fileIcon = "bi-file-earmark";
                    }

                    // Create a Bootstrap alert for each file
                    const alertHTML = `
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi ${fileIcon} me-2"></i>
                            <div>
                                <strong>${file.name}</strong><br>
                                Size: ${fileSizeMB} MB<br>
                                Type: ${fileType}
                            </div>
                        </div>
                    `;
                    fileAlerts.append(alertHTML);
                });
            });
            $("#uploadButton").on("click", function(e) {
                e.preventDefault();
                $("#uploadButton").prop('disabled', true);

                const fileInput = $("#fileInput")[0];

                if (fileInput.files.length === 0) {
                    $("#uploadStatus").html('<div class="alert alert-danger">Please select at least one file to upload.</div>');
                    $("#uploadButton").prop('disabled', false);
                    return;
                }

                $(".progress").removeClass('d-none').show(400);
                const formData = new FormData();

                // Append each file to FormData
                $.each(fileInput.files, function(index, file) {
                    formData.append("files[]", file); // Add all selected files to the FormData
                });

                // AJAX Request
                $.ajax({
                    url: "upload.php", // Update to your backend script's location
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function(event) {
                            if (event.lengthComputable) {
                                const percentComplete = Math.round((event.loaded / event.total) * 100);
                                $("#progressBar").css("width", percentComplete + "%").text(percentComplete + "%");
                            }
                        });

                        return xhr;
                    },
                    beforeSend: function() {
                        $("#progressBar").css("width", "0%").text("0%");
                        $("#uploadStatus").html("");
                    },
                    success: function(response) {
                        if (response.uploaded.length > 0) {
                            $("#uploadStatus").html(
                                '<div class="alert alert-success">Files uploaded: ' +
                                response.uploaded.join(", ") +
                                '</div>'
                            );
                        }
                        if (response.errors.length > 0) {
                            response.errors.forEach(error => {
                                $("#uploadStatus").append('<div class="alert alert-danger">' + error + '</div>');
                            });
                        }
                        $("#uploadForm").trigger("reset");
                        $(".progress").hide(400);
                        $("#fileAlerts").html('');
                        $("#uploadButton").prop('disabled', false);
                    },
                    error: function() {
                        $("#uploadStatus").html('<div class="alert alert-danger">File upload failed.</div>');
                        $("#uploadButton").prop('disabled', false);
                    }
                });
            });
            // Download
            $('#fileManagerModal').on('show.bs.modal', function() {
                loadFiles();
            });
            // Load files from the server
            function loadFiles() {
                $.ajax({
                    url: '/list_files.php',
                    type: 'GET',
                    success: function(response) {
                        const files = JSON.parse(response);
                        const tbody = $('#fileTableBody');
                        tbody.empty(); // Clear table body
                        if (files.length === 0) {
                            tbody.append('<tr><td colspan="6" class="text-center">No files found</td></tr>');
                            return;
                        }
                        files.forEach(file => {
                            const row = `
                                <tr data-filename="${file.name}">
                                    <td>${file.name}</td>
                                    <td>${file.size} MB</td>
                                    <td>${file.time}</td>
                                    <td><i class="bi ${file.icon}"></i></td>
                                    <td><button class="btn btn-sm btn-primary download-btn" data-filename="${file.name}">
                                        <i class="bi bi-download"></i>
                                    </button></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger delete-btn" data-filename="${file.name}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    },
                    error: function() {
                        alert('Failed to load files');
                    }
                });
            }
            // Download a file
            $(document).on('click', '.download-btn', function() {
                const filename = $(this).data('filename');
                window.location.href = `/download.php?file=${filename}`;
            });
            // Delete a single file
            $(document).on('click', '.delete-btn', function() {
                const row = $(this).closest('tr');
                const filename = $(this).data('filename');
                const deleteBtn = $(this);

                deleteBtn.html('<i class="bi bi-hourglass-split"></i>'); // Show loading icon

                $.ajax({
                    url: '/delete_file.php',
                    type: 'POST',
                    data: {
                        filename
                    },
                    success: function() {
                        row.hide(400, function() {
                            row.remove();
                        });
                    },
                    error: function() {
                        alert('Failed to delete file');
                    }
                });
            });
            // Delete all files
            $('#deleteAllBtn').on('click', function() {
                if (confirm('Are you sure you want to delete all files?')) {
                    $.ajax({
                        url: '/delete_all_files.php',
                        type: 'POST',
                        success: function() {
                            $('#fileTableBody').empty().append('<tr><td colspan="6" class="text-center">No files found</td></tr>');
                        },
                        error: function() {
                            alert('Failed to delete all files');
                        }
                    });
                }
            });
            const urlSet = new Set(); // Declare the Set to store unique URLs
            // Detect changes in the textarea
            function processUrls() {
                const text = $("#textarea").val(); // Get textarea content
                urlSet.clear();
                if (text.trim() === "") {
                    // Clear all URLs when textarea is empty
                    urlSet.clear(); // Reset the URL set
                    $("#urls").empty(); // Clear the #urls div
                    return; // Exit the function early
                }

                const urls = text.match(/https?:\/\/[^\s]+/g) || []; // Extract URLs using regex

                // Remove all current URLs
                $("#urls").empty();

                // Add only unique URLs to the #urls div
                urls.forEach((url) => {
                    if (!urlSet.has(url)) {
                        urlSet.add(url); // Add the new URL to the Set
                    }
                });

                // Display all URLs in the #urls div
                urlSet.forEach((url) => {
                    $("#urls").append(`<p class="mb-0"><a href="${url}" target="_blank">${url}</a></p>`);
                });

            }
            $("#textarea").on("input", function() {
                processUrls();

            });
            $("#textarea").on("drop", function(e) {
                e.preventDefault();
                const text = e.originalEvent.dataTransfer.getData("text");
                const currentText = $("#textarea").val();
                $("#textarea").val(currentText + text);
                processUrls();
            });

            processUrls();
            saveContent();
            // Function to send AJAX request
            function saveContent() {
                let typingTimer; // Timer for debounce
                const debounceDelay = 500; // 2 seconds of inactivity

                $("#textarea").on("input", function() {
                    clearTimeout(typingTimer);
                    $("#status").text("Typing...");
                    typingTimer = setTimeout(function() {
                        $("#status").text("Saving...");
                        // Send the AJAX request
                        $.ajax({
                            url: "/save-text.php", // Replace with your server endpoint
                            type: "POST",
                            data: {
                                content: $("#textarea").val()
                            },
                            success: function(response) {
                                $("#status").text("Saved");
                                setTimeout(() => {
                                    $("#status").html('');
                                }, 500);
                            },
                            error: function(xhr, status, error) {
                                console.error("Failed to save content:", error);
                            }
                        });
                    }, debounceDelay);
                });



            }

        });
    </script>
</body>

</html>