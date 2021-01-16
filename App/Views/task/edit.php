<main class="mt-5">
    <?php if ($args['updated']) : ?>
        <div class="text-center alert alert-success">
            Task has been updated!!!
        </div>
    <?php else : ?>
        <h1 class="mb-4">Edit Task</h1>
        <?php include '../App/Views/task/form.php'; ?>
    <?php endif; ?>
</main>
