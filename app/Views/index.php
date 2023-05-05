<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
    <style>
        .error-message {
            color: #FF5252;
            margin: 10px, 10px, 0;
        }
    </style>
  </head>
  <body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <div class="error-message" id="error-message" style="display: none;">Invalid file format. Only zip and JSON formats are allowed.</div>
                <form method="post" action="/upload" enctype="multipart/form-data">
                    <label>Select file to upload:</label>
                    
                    <div class="d-flex form-group">
                        <input type="file" name="file" class="form-control">
                        <button type="submit" class="btn btn-warning">Upload</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h3>Chats</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs->getResultArray() as $log) { ?>
                        <tr>
                            <td><a href="<?php echo base_url('chats/' . $log['id']); ?>"><?php echo $log['id']; ?></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>

        const allowedExtensions = ['.json', '.zip', '.rar'];
        const fileInput = document.querySelector('input[type="file"]');
        const errorMessage = document.querySelector('#error-message');

        fileInput.addEventListener('change', () => {
            const fileName = fileInput.value;
            const extension = fileName.substring(fileName.lastIndexOf('.'));

            if (!allowedExtensions.includes(extension)) {
                errorMessage.style.display = 'block'; 
                fileInput.value = ''; 
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 3000);
            } else {
                errorMessage.style.display = 'none'; 
            }
        });

    </script>
  </body>
</html>
