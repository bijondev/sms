<div style="width: 100%; text-align: center;">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th colspan="4" style="text-align: center; font-size: 25px;">** VIEW ALL USER **</th>
        </tr>
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>USER NAME</th>
            <th>COMPANY</th>
            <th>SMS REPORT</th>
        </tr>
        <?php
        $totalsms_sql = "SELECT ((SELECT SUM(`_sms_count`) FROM `_sms_balance`)-(SELECT COUNT(*) FROM `_sms`)) AS smsleft";
        $totalsms_q = $smscon->prepare($totalsms_sql);
        $totalsms_q->execute();
        $result_sms = $totalsms_q->fetch();
        $total_left_sms = $result_sms['smsleft'];
        
        
        $view_all_user_sql = "SELECT * FROM `_user`";
        $view_all_user_q = $smscon->prepare($view_all_user_sql);
        $view_all_user_q->execute();
        $total_user = $view_all_user_q->rowCount();
        
        $view_all_user_q->bindColumn(1, $user_id);
        $view_all_user_q->bindColumn(2, $name);
        $view_all_user_q->bindColumn(3, $user_name);
        $view_all_user_q->bindColumn(6, $company);
        
        $i  = 0; 
        while ($view_all_user_q->fetch())
        {
        $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo isset($name) ?  $name  :NULL; ?></td>
            <td><?php echo isset($user_name) ?  $user_name  :NULL; ?></td>
            <td><?php echo isset($company) ?  $company  :NULL; ?></td>
            <td><a href="?q=smsreport_details&token=<?php echo isset($user_id) ?  $user_id  :NULL; ?>" class="btn btn-small btn-warning" type="button">SMS DETAILS</a></td>
        </tr>
        <?php } ?>
        <tr>
            <th colspan="3" style="text-align: center; font-size: 20px;">Total User = <?php echo isset($total_user) ?  $total_user  :NULL; ?></th>
            <th colspan="2" style="text-align: center; color: red; font-size: 20px;">Total SMS LEFT = <?php echo isset($total_left_sms) ?  $total_left_sms  :NULL; ?></th>
        </tr>
    </table>
    
    
</div>