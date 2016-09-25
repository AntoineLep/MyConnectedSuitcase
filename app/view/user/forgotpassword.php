<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Forgot your password ?</h3>
            </div>
            <div class="panel-body">
                <?php 
                    if(isset($success) && $success != null){ ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo '<strong>Success:</strong> ' . $success; ?>
                        </div>
                <?php } 
                    else {
                        if(count($errors) > 0 && isset($errors['other'])) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo '<strong>Error:</strong> ' . $errors['other']; ?>
                            </div>
                <?php } ?>
                <form role="form" method="post" action=<?php echo url('user/forgotpassword'); ?>>
                    <fieldset>
                        <?php
                            $emailValueField = isset($user['email']) ? 'value="' . $user['email'] . '"' : '';
                            $errorClass = (isset($errors['email'])) ? ' has-error has-feedback' : '';
                            $formGroupClass = '"form-group' . $errorClass . '"';
                            $helpBlock = (isset($errors['email'])) ? '<span class="help-block">' . $errors['email'] . '</span>' : '';
                        ?>
                        <div class=<?php echo $formGroupClass; ?>>
                            <input class="form-control" placeholder="E-mail" name="email" type="email" <?php echo $emailValueField; ?>>
                            <?php echo $helpBlock; ?>
                        </div>

                        <?php
                            $usernameValueField = isset($user['username']) ? 'value="' . $user['username'] . '"' : '';
                            $errorClass = (isset($errors['username'])) ? ' has-error has-feedback' : '';
                            $formGroupClass = '"form-group' . $errorClass . '"';
                            $helpBlock = (isset($errors['username'])) ? '<span class="help-block">' . $errors['username'] . '</span>' : '';
                        ?>
                        <div class=<?php echo $formGroupClass; ?>>
                            <input class="form-control" placeholder="Username" name="username" type="text" <?php echo $usernameValueField; ?>>
                            <?php echo $helpBlock; ?>
                        </div>
                        <input class="btn btn-lg btn-success btn-block" type="submit" value="Send password reset instructions" />
                    </fieldset>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>