<?php

require_once __DIR__ . '/config.php';

include "templates/header.php";

$user = $_SESSION['user']; ?>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6"><h1><?php $user['name'] ?> Profile</h1></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="media">
                    <img src="<?php $user['image'] ?>" alt="<?php $user['name'] ?>">
                    <div class="media-body">
                        <h2><?php $user['name'] ?></h2>
                        <h3><?php $user['email'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-3">
                <a href="logout.php" class="btn btn-warning">Logout</a>
            </div>
        </div>
    </div>

<?php include "templates/footer.php"; ?>