<?php use Core\Helpers; ?>
<main class="mt-5">
    <?php if ($args['tasks']) : ?>
        <h1 class="mb-4">Welcome to Task Manager</h1>
        <div class="table">
            <table class="table table-dark table-hover">
                <thead class="table-light">
                <tr>
                    <?php foreach ($args['columnsMeta'] as $col) : ?>
                        <th class="<?php echo $col['htmlClasses']; ?>">
                            <a class="text-dark" <?php echo $col['orderByUri'] ? 'href="' . $col['orderByUri'] . '"' : ''; ?> >
                                <?php echo $col['columnName']; ?>
                            </a>
                            <span class="arrow"></span>
                        </th>
                    <?php endforeach; ?>
                    <?php if (Helpers::isAdminAuth()) : ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($args['tasks'] as $task) : ?>
                    <tr>
                        <td><?php echo $task['id']; ?></td>
                        <td><?php echo $task['username']; ?></td>
                        <td><?php echo $task['email']; ?></td>
                        <td class="font-weight-bold">
                            <?php if ($task['status']) : ?>
                                <span class="text-success">Completed</span>
                            <?php else : ?>
                                <span class="text-warning">In progress</span>
                            <?php endif; ?>
                            <?php if ($task['updated_at']) : ?>
                                <p class="text-light">Edited by admin</p>
                            <?php endif; ?>
                        </td>
                        <td><?php echo nl2br($task['description']); ?></td>
                        <?php if (Helpers::isAdminAuth()) : ?>
                            <td>
                                <a href="<?php echo Helpers::path('edit/' . $task['id']); ?>">
                                    <button type="button" class="btn btn-light btn-sm">Edit</button>
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php include '../App/Views/partials/_pagination.php'; ?>
    <?php else: ?>
        <h2>No tasks found</h2>
    <? endif; ?>
</main>