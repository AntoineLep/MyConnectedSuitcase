<div class="row">
    <div class="col-md-12">
        <?php if(isset($success) && !empty(trim($success))){ ?>
                <div class=<?php echo '"alert alert-success alert-dismissible"'; ?> role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo '<strong>Success: </strong>' . $success; ?>
                </div>
        <?php }
            if(isset($error) && !empty(trim($error))){ ?>
                <div class=<?php echo '"alert alert-danger alert-dismissible"'; ?> role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo '<strong>Error: </strong>' . $error; ?>
                </div>
        <?php } ?>
    </div>
</div>