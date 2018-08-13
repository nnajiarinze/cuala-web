 
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
//bkLib.onDomLoaded(nicEditors.allTextAreas);

 bkLib.onDomLoaded(function() {

        new nicEditor({buttonList : ['fontSize','bold','italic','underline','left','center','strikeThrough','subscript','superscript','html']}).panelInstance('description');
       
  });

  </script>
            
 
	<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URI.'css/jquery.datetimepicker.css'; ?>"/>
  <script type="text/javascript" src="<?php echo ASSETS_URI.'js/jquery.datetimepicker.full.min.js'; ?>"></script>
 
 <!-- page content -->
   <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Events</h3>
              </div>
 
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Create<small>new</small></h2>
                   
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

              <?php $attributes = array('class' => 'form-horizontal form-label-left', 'id' => 'createForm','novalidate'=>'novalidate','method'=> "POST");
              echo form_open_multipart('admin/hope/create', $attributes);

              ?>
                  <!--  <form class="form-horizontal form-label-left" id="createForm" novalidate action="sub" method="POST"> -->


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="title" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="title" placeholder="title" required="required" type="text" >
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service_id">Category<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="service_id" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="service_id" placeholder="service_id" required="required">
                               <?php 
                                  foreach($services as $category){
                              ?>
                              <option value="<?php echo $category['id']; ?>"><?php echo $category['name'];?></option>

                              <?php
                                  }
                               ?>
                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location">Location <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="location" name="location" required="required"  placeholder="location" class="form-control col-md-7 col-xs-12"  >
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="description" required="required" name="description" rows="15" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="date" name="date" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Images
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="image" type="file" multiple name="image[]" class="optional form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                     
                    
                     
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <input id="send" type="submit" name="submit" class="btn btn-success" value="Submit" />
                        </div>
                      </div>
                    <!--</form>-->
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
   
		

	
	
 <script src="<?php echo ASSETS_URI.'vendors/validator/validator.js'; ?>"></script>


	
			    <!-- Datatables -->
    <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit){

           //$('#createForm').submit();
           return true;
        }

        return false;
      });
    </script>
    <!-- /validator -->
	
	 <script type="text/javascript">
   $('#date').datetimepicker({ minDate:0});
   </script>