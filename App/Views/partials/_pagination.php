<?php if ($args['paginationLinks']['previous'] || $args['paginationLinks']['next']) : ?>
<nav>
    <ul class="pagination justify-content-center">
            <li class="page-item <?php echo $args['paginationLinks']['previous'] ? '' : 'disabled' ?>">
                <a class="page-link" href="<?php echo $args['paginationLinks']['previous']; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

        <?php foreach ($args['paginationLinks']['paged'] as $i => $link) : ?>
            <li class="<?php echo $link['isActive'] ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $link['value']; ?>"><?php echo $i; ?></a>
            </li>
        <?php endforeach; ?>

            <li class="page-item <?php echo $args['paginationLinks']['next'] ? '' : 'disabled' ?>">
                <a class="page-link" href="<?php echo $args['paginationLinks']['next']; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
    </ul>
</nav>
<?php endif; ?>
