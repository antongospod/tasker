<main class="form-signin mt-5">
    <h1 class="mb-4">Please Sign In</h1>
    <?php if (!$args['isValidForm']) : ?>
        <div class="text-center alert alert-danger">
            <?php echo $args['errorMessage']; ?>
        </div>
    <?php endif; ?>

    <form name="login-form" action="<?php echo $args['formAction']; ?>" method="POST">

        <div class="row mb-4">
            <div class="col-md-12">
                <?php $error = $args['formErrors']['name']; ?>
                <label for="name" class="font-size">Name</label>
                <input id="name"
                       class="form-control <?php echo $error ? 'is-invalid' : ''; ?>"
                       name="name"
                       value="<?php echo $args['formData']['name']; ?>"
                       type="text"
                       placeholder="Enter name"
                >
                <?php if ($error) : ?>
                    <div class="invalid-feedback"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <?php $error = $args['formErrors']['password']; ?>
                <label for="name" class="font-size">Password</label>
                <input id="password"
                       class="form-control <?php echo $error ? 'is-invalid' : ''; ?>"
                       name="password"
                       value="<?php echo $args['formData']['password']; ?>"
                       type="password"
                       placeholder="Enter password"
                >
                <?php if ($error) : ?>
                    <div class="invalid-feedback"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <input type="hidden" name="redirect_to" value="<?php echo $args['redirectTo']; ?>"/>
                <button type="submit" name="submit" value="<?php echo $args['submitAction']; ?>"
                        class="btn btn-success">
                    <?php echo $args['submitLabel']; ?>
                </button>
            </div>
        </div>

    </form>
</main>
