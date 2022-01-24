<?php  ?>

<!--print error messages-->
<?php if ($this->session->flashdata('errors')): ?>
    <div class="form-group">
        <div class="error-message mb-0">
            <?php echo $this->session->flashdata('errors'); ?>
        </div>
    </div>
<?php endif; ?>

<!--print custom error message-->
<?php if ($this->session->flashdata('error')): ?>
    <div class="form-group">
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<!--print custom success message-->
<?php if ($this->session->flashdata('success')): ?>
    <div class="form-group">
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <i class="icon-check"></i>&nbsp;
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>
