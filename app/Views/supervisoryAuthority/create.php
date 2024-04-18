<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Форма добавления</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                    <?php
                    $errors_data = session()->has('errors') ? esc(session()->getFlashdata('errors')) : [];
                    ?>

                    <form action="<?= route_to('supervisory.authority.create') ?>" method="post" >
                    <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Наиминование *</label>
                                    <input type="input" name="title" class="form-control <?= add_error_class($errors_data, 'title'); ?>" placeholder="Наиминование" value="<?= old('title'); ?>" >
                                    <?= display_error($errors_data, 'title'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">+ Добавить</button>
                            </div>
                        </div>
                    <form>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<?= $this->endSection() ?>