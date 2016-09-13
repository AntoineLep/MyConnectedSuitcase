<?php
        $lat = isset($destination['lat']) ? $destination['lat'] : 0;
        $lng = isset($destination['lng']) ? $destination['lng'] : 0;
?>
<input type="hidden" id="_lat" value=<?php echo '"' . $lat . '"'; ?>>
<input type="hidden" id="_lng" value=<?php echo '"' . $lng . '"'; ?>>

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

        if(isset($destination['id']))
            $formAction = url('destination/' . $destination['id']); 
        else
            $formAction = url('destination/-1');
        ?>

        <h2 id="destination-description">Destination description</h2>

        <form class="form-default" method="post" action=<?php echo $formAction; ?>>
            <?php
                $idTripValue = '""';
                if(isset($idTrip))
                    $idTripValue = '"' . $idTrip . '"';
                elseif (isset($destination['id_trip']))
                    $idTripValue = '"' . $destination['id_trip'] . '"';

            ?>
            <input type="hidden" name="id-trip" value=<?php echo $idTripValue; ?>/>

            <div class="form-group">
                <label class="control-label" for="location-address">Location: </label>
                <input type="text" class="form-control" id="location-address" placeholder="Location">
            </div>
            <?php
                $locationNameValueField = isset($destination['name']) ? 'value="' . $destination['name'] . '"' : '';
                $errorClass = (isset($errors['name'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['name'])) ? '<span class="help-block">' . $errors['name'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-location-name">Location name*: </label>
                <input type="text" class="form-control" id="db-location-name" name="db-location-name" placeholder="Give this location a name" <?php echo $locationNameValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>

            <input type="hidden" class="form-control" name="db-location-lat" id="location-lat">
            <input type="hidden" class="form-control" name="db-location-lng" id="location-lng">
            <span><em><u>Drag the marker on the map to update the location to be recorded</u></em></span>
            <div id="location-picker"></div>

            <?php
                $locationDescription = isset($destination['description']) ? $destination['description'] : '';
                $errorClass = (isset($errors['description'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['description'])) ? '<span class="help-block">' . $errors['description'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-location-description">Location description: </label>
                <textarea class="form-control" id="db-location-description" name="db-location-description" rows="3" placeholder="Location description"><?php echo $locationDescription; ?></textarea>
                <?php echo $helpBlock; ?>
            </div>

            <?php
                if(!isset($errors['startDate']) && $destination['startDate'] != '')
                    $startDateValueField = (isset($destination['startDate']) && substr($destination['startDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['startDate']) . '"' : '';
                else
                    $startDateValueField = 'value="' . $destination['startDate'] . '"';
                $errorClass = (isset($errors['startDate'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['startDate'])) ? '<span class="help-block">' . $errors['startDate'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-start-date">Arrival date (mm/dd/yyyy): </label>
                <input type="text" class="form-control" id="location-start-date" name="db-location-start-date" placeholder="When did you arrive to this destination ?" <?php echo $startDateValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>

            <?php
                if(!isset($errors['endDate']) && $destination['endDate'] != '')
                    $endDateValueField = (isset($destination['endDate']) && substr($destination['endDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['endDate']) . '"' : '';
                else
                    $endDateValueField = 'value="' . $destination['endDate'] . '"';
                $errorClass = (isset($errors['endDate'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['endDate'])) ? '<span class="help-block">' . $errors['endDate'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-end-date">Departure date (mm/dd/yyyy): </label>
                <input type="text" class="form-control" id="location-end-date" name="db-location-end-date" placeholder="When did you left this destination ?" <?php echo $endDateValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>

            <?php
                $errorClass = (isset($errors['transportationType'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['transportationType'])) ? '<span class="help-block">' . $errors['transportationType'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="transportation-type">Transportation type: </label>
                <select class="form-control" id="transportation-type" name="transportation-type">
                <?php
                    foreach ($transportationTypes as $transportationType){
                        if($transportationType['id'] == $destination['id_transportation_type'])
                            echo '<option value="' . $transportationType['id'] . '" selected>' . $transportationType['name'] . '</option>';
                        else
                            echo '<option value="' . $transportationType['id'] . '">' . $transportationType['name'] . '</option>';
                    }
                ?>
                </select>
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save</button>
        </form>
    </div>
</div>
<?php 
    if(isset($destination) && $destination['id'] > 0) { 
        $imageZoneCaption = (isset($destination['name']) && !isset($errors['name'])) ? 'Pictures of ' . $destination['name'] : 'Destination pictures';
?>
<div class="row">
        <h2 id="destination-picture"><?php echo $imageZoneCaption; ?></h2>
        <?php
            foreach ($images as $image) {
            $src = img_path($imageFolder . '/' . 'small_' . $image['filename']);
            $caption = (!is_null($image['caption']) && !empty(trim($image['caption']))) ? '<h3>' . $image['caption'] . '</h3>' : '';
            $description = (!is_null($image['description']) && !empty(trim($image['description']))) ? '<p>' . $image['description'] . '</p>' : '';
            $id = '"' . 'img' . $image['id'] . '"';
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail" id=<?php echo $id; ?>>
                 <a href=<?php echo url('image/' . $image['id']); ?>><img src=<?php echo $src; ?>></a>
                <div class="caption">
                    <?php echo $caption; ?>
                    <?php echo $description; ?>
                    <p>
                        <a href=<?php echo url('image/' . $image['id']); ?> class="btn btn-primary" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Image info</a>&nbsp;
                        <a href=<?php echo url('image/delete/' . $image['id']); ?> class="btn btn-danger" href=<?php echo url('image/delete/' . $image['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this image?');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete image</a>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-12">
            <a class="btn btn-default" href=<?php echo url('image/-1/' . $destination['id']); ?> role="button">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New picture
            </a>
        </div>
</div>
<?php } ?>