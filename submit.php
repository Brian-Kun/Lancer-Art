

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lancer Art</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="img/shortcut.ico">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="#Discover" class="index">


    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.html">Lancer Art</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="discover.html">Discover</a>
                    </li>
                    <li>
                        <a href="artists.html">Artists</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li class="active">
                        <a href="submit.php">Submit</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


    <section id="Submit" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Submit Your Own Works of Art</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>

            <?php
//if there is post
if(isset($_POST) && !empty($_POST)){
    //if there is an attachment
    if(!empty($_FILES['attachment']['name'])){
        //store variables
        $file_name = $_FILES['attachment']['name'];
        $temp_name = $_FILES['attachment']['tmp_name'];
        $file_type = $_FILES['attachment']['type'];
        
        //get the extension of the file
        $base = basename($file_name);
        $extension = substr($base, strlen($base)-4, strlen($base));
        
        //only these file types will be allowed
        $allowed_extensions = array(".rar",".zip",".png",".jpg",".PNG",".JPG");
        
        //check that this file type is allowed
        if(in_array($extension, $allowed_extensions)){
            
            //mail essenstials
            $from = $_POST['email'];
            $to = 'lhslancerart@gmail.com'; // email address to send
            $subject = 'Lance Art Submission';
            $message = 'Name: '.$_POST['name']."\r\n\r\n";
            $message .= 'Last Name: '.$_POST['lastname']. "\r\n\r\n";
            $message .= 'Email: '.$_POST['email']."\r\n\r\n";
            
            // things you need
            $file = $temp_name;
            $content = chunk_split(base64_encode(file_get_contents($file)));
            $uid = md5(uniqid(time()));
            
            //standard mail headers
            $headers = "From: " .$from."\r\n";
            $headers .= "Reply-to: ".$replyto."\r\n";
            $headers .= "MIME-version: 1.0 \r\n";
            
            //declaring we have multiple kinds of email(i.e plain text and attachment)
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
            $headers .= "This is a multi-part message in MIME format. \r\n";
            
            //plain text part
            $headers .="--".$uid."\r\n";
            $headers .="Content-Type:text/plain; charset=iso-8859-1 \r\n";
            $headers .="Content-Transfer-Encoding: 7bit \r\n\r\n";
            $headers .= $message."\r\n\r\n";
            
            //file attachment
            $headers .="--".$uid."\r\n";;
            $headers .="Content-Type: ".$file_type."; name=\"".$file_name."\"\r\n";
            $headers .="Content-Transfer-Encoding: base64 \r\n";
            $headers .="Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
            $headers .= $content."\r\n\r\n";
            
            //send the mail (message not here, but in the header)
            if(mail($to, $subject, "", $headers)){ ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Success</strong> You're image has been sent!
                </div> <?php
            } else { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Warning!</strong> The upload has failed! Try again later.
                </div> <?php
            }
            
        } else { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Warning!</strong> This filetype is not allowed!
            </div>  <?php
        }
    } else { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Warning!</strong> You haven't chosen a file!
        </div> <?php
    }
}


?>

           

            <div class="well col-md-6">
                <h2>Share your art work Now!</h2>

                <p>Think you have what’s necessary to be an artist? Well… that doesn’t really matter! Here you can share your artwork whether you are just a rookie or a very experienced artist. Be part of this awesome website by submitting your own art work here! Fill out the form and we will review your submission and upload your art work to the website as soon as we can. </p>
                <h4>Ready?</h4>
                <h4>Set.</h4> 
                <h4>GOO!!</h4>

            </div>

            <div class="well col-md-6">
                <form role="form" method="post" action="submit.php" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name"  name="name"
                     placeholder="Enter Name">
               </div>
               <div class="form-group">
                  <label for="lastname">Last Name</label>
                  <input type="text" class="form-control" name ="lastname" id="lastname" 
                     placeholder="Enter Last Name">
               </div>
               <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email"
                     placeholder="Enter Email">
               </div>
               <div class="form-group">
                  <label for="uploaded_file">Choose your art work</label>
                  <input type="file" id="attachment" name="attachment">
                  <p class="help-block"></p>
               </div>

               <div class="checkbox">
                  <label>
                  <input type="checkbox">Agree to <a href="#">Terms and Conditions</a>
                  </label>
               </div>
                    <input type="submit" class="btn btn-default" name="send" value="Submit">
            </form>
        </div>

       



                
                


     
        </div>
    </section>
   

  
   

    

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Brian Ramirez 2015</span>
                </div>
            </div>
        </div>
    </footer>




    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    
    
    

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
