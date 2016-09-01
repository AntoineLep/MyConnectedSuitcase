<?php
    if($destination != null)
        $destination = $destination[0];

        $lat = isset($destination['lat']) ? $destination['lat'] : 0;
        $lng = isset($destination['lng']) ? $destination['lng'] : 0;
?>
<input type="hidden" id="_lat" value=<?php echo '"' . $lat . '"'; ?>>
<input type="hidden" id="_lng" value=<?php echo '"' . $lng . '"'; ?>>

<div class="row location-picker-container">
    <div class="col-md-12">

        <form class="form-default" method="post" action="">
            <div class="form-group">
                <label for="location-address">Location: </label>
                <input type="text" class="form-control" id="location-address" placeholder="Location">
            </div>
            <div class="form-group">
                <?php $locationNameValueField = isset($destination['name']) ? 'value="' . $destination['name'] . '"' : ''; ?>
                <label for="db-location-name">Location name*: </label>
                <input type="text" class="form-control" id="db-location-name" name="db-location-name" placeholder="Give this location a name" <?php echo $locationNameValueField; ?>>
            </div>
            <input type="hidden" class="form-control" id="location-lat">
            <input type="hidden" class="form-control" id="location-lng">
            <span><em><u>Drag the marker on the map to update the location to record</u></em></span>
            <div id="location-picker"></div>
            <div class="form-group">
                <?php $locationDescription = isset($destination['description']) ? $destination['description'] : ''; ?>
                <label for="db-location-description">Location description: </label>
                <textarea class="form-control" id="db-location-description" name="db-location-description" rows="3" placeholder="Location description"><?php echo $locationDescription; ?></textarea>
            </div>
            <div class="form-group">
                <?php $startDateValueField = (isset($destination['startDate']) && substr($destination['startDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['startDate']) . '"' : ''; ?>
                <label for="db-start-date">Arrival date: </label>
                <input type="text" class="form-control" id="db-start-date" name="db-start-date" placeholder="When did you arrive to this destination ?" <?php echo $startDateValueField; ?>>
            </div>
            <div class="form-group">
                <?php $endDateValueField = (isset($destination['endDate']) && substr($destination['endDate'], 0, 4) != '0000') ? 'value="' . dateFormat($destination['endDate']) . '"' : ''; ?>
                <label for="db-end-date">Departure date: </label>
                <input type="text" class="form-control" id="db-end-date" name="db-end-date" placeholder="When did you left this destination ?" <?php echo $endDateValueField; ?>>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>