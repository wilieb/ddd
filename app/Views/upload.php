<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
  </head>
  <body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <form method="post" action="/upload" enctype="multipart/form-data">
                    <label>Select file to upload:</label>
                    <div class="d-flex form-group">
                        <input type="file" name="file" class="form-control">
                        <button type="submit" class="btn btn-warning">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </body>
</html>