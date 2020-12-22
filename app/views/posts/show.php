<?php require APPROOT . '/views/inc/header.php';?>


<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?>
</div>
<h1><?php echo $data['post']->body; ?></h1>

<?php if ($data['user']->id == $_SESSION['user_id']): ?>
    <hr>

    <div class="d-flex justify-content-between mb-3 ">
        <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class = "btn btn-dark">EDIT</a>
        <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method = "POST">
            <button class = "btn btn-danger ">DELETE</button>
        </form>
    </div>

<?php endif;?>



<?php require APPROOT . '/views/inc/footer.php';?>