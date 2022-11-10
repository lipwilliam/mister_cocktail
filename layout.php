<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha3/css/bootstrap.min.css' integrity='sha512-fjZwDJx4Wj5hoFYRWNETDlD7zty6PA+dUfdRYxe463OBATFHyx7jYs2mUK9BZ2WfHQAoOvKl6oYPCZHd1+t7Qw==' crossorigin='anonymous' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css' integrity='sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==' crossorigin='anonymous' />
    <link rel="stylesheet" href="templates/www/css/style.css">
    <title>App Auth Simplifié</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">App Auth Simplifié</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if (!Session::isConnected()) : ?>
                            <!-- Liens Déconnectés -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=signin">Signin</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=cocktails">Cocktails</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=contact">Contact Us</a>
                        </li>
                        <?php if (Session::isConnected()) : ?>
                            <!-- Liens Connectés -->
                            <?php if (Session::isAdmin()) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?page=dashboard">DashBoard</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?page=logout">Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class='container'>
        <!--
            Affichage des infos user s'il est connecté
        -->
        <?php if (isset($template)) : ?>
            <?php include 'templates/' . $template . '.php' ?>
        <?php endif; ?>
    </main>

    <footer>

    </footer>
</body>

</html>