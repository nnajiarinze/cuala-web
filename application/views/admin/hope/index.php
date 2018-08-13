 
	
 <script type="text/javascript">
   var eventItems= {};
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
                    <h2>Manage Hope Events<small></small></h2>
                        <div class="pull-right">
                           <a href="hope/create"><button class="btn btn-primary">Create</button></a>
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
                          <th>Title</th>
                          <th>Service</th>
                          <th>Location</th>
                          <th>Date</th>
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

               console.log(sSource);
               console.log(aoData);
  

			$.ajax({
                url: '<?php echo base_url(); ?>index.php/admin/hope/paginate?pageNum='+aoData[3].value+'&pageSize='+aoData[4].value+'',
                type: 'GET',
				dataType: 'JSON',
                
                
                success: function (data) {
                  eventItems = data;
		           fnCallback(data);
                }
            });



		},
                "aoColumns": [
                 
                     {
                        "mData": "title",
                        "bSortable": false
                    },  {
                        "mData": "name",
                        "bSortable": false
                    },
                    {
                        "mData": "location",
                        "bSortable": false,
                        "defaultContent":""
                    },
                    {
                        "mData": "date",
                        "bSortable": false,
                        "defaultContent":""
                    },
                   
					           {
                        "bSortable" : false,
                        "render": function (data, type, row) {

                            return '<a><button class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="viewItem('+row.id+')">View</button></a>'+
                            '<a href="hope/edit/'+row.id+'"><button class="btn btn-dark">Edit</button></a>'+
                            '<a href="hope/delete/'+row.id+'" onclick="return confirmDelete()" ><button class="btn btn-danger">Delete</button></a>';
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

        for(var i=0; i< eventItems['data'].length; i++){
            if(eventItems['data'][i].id == itemId){
              $('#myModalLabel').html('<h2>'+eventItems['data'][i].title+'</h2>');
              $('#myModalBody').append('<h4> Location </h4><div>'+eventItems['data'][i].location+'</div>');
              $('#myModalBody').append('<h4> Date </h4><div>'+eventItems['data'][i].date+'</div>');
              $('#myModalBody').append('<h4> Description </h4><div>'+eventItems['data'][i].description+'</div>');
              $('#myModalBody').append('<h4> Created Date </h4><div>'+eventItems['data'][i].created_date+'</div>');
            
              $('#myModalBody').append('<h4> Image(s) </h4>');
              var images = eventItems['data'][i].image.split(',');
               $('#myModalBody').append(' <div class="row">');
              for(var j=0; j< images.length; j++){
                if(images[j]){


                $('#myModalBody').append('<div class="col-md-55">'
                           +'<div class="thumbnail">'
                              +' <div class="image view view-first">'
                               +'  <img style="width: 100%; display: block;" src="'+images[j]+'" alt="image" />'
                              +' </div>'
                             +'</div>'
                           +'</div>');
              }
              }
                 $('#myModalBody').append('</div>');
                 $('#myModalBody').append('<div class="clearfix"> </div>');
            }
        }

      }
    </script>




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
	
	 