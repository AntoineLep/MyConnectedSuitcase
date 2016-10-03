<h2>My trips</h2>
<div class="row" id="my-trips">
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
                    <strong><a class="link-no-deco" data-toggle="collapse" href=<?php echo '"#' . $cssId . '"'; ?> aria-expanded="false" aria-controls=<?php echo '"' . $cssId . '"'; ?>><?php echo $trip['name']; ?></a></strong> (<?php echo $destinationNumber; ?>)
                    &nbsp;
                    <a data-toggle="collapse" href=<?php echo '"#' . $cssId . '"'; ?> aria-expanded="false" aria-controls=<?php echo '"' . $cssId . '"'; ?>>
                        <span class="badge badge-default"><i class="fa fa-map-marker fa-fw"></i> See / add destination(s)</span>
                    </a>
                    &nbsp;
                    <a href=<?php echo url('/tripmap/' . $user['username'] . '/' . $trip['id']); ?>><span class="badge badge-default"><i class="fa fa-map fa-fw"></i> See trip map</span></a>
                    <span class="pull-right">
                        <a class="btn btn-primary btn-sm" href=<?php echo url('trip/' . $trip['id']); ?> role="button">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Trip info
                        </a>&nbsp;
                        <a class="btn btn-danger btn-sm" href=<?php echo url('trip/delete/' . $trip['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this item? All related content will be deleted');">
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
                            <?php echo '<strong><a class="link-no-deco" href=' . url('destination/' . $destination['id']) . '>' . $destination['name'] . '</a></strong> ' . $fromDate . $toDate . $imgs ?>
                            <span class="pull-right">
                                <a class="btn btn-primary btn-sm" href=<?php echo url('destination/' . $destination['id']); ?> role="button">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Destination info
                                </a>&nbsp;
                                <a class="btn btn-danger btn-sm" href=<?php echo url('destination/delete/' . $destination['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this item? All related content will be deleted');">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete destination
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
        <a class="btn btn-default btn-sm" href=<?php echo url('trip/-1'); ?> role="button">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New trip
        </a>
    </div>
</div>