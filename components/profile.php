<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Onishchuk Artem Sergeevich</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <body>

    <nav class="navbar navbar-dark bg-dark p-3">
      <div class="container-fluid">
        <a href="#" class="navbar-brand d-flex align-items-center">
          <img src="../images/DesperadoLogo.png" alt="логотип" class="me-2" width="80" />
          <span class="text-light">History</span>
        </a>
        <?php if (isset($_COOKIE['User'])): ?>
          <form action="/components/logout.php" method="POST" class="d-flex">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
          </form>
        <?php endif; ?>
      </div>
    </nav>


    <div class="container mt-5">
      <div class="story-container">
        <div class="story-text" style="white-space: pre-line;">
          <span>
            Wait this isnt Onishchuk Artem Sergeevich
            This is
            MONSOON
            Of the winds of destruction
            "You can't fight nature, Jack. Wind blows, rain falls, and the strong prey upon the weak"
            "YOU LOST THIS ONE"
          </span>
        </div>
        <img src="../images/MonsoonPortrait.webp" alt="фото" class="monsoon-img" />
      </div>

      <div class="text-center mt-4">
        <button id="toggleButton" class="btn btn-primary">Open</button>
      </div>

      <div id="extraImage" class="mt-3 text-center" style="display: none">
        <img src="../images/MonsoonAttack.webp" alt="скрытое фото" class="monsoon-img" />
      </div>

      <div class="mt-5">
        <h2 class="text-center mb-4">Add New Post</h2>
        <form
          action="profile.php"
          id="postForm"
          class="d-flex flex-column gap-3"
          method="POST"
          enctype="multipart/form-data"
        >
          <div class="form-group">
            <label class="form-label" for="postTitle">Post Title</label>
            <input
              type="text"
              name="postTitle"
              class="form-control monsoon-input"
              id="postTitle"
              placeholder="Enter post Title"
              required
            />
          </div>
          <div class="form-group">
            <label class="form-label" for="postContent">Post Content</label>
            <textarea
              name="postContent"
              class="form-control monsoon-input"
              id="postContent"
              placeholder="Enter post Content"
              rows="5"
              required
            ></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="file">Upload file</label>
            <input
              type="file"
              name="file"
              class="form-control monsoon-input"
              id="file"
            />
          </div>
          <button class="btn btn-primary" type="submit" name="submit">
            Save Post
          </button>
        </form>
      </div>
    </div>

    <script>
      const btn = document.getElementById("toggleButton");
      const extra = document.getElementById("extraImage");
      btn.addEventListener("click", function () {
        if (extra.style.display === "none") {
          extra.style.display = "block";
          btn.textContent = "Close";
        } else {
          extra.style.display = "none";
          btn.textContent = "Open";
        }
      });
    </script>
  </body>
</html>



<?php
require_once('db.php');

if (!isset($_COOKIE['User'])) {
    header("Location: /components/login.php");
    exit();
}

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'first');

if (isset($_POST['submit'])) {              
    $title = $_POST['postTitle'];
    $main_text = $_POST['postContent'];
    if (!$title || !$main_text) die("no data post");

    $imageName = "";


    if (!empty($_FILES["file"]["name"]))
    {
        if (((@$_FILES["file"]["type"] == "image/gif") || (@$_FILES["file"]["type"] == "image/jpeg")
            || (@$_FILES["file"]["type"] == "image/jpg") || (@$_FILES["file"]["type"] == "image/pjpeg")
            || (@$_FILES["file"]["type"] == "image/x-png") || (@$_FILES["file"]["type"] == "image/png"))
            && (@$_FILES["file"]["size"] < 10240000))
        {
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            $imageName = $_FILES["file"]["name"]; 
            echo "Load in: " . "upload/" . $imageName;
        }
        else
        {
            echo "upload failed!";
        }
    }


    $sql = "INSERT INTO posts (title, main_text, image) VALUES ('$title', '$main_text', '$imageName')";
    if (!mysqli_query($link, $sql)) die("error insert data post");
}
?>
