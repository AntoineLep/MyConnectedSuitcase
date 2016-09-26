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

        <form class="form-default" method="post" action=<?php echo $formAction; ?> enctype="multipart/form-data">
            <?php
                $idDestinationValue = '""';
                if(isset($idDestination))
                    $idDestinationValue = '"' . $idDestination . '"';
                elseif(isset($image['id_destination'])){
                    $idDestinationValue = '"' . $image['id_destination'] . '"';
                    $idDestination = $image['id_destination'];
                }

                $dbImageValue = '""';
                if(isset($image['filename']) && !empty($image['filename']))
                    $dbImageValue = img_path($imageFolder . '/' . 'big_' . $image['filename']);

            ?>
            <input type="hidden" name="id-destination" value=<?php echo $idDestinationValue; ?>/>
            <input type="hidden" name="db-image-filename" value=<?php echo '"' . $image['filename'] . '"'; ?>/>

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

            <div class="row">
                <?php if($dbImageValue != '""'){ ?>
                <div class="col-md-6 container">
                    <img class="img-responsive img-rounded" src=<?php echo $dbImageValue; ?>>
                </div>
                <?php } 

                    $errorClass = (isset($errors['description'])) ? ' has-error has-feedback' : '';
                    $formGroupClass = '"form-group' . $errorClass . ' col-md-6"';
                    $helpBlock = (isset($errors['file'])) ? '<span class="help-block">' . $errors['file'] . '</span>' : '';
                ?>
                <div class=<?php echo $formGroupClass; ?>>
                    <label for="db-image-file">File input: <?php if($dbImageValue != '""') echo '<em class="text-warning">(The current picture will be overwritten)</em>'; ?></label>
                    <input type="file" id="db-image-file" name="db-image-file">
                    <?php echo $helpBlock; ?>
                </div>
            </div><br/>
            <div class="row">
                <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
                <a class="btn btn-default btn-sm" href=<?php echo url('destination/' . str_replace('"', '', $idDestinationValue) . '#destination-picture'); ?> role="button">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back to the destination info
                </a>
            </div>
        </form>
    </div>
</div>