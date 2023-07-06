<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Main <span class="sr-only">(current)</span></a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <a href="/create.post.php" class="btn btn-success" style="display: block;
    width: max-content;
    margin: 0 0 0 auto;">Add Post</a>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach ($posts as $post) :?>
                        <tr>
                            <th scope="row"><?=$post['id']?></th>
                            <td><a href="/post/show.php?id=<?=$post['id']?>"><?=$post['title']?></a></td>
                            <td>
                                <a href="/post/edit.php?id=<?=$post['id']?>" class="btn btn-info">Edit</a>
                                <a href="/post/delete.php?id=<?=$post['id']?>" class="btn btn-warning" onclick="return confirm('Вы уверены?')">Delete</a>
                            </td>
                        </tr>
                        <?endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>