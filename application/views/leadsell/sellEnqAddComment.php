 <ul class=" list-unstyled">
        <li>
            <div class="font-13 "><?=stripslashes($comment)?>
                <div class="text-italic small text-muted">
                        <?=date('d M Y')?> 
                    <?php if(count($result)>1){ ?>
                    <a onclick="getComments('<?=$id?>');"><span style="cursor:pointer;" class="comment-v-more float-R" data-target="#model-comment" data-toggle="modal">View More</span></a>
                    <?php } ?>
                </div>
            </div>
        </li>
     </ul>
