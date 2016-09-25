<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Sign up</h3>
            </div>
            <div class="panel-body">
                <?php 
                    if(isset($success) && $success != null){ ?>
                        <div class=<?php echo '"alert alert-success alert-dismissible"'; ?> role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo '<strong>Success:</strong> ' . $success; ?>
                        </div>
                <?php } 
                    else {
                        if(count($errors) > 0 && isset($errors['other'])) { ?>
                            <div class=<?php echo '"alert alert-danger alert-dismissible"'; ?> role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo '<strong>Error:</strong> ' . $errors['other']; ?>
                            </div>
                <?php } ?>
                    <form role="form" method="post" action=<?php echo url('user/signup'); ?>>
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

                            <?php
                                $errorClass = (isset($errors['password1'])) ? ' has-error has-feedback' : '';
                                $formGroupClass = '"form-group' . $errorClass . '"';
                                $helpBlock = (isset($errors['password1'])) ? '<span class="help-block">' . $errors['password1'] . '</span>' : '';
                            ?>
                            <div class=<?php echo $formGroupClass; ?>>
                                <input class="form-control" placeholder="Password" name="password1" type="password">
                                <?php echo $helpBlock; ?>
                            </div>

                            <?php
                                $errorClass = (isset($errors['password2'])) ? ' has-error has-feedback' : '';
                                $formGroupClass = '"form-group' . $errorClass . '"';
                                $helpBlock = (isset($errors['password2'])) ? '<span class="help-block">' . $errors['password2'] . '</span>' : '';
                            ?>
                            <div class=<?php echo $formGroupClass; ?>>
                                <input class="form-control" placeholder="Confirm password" name="password2" type="password">
                                <?php echo $helpBlock; ?>
                            </div>

                            <?php
                                $errorClass = (isset($errors['terms'])) ? ' has-error has-feedback' : '';
                                $formGroupClass = '"form-group checkbox ' . $errorClass . '"';
                                $helpBlock = (isset($errors['terms'])) ? '<span class="help-block">' . $errors['terms'] . '</span>' : '';
                            ?>
                            <div class=<?php echo $formGroupClass; ?>>
                                <label>
                                    <input name="terms" type="checkbox" value="agreed"> I have read and agree the <a href=<?php echo url('gcu'); ?> target="_blank">Terms and conditions</a>
                                    <?php echo $helpBlock; ?>
                                </label>
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Sign Up" />
                        </fieldset>
                    </form>
                <?php }?>
            </div>
        </div>
    </div>
</div>