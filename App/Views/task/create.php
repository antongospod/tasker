<main class="mt-5">
    <?php use Core\Helpers; ?>
    <?php if ($args['newTaskID']) : ?>
        <div class="text-center alert alert-success">
            <p>Success!!!</p>
            <p>New task has been created with ID =<?php echo $args['newTaskID']; ?></p>
            <div><a href="<?php echo Helpers::path(''); ?>" class="btn btn-dark mt-4">Go to tasks list</a></div>
        </div>
    <?php else : ?>
        <h1 class="mb-4">Create Task</h1>
        <?php include '../App/Views/task/form.php'; ?>
    <?php endif; ?>
</main>
