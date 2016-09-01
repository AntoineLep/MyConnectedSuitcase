<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-map-signs fa-fw"></i> Stages of the trip
            </div>
            <div class="panel-body">
                <div class="list-group">
                <?php foreach ($destinations as $destination) { 
                        $fromDate = (substr($destination['startDate'], 0, 4) != '0000') ? ' - arrived: <em>' . dateFormat($destination['startDate']) . '</em>' : '';
                        $toDate = (substr($destination['endDate'], 0, 4) != '0000') ? ' - left: <em>' . dateFormat($destination['endDate']) . '</em>' : '';
                ?>
                    <span class="list-group-item clearfix">
                        <?php echo '<strong>' . $destination['name'] . '</strong> ' . $fromDate . $toDate ?>
                        <span class="pull-right">
                            <a class="btn btn-primary" href=<?php echo url('destination/' . $destination['id']); ?> role="button">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update content
                            </a>&nbsp;
                            <a class="btn btn-danger" href=<?php echo url('destination/delete/' . $destination['id']); ?> role="button" onclick="return confirm('Are you sure you want to delete this item? All related content will be deleted');">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                            </a>
                        </span>
                    </span>
                <?php } ?>
                    <a href=<?php echo url('destination/-1'); ?> class="list-group-item text-center"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New destination</a>
                </div>
            </div>
        </div>
    </div>
</div>