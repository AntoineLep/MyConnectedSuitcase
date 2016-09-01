<?php
    if(isset($destination[0])) //db result
        $destination = $destination[0];

        $lat = isset($destination['lat']) ? $destination['lat'] : 0;
        $lng = isset($destination['lng']) ? $destination['lng'] : 0;
?>
<input type="hidden" id="_lat" value=<?php echo '"' . $lat . '"'; ?>>
<input type="hidden" id="_lng" value=<?php echo '"' . $lng . '"'; ?>>

<div class="row location-picker-container">
    <div class="col-md-12">
        <?php if(!empty(trim($success)) || count($errors) > 0) {
            $alertType = !empty(trim($success)) ? 'alert-success' : 'alert-danger';
            $alertMessage = !empty(trim($success)) ? '<strong>Success:</strong> ' . $success : '<strong>Error:</strong> An error occured when saving your changes. See below for further details';
            ?>
            <div class=<?php echo '"alert ' . $alertType . ' alert-dismissible"'; ?> role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $alertMessage; ?>
            </div>
        <?php } ?>
        <form class="form-default" method="post" action="">
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
            <span><em><u>Drag the marker on the map to update the location to record</u></em></span>
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
                $startDateValueField = (isset($destination['startDate']) && substr($destination['startDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['startDate']) . '"' : '';
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
                $endDateValueField = (isset($destination['endDate']) && substr($destination['endDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['endDate']) . '"' : '';
                $errorClass = (isset($errors['endDate'])) ? ' has-error has-feedback' : '';
                $formGroupClass = '"form-group' . $errorClass . '"';
                $helpBlock = (isset($errors['endDate'])) ? '<span class="help-block">' . $errors['endDate'] . '</span>' : '';
            ?>
            <div class=<?php echo $formGroupClass; ?>>
                <label class="control-label" for="db-end-date">Departure date (mm/dd/yyyy): </label>
                <input type="text" class="form-control" id="location-end-date" name="db-location-end-date" placeholder="When did you left this destination ?" <?php echo $endDateValueField; ?>>
                <?php echo $helpBlock; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>