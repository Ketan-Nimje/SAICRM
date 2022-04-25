<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <!--print custom error message-->
    
    <?php
    if($this->session->flashdata('error')) { ?>
        <div class="m-b-15">
            <div class="alert alert-danger alert-dismissable">
                <button aria-label="Close" data-bs-dismiss="alert" class="btn-close float-end" type="button">×</button>
                <?= $this->session->flashdata('error'); ?>
            </div>
        </div>
    <?php } ?>

    <!--print custom success message-->    
    <?php
    if($this->session->flashdata('success')) { ?>
        <div class="m-b-15">
            <div class="alert alert-success alert-dismissable">
                <button aria-label="Close" data-bs-dismiss="alert" class="btn-close float-end" type="button">×</button>
                <p>
                <?= $this->session->flashdata('success'); ?>
                </p>
            </div>
        </div>
    <?php } ?>

  


