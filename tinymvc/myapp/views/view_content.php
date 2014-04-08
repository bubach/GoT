        <div class="row">
            <!-- **************** start All Flie  ****************** -->
            <div class="box-wrapper span10">
                <div class="row">
                    <div class="title span10">
                        <h3 class="pull-left"><?php echo $fileName; ?></h3>
                    </div><!-- end title -->
                </div>
                <ul class="thumbnails">
                    <li class="span10">
                        <div id="playerContainer" class="thumbnail border-radius-top">
                            <img class="border-radius-top" src="<?php echo $imageUrl; ?>">
                        </div>
                        <script type="text/javascript">
                            jwplayer("playerContainer").setup({
                                width: 780,
                                height: 439,
                                playlist: [{
                                    file: "<?php echo $fileUrl; ?>&/hej.mp4",
                                    image: "<?php echo $imageUrl; ?>"
                                    <?php echo $subSettings; ?>
                                }]
                            });
                        </script>
                        <div class="box border-radius-bottom">
                            <p>
                                <span class="title_torrent pull-left">Episode</span>
                                <span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>Unknown views</span>
                            </p>
                        </div>
                    </li>
                </ul>
            </div><!-- end  -->
<?php echo $itemSidebar; ?>
            <!-- **************** end All Flie  ****************** -->
        </div><!-- row -->