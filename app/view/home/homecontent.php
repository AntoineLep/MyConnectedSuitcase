<section id="stats">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 class="section-subheading text-muted">Be part to the adventure</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading"><?php echo $homeVars['nbUser']; ?> Users</h4>
                <p class="text-muted">Share their globe trotting experiences</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-globe fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading"><?php echo $homeVars['nbTrip']; ?> Trips</h4>
                <p class="text-muted">Around the world have been created</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading"><?php echo $homeVars['nbDestination']; ?> Destinations</h4>
                <p class="text-muted">To discover as if you were there</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-image fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading"><?php echo $homeVars['nbImage']; ?> Pictures</h4>
                <p class="text-muted">To show you what the world is made of</p>
            </div>
        </div>
        <div class="row" style="padding: 30px;">
            <div class="col-lg-12 text-center">
                <h3 class="section-subheading text-muted">Bring up your friends in your trips : <a class="btn btn-lg btn-primary" href=<?php echo url('user/login') ?>>Log In</a>&nbsp; / &nbsp;<a class="btn btn-lg btn-success" href=<?php echo url('user/signup') ?>>Sign Up</a></h3>
            </div>
        </div>
    </div>
</section>
<!-- About Section -->
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">About</h2>
                <h3 class="section-subheading text-muted">The story of our concept</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="timeline">
                    <li>
                        <div class="timeline-image">
                            <img class="img-circle img-responsive" src=<?php echo img_path('timeline/working.jpg'); ?> alt="">
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Sept 2016 - Oct 2016</h4>
                                <h4 class="subheading">Focus on a concept</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">What about sharing your trips with your friend with an easy to use web application ? The target is to provide the most efficient communication support to enhance your trips ! Currently working on it</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <img class="img-circle img-responsive" src=<?php echo img_path('timeline/deploy.jpg'); ?> alt="">
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Endly 2016</h4>
                                <h4 class="subheading">Ready for a massive deployment</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">MyConnectedSuitcase is ready to perform</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <h4>We are
                                <br>Waiting
                                <br>For you !</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section id="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Author</h2>
                <h3 class="section-subheading text-muted">Working together to give you the best experience</h3>
            </div>
        </div>
        <div class="row center-block">
            <div class="col-sm-2 col-sm-offset-5">
                <div class="team-member">
                    <img src=<?php echo img_path('team/team1.jpg'); ?> class="img-responsive img-rounded" alt="">
                    <h4>Antoine Leprevost</h4>
                    <p class="text-muted">Creator</p>
                    <ul class="list-inline social-buttons">
                        <li><a href="http://fr.linkedin.com/in/aleprevost/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="text-center">Copyright <?php echo PROGRAM_TITLE; ?>'s Team &copy; 2016</p>
            </div>
            <div class="col-md-6">
                <p class="text-center"><i>Enjoy your trips and share without limit !</i></p>
            </div>
        </div>
    </div>
</footer>