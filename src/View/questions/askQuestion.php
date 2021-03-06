<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="d-flex my-4 px-2">
    <a href="?page=index"><i class="fas fa-home"></i> Home</a>
    <p class="px-2"> > </p>
    <p>Ask A question</p>
</div>

<!-- Si l'utilisateur est connecté -->
<?php if (isset($_SESSION['id'])) : ?>
    <form action="" method="post">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Want to ask a question ?</h3>

                            <div class="form-outline mb-4">
                                <input type="text" id="title" name="title" class="form-control form-control-lg" required />
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" id="technology" name="technology" class="form-control form-control-lg" required />
                                <label class="form-label" for="technology">Technology</label>
                            </div>

                            <div class="form-outline mb-4">
                                <textarea name="content" id="content" class="form-control form-control-lg" required> </textarea>
                                <label class="form-label" for="content">Content</label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" id="submitAskQuestion" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Si l'utilisateur est déconnecté on affiche un message -->
<?php else : ?>
    <h5 class="py-4 text-center notificationLoginIn">To ask a question you have to be logged in. You can log in <a href="?page=login">here.</a></h5>
<?php endif ?>


<?php

require_once './src/View/includes/footer.inc.php';

?>