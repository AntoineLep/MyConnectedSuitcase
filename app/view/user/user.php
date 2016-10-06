<div class="row">
    <div class="col-md-12">
        <?php if(!empty(trim($success)) || count($errors) > 0) {
            $alertType = !empty(trim($success)) ? 'alert-success' : 'alert-danger';
            $errMess = (isset($errors['other'])) ? $errors['other'] : 'An error occured when saving your changes. See below for further details';
            $alertMessage = !empty(trim($success)) ? '<strong>Success:</strong> ' . $success : '<strong>Error:</strong> ' . $errMess;
            ?>
            <div class=<?php echo '"alert ' . $alertType . ' alert-dismissible"'; ?> role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $alertMessage; ?>
            </div>
        <?php } ?>

        <h2>User profile : <?php echo $user['username']; ?></h2>
        <form class="form-default" method="post" action=<?php echo url('/user/form/updateemail') ?>>
            <h4>Change your E-mail</h4>
            <div class="form-group">
                <label class="control-label" for="current-email">Current E-mail: </label>
                <input type="text" class="form-control" id="current-email" name="current-email" value=<?php echo '"' . $user['email'] . '"'; ?> disabled>
            </div>
            <?php
                $newEmailValueField = isset($userForm['newEmail']) ? 'value="' . $userForm['newEmail'] . '"' : '';
                $errorClass = (isset($errors['newEmail'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['newEmail'])) ? '<span class="help-block">' . $errors['newEmail'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="new-email">New E-mail: </label>
                <input type="text" class="form-control" id="new-email" name="new-email" placeholder="New E-mail" <?php echo $newEmailValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
        </form>
        <hr/>
        <form class="form-default" method="post" action=<?php echo url('/user/form/changepassword') ?>>
            <h4>Change your password</h4>
            <?php
                $errorClass = (isset($errors['currentPassword'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['currentPassword'])) ? '<span class="help-block">' . $errors['currentPassword'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="current-password">Your password: </label>
                <input class="form-control" placeholder="Current password" id="current-password" name="current-password" type="password">
                <?php echo $helpBlock; ?>
            </div>

            <?php
                $errorClass = (isset($errors['password1'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['password1'])) ? '<span class="help-block">' . $errors['password1'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="password1">New password: </label>
                <input class="form-control" placeholder="New password" id="password1" name="password1" type="password">
                <?php echo $helpBlock; ?>
            </div>

            <?php
                $errorClass = (isset($errors['password2'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['password2'])) ? '<span class="help-block">' . $errors['password2'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="password2">Confirm new password: </label>
                <input class="form-control" placeholder="Confirm new password" id="password2" name="password2" type="password">
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
        </form>
        <hr/>
        <h4>Delete your account</h4>
        <form class="form-default" method="post" action=<?php echo url('/user/form/deleteaccount') ?>>
            <input type="hidden" name="delete" value="true"/>
            <?php
                $errorClass = (isset($errors['passwordDeletion'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['passwordDeletion'])) ? '<span class="help-block">' . $errors['passwordDeletion'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="password-deletion">Your password: </label>
                <input class="form-control" placeholder="Your password" id="password-deletion" name="password-deletion" type="password">
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete your account? All related content will be deleted');">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> delete my account
            </button>
        </form>
    </div>
</div>