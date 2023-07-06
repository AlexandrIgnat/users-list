<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form action="/store.php" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="text" aria-describedby="emailHelp" placeholder="text">
                </div>
                <div class="form-group">
                    <label for="title">preview</label>
                    <input type="text" class="form-control" name="preview" id="text" aria-describedby="emailHelp" placeholder="text">
                </div>
                <div class="form-group">
                    <label for="title">description</label>
                    <input type="text" class="form-control" name="description" id="text" aria-describedby="emailHelp" placeholder="text">
                </div>
                <div class="form-group">
                    <label for="title">thumbnail</label>
                    <input type="text" class="form-control" name="thumbnail" id="text" aria-describedby="emailHelp" placeholder="text">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>