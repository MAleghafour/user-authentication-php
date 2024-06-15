<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <h1 style="text-align: center;">User Profile</h1>
    <a href="<?= site_url('?action=logout') ?>">Logout</a>
    <ul>
        <?php foreach ($userData as $key => $value) : ?>
            <li><?= "$key: $value" ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Page</title>
    <link rel="stylesheet" type="text/css" href="<?= assets('css/styles.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 px-md-5 text-center text-lg-start ">
            <div class="row gx-lg-5 align-items-center mb-5 justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    Auth Project <br />
                        <span style="color: hsl(218, 81%, 75%)">Verify Page</span>
                    </h1>
                    <a class="btn btn-primary mb-5" href="<?= site_url('?action=logout') ?>">Logout</a>
                    <ul style="color: hsl(218, 81%, 75%)">
                        <?php foreach ($userData as $key => $value) : ?>
                            <li><?= "$key: $value" ?></li>
                        <?php endforeach; ?>
                    </ul>  
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
</body>

</html>