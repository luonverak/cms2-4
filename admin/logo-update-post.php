<?php
    include('sidebar.php');
    $logoId = $_GET['id'];
    $logo_sql ="SELECT * FROM `logo` WHERE logo_id='$logoId'";
    $rs=$connection->query($logo_sql);
    $row=mysqli_fetch_assoc($rs);
    $header="";
    $footer= "";
    if($row["status"]== "Header"){
        $header="selected";
    }else{
        $footer="selected";
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit Logo News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option  <?php echo $header ?> value="Header">Header</option>
                                            <option <?php echo $footer ?> value="Footer">Footer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input name="thumbnail" type="file" class="form-control">
                                        <img src="assets/image/<?php echo $row['thumbnail'] ?>" width="150" alt="">
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail'] ?>" id="">
                                        <input type="hidden" name="logo_id" value="<?php echo $logoId;?>" id="">
                                    </div>

                                    <div class="form-group">
                                        <button name="btnEditLogo" type="submit" class="btn btn-success">Edit</button>
                                        <a href="logo-view-post.php" type="submit" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>