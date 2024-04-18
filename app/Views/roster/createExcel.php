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
                        <small class="float-right"><a href="<?= base_url('assets/files/shablon.xlsx') ?>" class="btn btn-block btn-primary btn-sm">Скачать шаблон</a></small>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?= route_to('roster.create.excel') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Загрузить файл</label>
                                        <input type="file" name="excel_file" class="form-control-file" id="exampleFormControlFile1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">+ Добавить</button>
                                    </div>
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