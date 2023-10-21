<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
    $connection = new mysqli('localhost','root','','web_cms_5');
    function getLogo($status){
        global $connection;
        $sql ="SELECT * FROM `logo` WHERE `status`='$status' ORDER BY logo_id DESC LIMIT 1 ";
        $result = $connection->query($sql);
        $row=mysqli_fetch_assoc($result);
        echo $row["thumbnail"];
    }

?>