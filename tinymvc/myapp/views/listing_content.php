<?php echo $searchBox; ?>
        <div class="row">
            <div class="box-wrapper  span12">
                
                <div class="row">
                    <div class="title span12">
                        <h3 class="pull-left">Videos tagged 'Game of Thrones'</h3>
                        <div class="sort pull-right dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <?php //echo $current_sorting; ?> Newest videos
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="icon-tag"></i>By Name</a></li>
                                <li><a href="#"><i class="icon-list"></i>List</a></li>
                                <li><a href="#"><i class="icon-eye-open"></i>View</a></li>
                            </ul>
                        </div>
                    </div><!-- end title -->
                </div>
                <ul class="thumbnails thumbnails-horizontal">
<?php echo $listingItems; ?>
                </ul>
<?php echo $pager; ?>
            </div><!-- end  -->
