<div class="row">
    <div class="col-md-12">
        <?php if(!empty(trim($success)) || count($errors) > 0) {
            $alertType = !empty(trim($success)) ? 'alert-success' : 'alert-danger';
            $alertMessage = !empty(trim($success)) ? '<strong>Success:</strong> ' . $success : '<strong>Error:</strong> An error occured when saving your changes. See below for further details';
            ?>
            <div class=<?php echo '"alert ' . $alertType . ' alert-dismissible"'; ?> role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $alertMessage; ?>
            </div>
        <?php }

        if(isset($trip['id']))
            $formAction = url('trip/' . $trip['id']); 
        else
            $formAction = url('trip/-1');
        ?>

        <h2>Trip description</h2>

        <form class="form-default" method="post" action=<?php echo $formAction; ?>>
            <?php
                $tripNameValueField = isset($trip['name']) ? 'value="' . $trip['name'] . '"' : '';
                $errorClass = (isset($errors['name'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['name'])) ? '<span class="help-block">' . $errors['name'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-trip-name">Trip name*: </label>
                <input type="text" class="form-control" id="db-trip-name" name="db-trip-name" placeholder="Trip name" <?php echo $tripNameValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>

            <?php
                $tripDescription = isset($trip['description']) ? $trip['description'] : '';
                $errorClass = (isset($errors['description'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['description'])) ? '<span class="help-block">' . $errors['description'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-trip-description">Trip description: </label>
                <textarea class="form-control" id="db-trip-description" name="db-trip-description" rows="3" placeholder="Location description"><?php echo $tripDescription; ?></textarea>
                <?php echo $helpBlock; ?>
            </div>

            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
        </form>
    </div>
</div>