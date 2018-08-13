 
  
 <script type="text/javascript">
   var newsItem= {};
 </script>

  
 <style type="text/css">
   .thumbnail {
    max-height: 67px;
} 
.thumbnail .image {
   max-height: 67px;
}
 </style>   
  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />
 
 <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $title; ?> <small></small></h3>
              
              </div>

           
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Aplications<small></small></h2>
                        <div class="pull-right">
                        <a href="transcript/locations"><button class="btn btn-primary">Locations</button></a>
                           <a href="transcript/create"><button class="btn btn-primary">Create Location</button></a>
                        </div>
                      <div class="clearfix"></div>

                 <?php 
                  if(isset($error)){
                    ?>

                       <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $error; ?> </strong>
                  </div>

                  <?php } ?>
                
                 <?php 
                  if(isset($success)){
                    ?>

                       <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $success; ?> </strong>
                  </div>

                  <?php } ?>


                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
            
                    </p>
          
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Location</th>
                          <th>Username</th>
                          <th>Price</th>
                          <th>Date</th>
                        </tr>
                      </thead>


                      <tbody>
       
                       
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

               
       </div>
          </div>
        </div>
    

  
  


  
          <!-- Datatables -->
    <script type="text/javascript">
           $(document).ready(function () {

  
            $("#datatable").dataTable({
                 "dom": '<"top"i>rt<"bottom"p><"clear">',
                "searching":false,
                "bServerSide": true,
                "iDisplayLength": 10,
                "aLengthMenu": [[5, 10, 25, 50, 75, 100], [5, 10, 25, 50,75, 100]],
                "iDisplayStart": 0,
                "sAjaxDataProp": "data", 
                 "fnServerData": function ( sSource, aoData, fnCallback ) {

               console.log(sSource);
               console.log(aoData);
  

      $.ajax({
                url: '<?php echo base_url(); ?>index.php/admin/transcript/paginate?pageNum='+aoData[3].value+'&pageSize='+aoData[4].value+'',
                type: 'GET',
        dataType: 'JSON',
                
                
                success: function (data) {
                  newsItems = data;
               fnCallback(data);
                }
            });



    },
                "aoColumns": [
                 
                     {
                        "mData": "loc_name",
                        "bSortable": false,
                        "sWidth": "20%"
                    },
                    {
                        "mData": "username",
                        "bSortable": false,
                        "defaultContent":"",
                        "sWidth": "20%"
                    },
                    {
                        "mData": "price",
                        "bSortable": false,
                        "defaultContent":"",
                        "sWidth": "10%"
                    },
                    {
                        "mData": "last_modified_date",
                        "bSortable": false,
                        "defaultContent":"",
                        "sWidth": "10%"
                    } 
                ]
            });
        });
        function pad(n) {
            return n < 10 ? "0" + n : n;
        }

    </script>

     


 