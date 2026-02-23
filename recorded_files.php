<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigma Video Lectures</title>
    <script src="jquery.js"></script>
    <link href="css\style.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        iframe {
            border-radius: 8px;
            filter: drop-shadow(1px 2px 2px rgb(102, 107, 106));
            background: url("img/p_SIGMA40829_369682.jpg");
            background-size: 100%  100%;
        }

        .video-list {
            text-decoration: none;
            
            width: 100%;
            max-width: 500px;
            display: block;
            height: 50px;
            border-radius: 5px;
            border: 1px solid black;
            color: black;
            padding: 5px;
            margin:5px 2px ;
            box-shadow: 1px 1px 5px rgb(113, 206, 119), -1px -1px 5px rgb(140, 212, 202);
            background: linear-gradient(to right, rgb(17, 206, 235), rgb(64, 241, 117));

        }
        .video-list  div{
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
</head>

<body>
    <center>
        <h2 class="font-h"> Playlist Videos </h2>
    </center>
    <div class="container"><center></center></div>

    

    <div class="modal fade" id="video_cont" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body " style="padding: 0px; margin: 3px;">
                <iframe style="width: 100%;height: fit-content;object-fit: cover;" allowfullscreen name="myFrame" title="Coding development video " frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin">

                </iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>

    <div class="container"  style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
        <a href="video\video.mp4" class="video-list font-h "  target="myFrame">
            <div class="btn" data-bs-toggle="modal" data-bs-target="#video_cont">>>> Coding Tutorials </div>
        </a>
      
        
    </div>
   
   
</body>
<script>

</script>

</html>