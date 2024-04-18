<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>

<!-- Main content -->
<section class="content mt-2">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Реестр контролирующий орган</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <a href="<?= route_to('supervisory.authority.new') ?>" class="btn btn-success mb-3 mr-2">+ Добавить</a>  
                    <div class="col-md-8">
                        <div class="form-group">
                            <select id="action" class="form-control select2" style="width: 100%;" disabled>
                                <option value="" selected>Выберите действие</option>
                                <option value="<?= base_url('supervisory-authority/edit') ?>">Редактировать</option>
                                <option value="<?= base_url('supervisory-authority/delete') ?>">Удалить</option>
                            </select>
                        </div>
                    </div>
                    <a id="buttonAction" class="btn btn-primary mb-3">Выполнить</a>    
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Выбор</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($supervisoryAuthorities as $supervisoryAuthority): ?>
                  <tr>
                    <td><?= $item ?></td>
                    <td><?= $supervisoryAuthority['title'] ?></td>
                    <td>
                        <div class="icheck-primary d-inline">
                            <input type="radio" class="radio-group" id="radioPrimary<?= $supervisoryAuthority['id'] ?>" name="r" value="<?= $supervisoryAuthority['id'] ?>">
                            <label for="radioPrimary<?= $supervisoryAuthority['id'] ?>">
                            </label>
                        </div>
                    </td>
                  </tr>
                  <?php ++$item ?>
                  <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Выбор</th>
                  </tr>
                  </tfoot>
                </table>
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

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/jszip/jszip.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js')?>"></script>

<script>

$(document).ready(function() {
    var table = $('#example1').DataTable({
        language: {
            emptyTable: "Нет данных для отображения",
            info: "Отображение записей с _START_ по _END_ из _TOTAL_",
            infoEmpty: "Показано 0 из 0 записей",
            infoFiltered: "(отфильтровано из _MAX_ записей)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Отображать _MENU_ записей на странице",
            loadingRecords: "Загрузка...",
            processing: "Обработка...",
            search: "Поиск:",
            zeroRecords: "Ничего не найдено",
            paginate: {
                first: "Первая",
                last: "Последняя",
                next: "Следующая",
                previous: "Предыдущая"
            },
            aria: {
                sortAscending: ": активировать для сортировки столбца по возрастанию",
                sortDescending: ": активировать для сортировки столбца по убыванию"
            }
        },
        paging: true,
        searching: true,
        scrollX: true,
        scrollCollapse: true, 
        scrollXInner: '100%',
    });
    
    table.buttons().container().appendTo($('#example1_wrapper .col-md-6:eq(0)'));

    //Initialize Select2 Elements
    $('.select2').select2()
});
</script>

<script>

$(document).ready(function(){

    // Повесить обработчик события на все radio button с классом .radio-group
    $('#example1').on('change', '.radio-group', function(){

        const value = $(this).val(); 
        $('#action').prop('disabled', false);

        $('#action').val('');
        $('#action').select2('destroy').select2();

        $('#buttonAction').removeAttr('href');

        $('#action option').val(function(index, currentValue) {
        
            if (index != 0) {
                
            if (currentValue.match(/\/\d+$/)) {
            // Найти индекс последнего вхождения символа '/'
                var lastIndex = currentValue.lastIndexOf('/');

                // Получить подстроку до последнего вхождения '/'
                var resultString = currentValue.substring(0, lastIndex);
            } else {

                resultString = currentValue;
            }
                var newValue = resultString +'/'+ value;
                return newValue;
            }
        });
    });

    $('#action').on('change', function(){

        const value = $(this).val();
        $('#buttonAction').attr('href', value);
        
    });

    $('#buttonAction').click(function(event){
        
        var title = $('#action option:selected').text();

        if( title == 'Удалить' ) {

            var result = confirm('Вы точно хотите удалить данную запись?');
        
            if (result) {

                return true;
            } else {
            
                event.preventDefault();
                return false;
            }
        }
    });
});
</script>

<?= $this->endSection() ?>