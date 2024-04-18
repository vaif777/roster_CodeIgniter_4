<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>

<section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Выберите СМП *</label>
                        <select class="form-control select2" id="smallBusinessEntityTitle" style="width: 100%;">
                            <option value="" selected="selected">Выберите СМП</option>
                            <?php foreach ($smallBusinessEnties as $smallBusinessEntity): ?>
                                <option value="<?= $smallBusinessEntity['id'] ?>"><?= $smallBusinessEntity['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Период проверки с *</label>
                        <div class="input-group date" id="from" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input"data-target="#from" />
                            <div class="input-group-append" data-target="#from"  data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Период проверки по *</label>
                        <div class="input-group date" id="before" data-target-input="nearest">
                            <input type="text" name="planned_verification_period_before" class="form-control datetimepicker-input"data-target="#before"/>
                            <div class="input-group-append" data-target="#before" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Контролирующий орган *</label>
                        <select class="form-control select2" id="supervisoryAuthorityTitle" style="width: 100%;">
                            <option value="" selected="selected">Выберите контролирующий орган</option>
                            <?php foreach ($supervisoryAuthorities as $supervisoryAuthority): ?>
                                <option value="<?= $supervisoryAuthority['id'] ?>"><?= $supervisoryAuthority['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Плановая длительность проверки *</label>
                        <input type="input" id="plannedDurationCheck" class="form-control" placeholder="Длительность проверки">
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" id="buttonFilter" class="btn btn-secondary btn-lg">Показать</button> 
                </div>
            </div>
          </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Перечень плановых проверок</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <a href="<?= route_to('roster.new') ?>" class="btn btn-success mb-3 mr-2">+ Добавить</a>
                    <a href="<?= route_to('roster.new.excel') ?>" class="btn btn-success mb-3">+ Добавить excel</a>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="action" class="form-control select2" style="width: 100%;" disabled>
                                <option value="" selected>Выберите действие</option>
                                <option value="<?= base_url('roster/edit') ?>">Редактировать</option>
                                <option value="<?= base_url('roster/delete') ?>">Удалить</option>
                            </select>
                        </div>
                    </div>
                    <a id="buttonAction" class="btn btn-primary mb-3">Выполнить</a>    
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>№</th>
                    <th>Cубъект малого предпринимательства</th>
                    <th>Контролирующая организация</th>
                    <th>Плановый период проверки</th>
                    <th>Плановая длительность проверки</th>
                    <th>Выбор</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rosters as $roster): ?>
                  <tr>
                    <td><?= $item ?></td>
                    <td><?= $roster['SBE_title'] ?></td>
                    <td><?= $roster['SA_title'] ?></td>
                    <td><?= date('d.m.Y', strtotime($roster['planned_verification_period_from'])) ?>-<?= date('d.m.Y',strtotime($roster['planned_verification_period_before'])) ?></td>
                    <td><?= $roster['planned_duration_check'] ?></td>
                    <td>
                        <div class="icheck-primary d-inline">
                            <input type="radio" class="radio-group" id="radioPrimary<?= $roster['id'] ?>" name="r" value="<?= $roster['id'] ?>">
                            <label for="radioPrimary<?= $roster['id'] ?>">
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
                    <th>Cубъект малого предпринимательства</th>
                    <th>Контролирующая организация</th>
                    <th>Плановый период проверки</th>
                    <th>Плановая длительность проверки</th>
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
<!-- date-range-picker -->
<script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- tableUpdate -->
<script src="<?= base_url('assets/script/tableUpdate.js') ?>"></script> 



<script>

$(document).ready(function() {

    $('.select2').select2()

    var table = $('#example1').DataTable({
        language: {
            buttons: {
                copy: "Копировать",
                csv: "CSV",
                excel: "Excel",
                pdf: "PDF",
                print: "Печать",
                colvis: "Столбцы"
            },
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
        scrollCollapse: true, 
        scrollXInner: '100%',
        buttons: [
            
            {
                extend: "copy",
                exportOptions: {
                    columns: ':not(:last-child):visible'
                }
            }, 
            {
                extend: "csv",
                exportOptions: {
                    columns: ':not(:last-child):visible'
                }
            }, 
            {
                extend: "excel",
                exportOptions: {
                    columns: ':not(:last-child):visible'
                }
            }, 
            {
                extend: "pdf",
                exportOptions: {
                    columns: ':not(:last-child):visible'
                }
            }, 
            {
                extend: "print",
                exportOptions: {
                    columns: ':not(:last-child):visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Столбцы',
                columns: ':not(:last-child)'
            }
        ]
    });
    
    table.buttons().container().appendTo($('#example1_wrapper .col-md-6:eq(0)'));

     // Инициализация DateTimePicker
    $('#before, #from').datetimepicker({
        format: 'DD.MM.YYYY',
        locale: 'ru' // Установка русского языка
    });

    // Исправленная инициализация локали Moment.js
    moment.updateLocale('ru', {
        months : 'Январь_Февраль_Март_Апрель_Май_Июнь_Июль_Август_Сентябрь_Октябрь_Ноябрь_Декабрь'.split('_'),
        monthsShort : 'янв._фев._мар._апр._май_июн._июл._авг._сен._окт._ноя._дек.'.split('_'),
        weekdays : 'Воскресенье_Понедельник_Вторник_Среда_Четверг_Пятница_Суббота'.split('_'),
        weekdaysShort : 'Вс_Пн_Вт_Ср_Чт_Пт_Сб'.split('_'),
        weekdaysMin : 'Вс_Пн_Вт_Ср_Чт_Пт_Сб'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY г.',
            LLL : 'D MMMM YYYY г., HH:mm',
            LLLL : 'dddd, D MMMM YYYY г., HH:mm'
        },
        calendar : {
            sameDay: '[Сегодня в] LT',
            nextDay: '[Завтра в] LT',
            lastDay: '[Вчера в] LT',
            nextWeek: 'dddd [в] LT',
            lastWeek: 'dddd [в] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'через %s',
            past : '%s назад',
            s : 'несколько секунд',
            ss : '%d секунд',
            m : 'минута',
            mm : '%d минут',
            h : 'час',
            hh : '%d часов',
            d : 'день',
            dd : '%d дней',
            M : 'месяц',
            MM : '%d месяцев',
            y : 'год',
            yy : '%d лет'
        },
        dayOfMonthOrdinalParse: /\d{1,2}-(й|го|я)/,
        ordinal : function (number, period) {
            switch (period) {
                case 'M':
                case 'd':
                case 'DDD':
                    return number + '-й';
                case 'D':
                    return number + '-го';
                case 'w':
                case 'W':
                    return number + '-я';
                default:
                    return number;
            }
        },
        week : {
            dow : 1, // День начала недели (0 - Воскресенье, 1 - Понедельник, ...)
            doy : 4  // День, используемый для первой недели года
        }
    });
});
</script>

<script>

$(document).ready(function(){

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

function fetchData(url, params, callback) {
$.ajax({
  method: "GET",
  url: url,
  data: params,
})
.done(callback);
}

$(document).ready(function () {
    $('#buttonFilter').on('click', function () {

        const url = '<?= base_url(route_to('api.search')) ?>';
        const params = {

            smallBusinessEntityId: $('#smallBusinessEntityTitle').val(),
            from: $('#from').datetimepicker('date') ? $('#from').datetimepicker('date').format('YYYY-MM-DD HH:mm:ss') : '',
            before: $('#before').datetimepicker('date') ? $('#before').datetimepicker('date').format('YYYY-MM-DD HH:mm:ss') : '',
            supervisoryAuthorityId: $('#supervisoryAuthorityTitle').val(),
            plannedDurationCheck: $('#plannedDurationCheck').val()
        };

        fetchData(url, params, function (data) {

            tableUpdate (data); 
        });
    });
});
</script>

<?= $this->endSection() ?>