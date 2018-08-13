 
	
 <script type="text/javascript">
   var items= {};
 </script>
   

 
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
                    <h2>Manage Financial Reports<small></small></h2>
                        <div class="pull-right">
                           <a href="finance/create"><button class="btn btn-primary">Create</button></a>
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
				  
                    <table  id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Actions</th>  
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

             
			$.ajax({
                url: '<?php echo base_url(); ?>index.php/admin/finance/paginate?pageNum='+aoData[3].value+'&pageSize='+aoData[4].value+'',
                type: 'GET',
				dataType: 'JSON',
                
                
                success: function (data) {
                  items = data;
		           fnCallback(data);
                }
            });



		},
                "aoColumns": [
                 
                     {
                        "mData": "title"
                       // "bSortable": false,
                         //"defaultContent":"",
                    },                  
			             		{
                        "bSortable" : false,
                        "render": function (data, type, row) {

                            return '<a><button class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="viewItem('+row.id+')" > View</button></a>'+
                            ''+
                            '<a href="finance/delete/'+row.id+'" onclick="return confirmDelete()" ><button class="btn btn-danger">Delete</button></a>';
                         }
                    }
              ]
            });
        });
        function pad(n) {
            return n < 10 ? "0" + n : n;
        }

    </script>

    <script type="text/javascript">

    function confirmDelete(){
      var result = confirm("Are you sure ?");
      if (result) {
         return true;
      }
      return false;
    }



     function viewItem(itemId){
      
       $('#myModalLabel').html('');
       $('#myModalBody').html('');

        for(var i=0; i< items['data'].length; i++){
            if(items['data'][i].id == itemId){
              $('#myModalLabel').html('<h2>'+items['data'][i].title+'</h2>');
                $('#myModalBody').append('<h4> Author </h4><div>'+items['data'][i].author+'</div>');
                $('#myModalBody').append('<h4> Source </h4><div><a target="_blank" class="btn btn-default" href="'+items['data'][i].source+'">Download</a></div>');
              
              $('#myModalBody').append('<div class="clearfix"> </div>');
            }
        }

      }
      
    </script>

 
	
	   <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />





                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div class="modal-body" id="myModalBody">
                         
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                        </div>

                      </div>
                    </div>
                  </div>
  
   