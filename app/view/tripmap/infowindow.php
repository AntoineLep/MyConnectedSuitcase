<div class="row">
    <div class="col-md-12">
        <h2 id="destination-description"><?php echo $destination['name']; ?></h2>
        <?php if(!empty(trim($destination['description']))) { ?><p class="text-muted"><?php echo $destination['description']; ?> </p><?php } 
            $fromDate = (isValidDateTime($destination['startDate'])) ? ' - arrived: <em>' . dateFormat($destination['startDate']) . '</em>' : '';
            $toDate = (isValidDateTime($destination['endDate'])) ? ' - left: <em>' . dateFormat($destination['endDate']) . '</em>' : '';
        ?>
        <span>Transportation type: <i class=<?php echo '"' . 'fa fa-' . $transportationTypeDetail['fa_icon'] . '"'; ?>></i> <?php echo $fromDate . $toDate; ?></span>
    </div>
</div>
<hr/>
<?php if($images != null){ ?>
    <div class="row">
        <?php
            foreach ($images as $image) {
            $srcSmall = img_path($imageFolder . '/' . 'small_' . $image['filename']);
            $srcBig = img_path($imageFolder . '/' . 'big_' . $image['filename']);

            $caption = (!is_null($image['caption']) && !empty(trim($image['caption']))) ? '<h3>' . $image['caption'] . '</h3>' : '';
            $description = (!is_null($image['description']) && !empty(trim($image['description']))) ? '<p>' . $image['description'] . '</p>' : '';
            $id = '"' . 'img' . $image['id'] . '"';
        ?>
        <div class="col-sm-12 col-md-6">
            <div class="thumbnail" id=<?php echo $id; ?>>
                 <a href=<?php echo $srcBig; ?>><img src=<?php echo $srcSmall; ?>></a>
                <div class="caption">
                    <?php echo $caption; ?>
                    <?php echo $description; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
<?php } ?>