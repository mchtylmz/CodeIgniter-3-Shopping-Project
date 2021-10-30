<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!--print error messages-->
<?php if ($this->session->flashdata('errors')): ?>
    <div class="form-group">
        <div class="error-message">
            <?php echo $this->session->flashdata('errors'); ?>
        </div>
    </div>
<?php endif; ?>

    <!--print custom error message-->
<?php if ($this->session->flashdata('error')): ?>
    <div class="m-b-15">
        <div class="alert alert-danger alert-dismissable" style="display:block; padding: 2px 25px 2px 0">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="color:white">×</button>
            <h5>
                <i class="icon fa fa-times"></i>
                <?php echo $this->session->flashdata('error'); ?>
            </h5>
        </div>
    </div>
<?php endif; ?>

    <!--print custom success message-->
<?php if ($this->session->flashdata('success')): ?>
    <div class="m-b-15">
        <div class="alert alert-success alert-dismissable" style="display:block; padding: 2px 25px 2px 0">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="color:white">×</button>
            <h5>
                <i class="icon fa fa-check"></i>
                <?php echo $this->session->flashdata('success'); ?>
            </h5>
        </div>
    </div>
<?php endif; ?>
