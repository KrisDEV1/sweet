<?php
require_once __DIR__ . '/config.php';

include "templates/header.php";

$permissions = ['email'];
$loginURL = $helper->getLoginUrl('http://kristiannikolic.com/sweetheart/fb-callback.php',$permissions); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <a href="<?php echo htmlspecialchars($loginURL); ?>" class="btn btn-primary">Login with Facebook</a>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>