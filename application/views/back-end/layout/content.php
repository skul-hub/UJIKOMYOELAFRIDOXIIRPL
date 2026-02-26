<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">

        <?php
        if (isset($page)) {
            $this->load->view($page);
        }
        ?>

    </div>
</div>
