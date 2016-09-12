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

        if(isset($image['id']))
            $formAction = url('image/' . $image['id']); 
        else
            $formAction = url('image/-1');
        ?>

        <h2>Picture description</h2>

        <form class="form-default" method="post" action=<?php echo $formAction; ?>>
            <?php
                $idDestinationValue = '""';
                if(isset($idDestination))
                    $idDestinationValue = '"' . $idDestination . '"';
                elseif (isset($image['id_destination'])){
                    $idDestinationValue = '"' . $image['id_destination'] . '"';
                    $idDestination = $image['id_destination'];
                }

            ?>
            <input type="hidden" name="id-destination" value=<?php echo $idDestinationValue; ?>/>

            <?php
                $imageCaptionValueField = isset($image['caption']) ? 'value="' . $image['caption'] . '"' : '';
                $errorClass = (isset($errors['caption'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['caption'])) ? '<span class="help-block">' . $errors['caption'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-image-catpion">Picture catpion*: </label>
                <input type="text" class="form-control" id="db-image-caption" name="db-image-caption" placeholder="Give this picture a name" <?php echo $imageCaptionValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>

            <?php
                $imageDescription = isset($image['description']) ? $image['description'] : '';
                $errorClass = (isset($errors['description'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['description'])) ? '<span class="help-block">' . $errors['description'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-image-description">Picture description: </label>
                <textarea class="form-control" id="db-image-description" name="db-image-description" rows="3" placeholder="Picture description"><?php echo $imageDescription; ?></textarea>
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
            <a class="btn btn-default" href=<?php echo url('destination/' . $idDestination . '#destination-picture'); ?> role="button">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Back to the destination info
            </a>
        </form>
    </div>
</div>