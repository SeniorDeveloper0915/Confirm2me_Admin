<?php
    session_start();
    include '../config/config.php';
    error_reporting(0);
    $msg = "";

if (!isset($_SESSION['admin'])) {
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>

    <title>View Affidavits</title>
    <?php include '../include/css/mandatory.php' ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<!--    <link href="../assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />-->
    <link href="../assets/plugins/froiden-helper/helper.css" rel="stylesheet" type="text/css" />
    <?php include '../include/css/global.php' ?>
</head>
<!-- END PAGE HEAD-->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../include/header.php'; ?>
<div class="page-container">
    <?php include '../include/sidebar.php'; ?>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <i class="icon-user font-green"></i>
                        <span class="caption-subject bold uppercase">Affidavits</span>
                    </div>
                </div>
                <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover dt-responsive" id="affidavitTable">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th class="min-tablet">Content</th>
                                <th class="min-tablet">Description</th>
                                <th class="min-tablet">Owner</th>
                                <th>Id</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                        </table>
                            <!-- /.table-responsive -->
                    </div>
                    <!-- /.portlet -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#content-container -->
    </div>

<!--<!--Begin  Modal -->
<div id="deleteModal" class="modal modal-styled fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-user-unfollow font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">Delete Confirmation</span>
                    </div>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Are you sure ! You want to delete this User?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                        <button type="submit" id="delete" class="btn red btn-outline">Delete</button>
                    </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Add Model start-->
<div id="addModal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<!--Add model end-->

<!--Edit Model start-->

<div id="editModal" class="modal fade" tabindex="-1" data-width="400">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>

<!--Add model end-->
<!--End modal -->

<?php include '../include/footer.php' ?>
<?php include '../include/footerjs.php' ?>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!--<script src="../assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>-->
<script src="../assets/plugins/froiden-helper/helper.js" type="text/javascript"></script>
<script>
    // Show affidavits datatable
    var table = $('#affidavitTable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sServerMethod": "GET",
        "aaSorting": [[0, "desc"]],
        "sAjaxSource": "../ajax/affidavit_view.php",
        "aoColumns": [
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": false, "bSearchable": false, "bSortable": false},
            {"bVisible": true, "bSearchable": false, "bSortable": false}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
   

            // var userImage = aData['2'];

            // if(userImage == null) {
            //     userImage = '../images/avatar/no-image.png'
            // } else {
            //     userImage = '../images/avatar/' + userImage;
            // }

            // $(row.find("td")['2']).html(
            //     '<img style="width:9em ;height:8em;" src="' + userImage + '"/>'
            // );
        }

    });

    // Delete affidavit
    function del(id, name) {

        $('#deleteModal').find(".modal-body").html('Are you sure ! You want to delete <strong>'+name+'</strong>?');
        $('#deleteModal').appendTo("body").modal('show');
        $("#delete").click(function () {

            $.easyAjax({
                type: "POST",
                url: "../ajax/delete_affidavit.php?id="+id,
                container: "#deleteModal",
                success: function (response) {
                    if (response.status == "success") {
                        $('#deleteModal').modal('hide');
                        table._fnDraw();
                    }
                }
            });
        })

    }
</script>
</body>
</html>