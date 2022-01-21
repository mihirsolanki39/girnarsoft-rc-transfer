<tr><td colspan="<?php echo $viewcolcount; ?>" align="center">
<?php if (intval($totalCount) > 0) { ?>

        <div class="col-lg-12 col-md-6">
            <nav aria-label="Page navigation">
                <ul class="pagination" >
                    <?php
                    $total_pages = ceil($totalCount / $limit);
                    $pagLink = "";

                    if ($total_pages < 1) {
                        $total_pages = 1;
                    }

                    if ($total_pages != 1) {
                        //this is for previous button
                        if (intval($page) > 1) {
                            $prePage = intval($page) - 1;
                            $pagLink .= '<li onclick="pagination(' . $prePage . ');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>';
                            //this for loop will print pages which come before the current page
                            for ($i = $page - 6; $i < $page; $i++) {
                                if ($i > 0) {
                                    $pagLink .= "<li onclick='pagination(" . $i . ");'><a href='#'>" . $i . "</a></li>";
                                }
                            }
                        }

                        //this is the current page
                        $pagLink .= "<li  class='active' onclick='pagination(" . $i . ");'><a href='#'>" . $page . "</a></li>";
                        //this will print pages which will come after current page
                        for ($i = $page + 1; $i <= $total_pages; $i++) {

                            //$pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                            $pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
                            if ($i >= $page + 3) {
                                break;
                            }
                        }

                        // this is for next button
                        if ($page != $total_pages) {
                            $nextPage = intval($page) + 1;
                            $pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
                        }
                    }

                    echo $pagLink;
                    ?>
                </ul>
            </nav>
        </div>
                <?php } ?>     
</td></tr>