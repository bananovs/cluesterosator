<?php
// session_start();
?>
<? //ob_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
<?php

/*
if(isset($_POST['paswd'])) {
  $pass = "assaassa";
  if($_POST['paswd'] === $pass) {
    $_SESSION['access']=true;
    header("Location: index.php");
  }
  else {
    header("Location: index.php");
  }
} elseif (!isset($_SESSION['access'])) {
  */
  ?>
  <!-- <div class="container">
  <form method="POST">
  
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="paswd" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  </div> -->
  <?php
//}
?>
<?php //if (isset($_SESSION['access']) && $_SESSION['access'] === true): 
  ?>


  <body>
      <br><br><br>
  <main role="main" class="container">
      <div class="jumbotron">
        <h1>Клустеризатор</h1>
        <form action="run.php"  enctype="multipart/form-data" method="POST">
            <!-- <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Example file input</label>
                <div class="col-sm-10">
                <input type="file" name='file' class="form-control-file" id="exampleFormControlFile1">
                </div>
            </div> -->
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <textarea class="form-control" name='text' id="exampleFormControlTextarea1" rows="13"></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="makecurrentyear" type="checkbox" value="1" id="defaultCheck1" checked>
                <label class="form-check-label" for="defaultCheck1">
                    Поставить актуальный год (<?php echo date('Y');?>)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_random" value="1" id="defaultCheck1" checked>
                <label class="form-check-label" for="defaultCheck1">
                    Рандомить строки в группе
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="makesmall" value="1" id="defaultCheck1" checked>
                <label class="form-check-label" for="defaultCheck1">
                    Брать по 1 ключу из группы
                </label>
            </div>
            <!-- <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Не брать первых строк в массиве</label>
                <div class="col-sm-10">
                    <input class="form-control" name='firststring' type="text" value='' placeholder="">
                </div>
            </div> --><br>
            <button type="submit" class="btn btn-primary mb-2">Поехали</button>
        </form>
      </div>
    </main>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

<?php //endif; 
?>