 <?php $__env->startSection('content'); ?>

<?php if($errors->has('name')): ?>
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<!-- Trigger the modal with a button -->
<section>
    <div class="container-fluid">
      <div class="input-group">
          <div class="input-group-prepend">
                <a href="" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Category')); ?></a>
                &nbsp;&nbsp;
                <a href="#" data-toggle="modal" data-target="#import-category" class="btn btn-primary"><i class="fa fa-file"></i> <?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Category')); ?> <?php echo e(trans('file.By')); ?> CSV</a>
          </div>    
        </div>
    </div> 

  <table id="category-table" class="table table-hover">
    <thead>
        <tr>
            <th class="not-exported"></th>
            <th><?php echo e(trans('file.Category')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $lsms_category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key); ?></td>
            <td><?php echo e($category->name); ?></td>
            <td>
                <div class="btn-group">
                    <button type="button" data-id="<?php echo e($category->id); ?>" class="open-EditCategoryDialog btn btn-primary" data-toggle="modal" data-target="#editModal" title="Edit"><i class="fa fa-edit"></i>
                        </button>
                    <?php echo e(Form::open(['route' => ['category.destroy', $category->id], 'method' => 'DELETE'] )); ?>

                    <button type="submit" class="btn btn-danger" onclick="return confirmDelete()" title="Delete"> <i class="fa fa-times"></i></button> 
                    <?php echo e(Form::close()); ?>

                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    <?php echo Form::open(['route' => 'category.store', 'method' => 'post']); ?>

    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Add')); ?> <?php echo e(trans('file.Category')); ?></h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p class="italic"><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
      <form>
        <div class="form-group">
          <label><strong><?php echo e(trans('file.Name')); ?> *</strong></label>
          <input type="text" name="name" required="required" class="form-control">
        </div>                
        <div class="form-group">       
          <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
        </div>
      </form>
    </div>

    <?php echo e(Form::close()); ?>

  </div>
</div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    <?php echo Form::open(['route' => ['category.update',1], 'method' => 'put']); ?>

    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Update')); ?> <?php echo e(trans('file.Category')); ?></h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
      <p class="italic"><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
        <div class="form-group">
            <input type="hidden" name="category_id">
          <label><strong><?php echo e(trans('file.Name')); ?> *</strong></label>
          <input type="text" name="name" required="required" class="form-control" />
          <input type="hidden" name="category_id" />
        </div>                
        <div class="form-group">       
          <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

  </div>
</div>
</div>

<div id="import-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
<div role="document" class="modal-dialog">
  <div class="modal-content">
    <?php echo Form::open(['route' => 'category.import', 'method' => 'post', 'files' => true]); ?>

    <div class="modal-header">
      <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Import')); ?> <?php echo e(trans('file.Category')); ?></h5>
      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <p><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</p>
       <p><?php echo e(trans('file.The correct column order is')); ?> (name*) <?php echo e(trans('file.and you must follow this')); ?>. <?php echo e(trans('file.Every Category Name must be unique')); ?>.</p>

        <label><strong><?php echo e(trans('file.Upload CSV File')); ?> *</strong></label>
        <div class="form-group">
            <?php echo e(Form::file('file', array('class' => 'form-control', 'required'))); ?>

        </div>
        <div class="form-group" id="operation_value"></div>
        <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
    </div>
    <?php echo e(Form::close()); ?>

  </div>
</div>
</div>

<script type="text/javascript">
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(0).addClass("active");

  $('#category-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 2]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );
  
    function confirmDelete() {
      if (confirm("If you delete this category all the products under this category will also be deleted! Are you sure want to delete?")) {
          return true;
      }
      return false;
    }
$(document).ready(function() {
    $('.open-EditCategoryDialog').on('click', function(){
      var url ="category/"  
      var id = $(this).data('id').toString();
      url = url.concat(id).concat("/edit");
      
      $.get(url, function(data){
        $("input[name='name']").val(data['name']);
        $("input[name='category_id']").val(data['id']);
      });
    });
})
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>