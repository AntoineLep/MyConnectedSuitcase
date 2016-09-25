<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Change my password</h3>
            </div>
            <div class="panel-body">
                <?php 
                    if(isset($success) && $success != null){ ?>
                        <div class="alert alert-success alert-dismissible"' role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo '<strong>Success:</strong> ' . $success; ?>
                        </div>
                <?php } elseif(isset($errors['other'])) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo '<strong>Error:</strong> ' . $errors['other']; ?>
                            </div>
                <?php } elseif (!isset($user['activation_key']) && !isset($user['id'])) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error:</strong> An error occured, please contact an administrator.
                            </div>
                <?php } else { ?>
                <form role="form" method="post" action=<?php echo url('user/resetpassword'); ?>>
                    <fieldset>
                        <input type="hidden" name="token_act" value="<?php echo $user['activation_key']; ?>"/>
                        <input type="hidden" name="token_id" value="<?php echo $user['id']; ?>"/>
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
                            <input class="form-control" placeholder="password confirmation" name="password2" type="password">
                            <?php echo $helpBlock; ?>
                        </div>
                        <input class="btn btn-lg btn-success btn-block" type="submit" value="Change my password" />
                    </fieldset>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>