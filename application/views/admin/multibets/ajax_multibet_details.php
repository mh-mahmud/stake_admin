
<?php foreach($get_data as $val) :  ?>
    <tr>
        <td style="width: 400px !important;text-align:justify;">
          <?= $val->title; ?> => <?= $val->league_title; ?>
        </td>
        <td><?= $val->match_option_title; ?></td>
        <td><?= $val->option_title; ?></td>
        <td><?php echo $val->option_coin; ?></td> 
        <td>
            <?php if($val->bet_status=='MATCH_RUNNING') { ?>
                <h6><span class="badge badge-warning">pending</span></h6>
            <?php } else if($val->bet_status=='WIN') { ?>
                <h6><span class="badge badge-success">win</span></h6>
            <?php } else if($val->bet_status=='USER_CANCEL') { ?>
                <h6><span class="badge badge-danger">reject</span></h6>
            <?php } else if($val->bet_status=='CANCEL_ADMIN') { ?>
                <h6><span class="badge badge-danger">cancel</span></h6>
            <?php } else if($val->bet_status=='LOST') { ?>
                <h6><span class="badge badge-danger">lost</span></h6>
            <?php } ?>
        </td>
    </tr>
<?php endforeach; ?> 