<?php if (!$args['isValidForm']) : ?>
    <div class="text-center alert alert-danger">
        <?php echo $args['errorMessage']; ?>
    </div>
<?php endif; ?>
<form name="task-form" action="<?php echo $args['formAction']; ?>" method="POST">

    <div class="row mb-4">

        <div class="col-md-6">
            <?php $error = $args['formErrors']['username']; ?>
            <label for="username" class="font-size">Username</label>
            <input id="username"
                   class="form-control <?php echo $error ? 'is-invalid' : ''; ?>"
                   name="username"
                   value="<?php echo $args['formData']['username']; ?>"
                   type="text"
                   placeholder="Enter username"
            >
            <?php if ($error) : ?>
                <div class="invalid-feedback"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <?php $error = $args['formErrors']['email']; ?>
            <label for="email">Email</label>
            <input id="email"
                   class="form-control <?php echo $error ? 'is-invalid' : ''; ?>"
                   name="email"
                   value="<?php echo $args['formData']['email']; ?>"
                   type="text"
                   placeholder="Enter email"
            >
            <?php if ($error) : ?>
                <div class="invalid-feedback"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>

    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <?php $error = $args['formErrors']['description']; ?>
            <label for="description">Description</label>
            <textarea id="description" rows="5"
                      class="form-control <?php echo $error ? 'is-invalid' : ''; ?>"
                      name="description"
                      placeholder="Description"
            ><?php echo $args['formData']['description']; ?></textarea>
            <?php if ($error) : ?>
                <div class="invalid-feedback"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($args['isAdminAuth']) : ?>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="check">
                    <input id="completed"
                           class="check-input"
                           name="status"
                           value="1"
                           type="checkbox"
                        <?php echo $args['formData']['status'] ? 'checked' : ''; ?>
                    >
                    <label class="form-check-label" for="completed">Completed</label>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-12">
            <button type="submit" name="submit" value="<?php echo $args['submitAction']; ?>" class="btn btn-success">
                <?php echo $args['submitLabel']; ?>
            </button>
        </div>
    </div>

</form>
