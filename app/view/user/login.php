<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Log In</h3>
            </div>
            <div class="panel-body">
                <?php if(count($errors) > 0 && isset($errors['other'])) { ?>
                    <div class=<?php echo '"alert alert-danger alert-dismissible"'; ?> role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo '<strong>Error:</strong> ' . $errors['other']; ?>
                    </div>
                <?php } ?>
                <form role="form" method="post" action=<?php echo url('user/login'); ?>>
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
                            $errorClass = (isset($errors['password'])) ? ' has-error has-feedback' : '';
                            $formGroupClass = '"form-group' . $errorClass . '"';
                            $helpBlock = (isset($errors['password'])) ? '<span class="help-block">' . $errors['password'] . '</span>' : '';
                        ?>
                        <div class=<?php echo $formGroupClass; ?>>
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            <?php echo $helpBlock; ?>
                        </div>
                        <span><a href=<?php echo url('user/forgotpassword'); ?>>Forgot your password ?</a>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                            </label>
                        </div>
                        <input class="btn btn-lg btn-success btn-block" type="submit" value="Log In" />
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>