<?php var_dump($destination); ?>
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
                <input type="text" class="form-control" size="50" id="location-address" placeholder="Location">
            </div>
            <div class="form-group">
                <?php $locationNameValueField = isset($destination['name']) ? 'value="' . $destination['name'] . '"' : ''; ?>
                <label for="db-location-name">Location name*: </label>
                <input type="text" class="form-control" size="50" id="db-location-name" name="db-location-name" placeholder="Give this location a name" <?php echo $locationNameValueField; ?>>
            </div>
            <input type="hidden" class="form-control" id="location-lat">
            <input type="hidden" class="form-control" id="location-lng">
            <div id="location-picker"></div>
            <div class="form-group">
                <?php $locationDescription = isset($destination['description']) ? $destination['description'] : ''; ?>
                <label for="db-location-description">Location description: </label>
                <textarea class="form-control" id="db-location-description" name="db-location-description" rows="3" placeholder="Location description"><?php echo $locationDescription; ?></textarea>
            </div>

            <input type="submit" value="Save">
        </form>
    </div>
</div>