<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Task Management</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <?php
            require_once 'db.php';
            global $db;
            
            $table = '';
            
            $rs = $db->Execute("select * from taskmanagement");
            if($rs->RecordCount() > 0){
                $table .= "<table class=\"table\">";
                
                $table .= "<tr>";
                $table .= "<td>#</td>";
                $table .= "<td>Task Name</td>";
                $table .= "<td>Date</td>";
                $table .= "<td>Priority</td>";
                $table .= "<td>Status</td>";
                $table .= "<td>Edit</td>";
                $table .= "<td>Delete</td>";
                $table .= "</tr>";
                
                $count = 0;
                
                while (!$rs->EOF){
                    $count++;
                    
                    $id = $rs->fields['id'];
                    $tskname = $rs->fields['tskname'];
                    $tskdate = $rs->fields['tskdate'];
                    $tskpriority = $rs->fields['tskpriority'];
                    $tskstatus = $rs->fields['tskstatus'];
                    
                    $edit = "<a href=\"\" onclick=\"edit({$id})\">edit</a>";
                    $delete = "<a href=\"\" onclick=\"delete({$id})\">delete</a>";
                    
                    
                    $table .= "<tr>";
                    $table .= "<td>{$count}</td>";
                    $table .= "<td>{$tskname}</td>";
                    $table .= "<td>{$tskdate}</td>";
                    $table .= "<td>{$tskpriority}</td>";
                    $table .= "<td>{$tskstatus}</td>";
                    $table .= "<td>{$edit}</td>";
                    $table .= "<td>{$delete}</td>";
                    $table .= "</tr>";
                    
                    $rs->MoveNext();
                }
                $table .= "</table>";
            }
            
            
        
        ?>
        
        <section class="container-fluid" style="">
            <div class="container py-5" style=" " id="join">
                <div class="row ">
                    <div class="col-9">
                        <h2>Task Management Form</h2>
                        <form class="mt-3" name="frmModule" id="frmModule" method="post" action="void%200" onsubmit="return false;">
                            <input type="hidden" id="id" name="id">
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="tskname">Task Name</label>
                                    <input type="text" class="form-control" id="tskname" name="tskname" placeholder="Task Name *" >
                                </div>
                            </div>
                            
                            
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="tskdate">Task Date *</label>
                                    <input type="datetime-local" class="form-control" id="tskdate" name="tskdate"" >
                                </div>                        
                            </div>
                            
                            <div class="row row-cols-1 row-cols-md-4 my-2 g-3">
                                  <div class="col">
                                    <label for="tskpriority">Task Priority</label>
                                    <select class="form-control" id="tskpriority" name="tskpriority">
                                        <option value="3">High</option>
                                        <option value="2">Normal</option>
                                        <option value="1">Low</option>
                                    </select>
                                </div>                              
                            </div>
                            
                            <div class="row row-cols-1 row-cols-md-4 my-2 g-3">
                                  <div class="col">
                                    <label for="tskstatus">Task Status</label>
                                    <select class="form-control" id="tskstatus" name="tskstatus">
                                        <option value="1">Complete</option>
                                        <option value="0">Incomplete</option>
                                    </select>
                                </div>                          
                            </div>

                            <div class="row my-4">
                                <div class="col-12">
                                    <button class="btn btn-success btn-sm text-white shadow" type="button" onclick="save()">ADD</button>
                                    <button class="btn btn-success btn-sm text-white shadow" type="button" onclick="update()">UPDATE</button>
                                </div>
                            </div>
                        </form>
                        
                        <div id="dv_data_grid">
                            <?php echo $table; ?>
                        </div>
                    </div>
                    <div class="col-3">

                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript" src="assets/jquery/jquery.js"></script>
        <script type="text/javascript" src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/sweetalert/node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(function() {
                
            });
            
            function save(){
                let tskname = $('#tskname').val();
                let tskdate = $('#tskdate').val();
                let tskpriority = $('#tskpriority').val();
                let tskstatus = $('#tskstatus').val();
                
                if (tskname.trim().length === 0) {
                    alert('Surname Name cannot be empty');
                    return;
                }

                if (tskdate.trim().length === 0) {
                    alert('Other name cannot be empty');
                    return;
                }
                
                if (tskpriority.trim().length === 0) {
                    alert('National ID cannot be empty');
                    return;
                }

                if (tskstatus.trim().length === 0) {
                    alert('Email cannot be empty');
                    return;
                }

                var data = $('#frmModule').serialize();

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=save&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully saved', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
            
            function update(){
                let tskname = $('#tskname').val();
                let tskdate = $('#tskdate').val();
                let tskpriority = $('#tskpriority').val();
                let tskstatus = $('#tskstatus').val();
                
                if (tskname.trim().length === 0) {
                    alert('Surname Name cannot be empty');
                    return;
                }

                if (tskdate.trim().length === 0) {
                    alert('Other name cannot be empty');
                    return;
                }
                
                if (tskpriority.trim().length === 0) {
                    alert('National ID cannot be empty');
                    return;
                }

                if (tskstatus.trim().length === 0) {
                    alert('Email cannot be empty');
                    return;
                }

                var data = $('#frmModule').serialize();

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=save&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully updated', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
            
            function edit(id, tskname, tskdate, tskpriority, tskstatus){
                $('#tskname').value = tskname;
                $('#tskdate').value = tskdate;
                $('#tskpriority').value = tskpriority;
                $('#tskstatus').value = tskstatus;
                $('#id').value = id;
            }
            
            function delete(id){
                var data = 'id='+ id;

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=delete&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully deleted', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
        </script>
    </body>
</html>
