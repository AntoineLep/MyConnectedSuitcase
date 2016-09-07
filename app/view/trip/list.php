<h2>My trips</h2>
<div class="row">
    <div class="col-lg-12">
        <?php foreach ($trips as $trip) { 
            $cssId = 'trip-' . $trip['id'];
            $destinationNumber = 0;
            if(isset($destinationsByTripId[$trip['id']]))
                $destinationNumber = count($destinationsByTripId[$trip['id']]);
        ?>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <a data-toggle="collapse" href=<?php echo '"#' . $cssId . '"'; ?> aria-expanded="false" aria-controls=<?php echo '"' . $cssId . '"'; ?>>
                        <?php echo $trip['name']; ?>
                    </a>
                    <span class="badge badge-info"><?php echo $destinationNumber; ?></span>
                    <span>
                        <?php if(!empty(trim($trip['description'])))
                            echo ' - ' . $trip['description'];
                        ?>
                    </span>
                    <span class="pull-right">
                        <a class="btn btn-primary" href=<?php echo url('trip/' . $trip['id']); ?> role="button">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit trip info
                        </a>&nbsp;
                        <a class="btn btn-danger" href=<?php echo url('trip/delete/' . $trip['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this item? All related content will be deleted');">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete trip
                        </a>
                    </span>
                </div>
                <div class="panel-body collapse" id=<?php echo '"' . $cssId . '"';?>>
                    <div class="list-group">
    
                        <?php if(isset($destinationsByTripId[$trip['id']])) 
                            foreach ($destinationsByTripId[$trip['id']] as $destination) { 
                                $fromDate = (isValidDateTime($destination['startDate'])) ? ' - arrived: <em>' . dateFormat($destination['startDate']) . '</em>' : '';
                                $toDate = (isValidDateTime($destination['endDate'])) ? ' - left: <em>' . dateFormat($destination['endDate']) . '</em>' : '';
    
                                $imgs = '';
    
                                if (isset($destImgNumArr[$destination['id']]))
                                    if ($destImgNumArr[$destination['id']] == 1) 
                                        $imgs = '1 picture';
                                    else
                                        $imgs = $destImgNumArr[$destination['id']] . ' pictures';
                                else
                                    $imgs = '0 picture';
    
                                $imgs = ' - <a href =' . url('destination/' . $destination['id'] . '#destination-picture') .'><i class="glyphicon glyphicon-picture"></i> ' . $imgs . '</a>';
                        ?>
                        <span class="list-group-item clearfix">
                            <?php echo '<strong>' . $destination['name'] . '</strong> ' . $fromDate . $toDate . $imgs ?>
                            <span class="pull-right">
                                <a class="btn btn-primary" href=<?php echo url('destination/' . $destination['id']); ?> role="button">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit info
                                </a>&nbsp;
                                <a class="btn btn-danger" href=<?php echo url('destination/delete/' . $destination['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this item? All related content will be deleted');">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                                </a>
                            </span>
                        </span>
                    <?php } ?>
                        <a href=<?php echo url('destination/-1/' . $trip['id']); ?> class="list-group-item text-center"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New destination</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <a class="btn btn-default" href=<?php echo url('trip/-1'); ?> role="button">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New trip
        </a>
    </div>
</div>