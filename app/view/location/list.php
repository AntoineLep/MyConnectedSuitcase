<div class="container">
    <div class="list-group">
    <?php foreach ($destinations as $destination) { 
            
            $fromDate = (!empty($destination['startDate'])) ? ' from: <em>' . dateFormat($destination['startDate']) . '</em>' : '';
            $toDate = (!empty($destination['endDate'])) ? ' to: <em>' . dateFormat($destination['startDate']) . '</em>' : '';
    ?>
        <span class="list-group-item clearfix">
            <?php echo '<strong>' . $destination['name'] . '</strong>' . $fromDate . $toDate ?>
            <span class="pull-right">
                <a class="btn btn-primary" href=<?php echo '"location/' . $destination['id'] . '"'; ?> role="button">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                </a>&nbsp;
                <a class="btn btn-danger" href=<?php echo '"location/delete/' . $destination['id'] . '"'; ?> role="button" onclick="return confirm('Are you sure you want to delete this item?');">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                </a>
            </span>
        </span>
    <?php } ?>
        <a href="location/-1" class="list-group-item text-center"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New location</a>
    </div>
</div>