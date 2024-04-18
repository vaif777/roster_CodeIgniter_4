<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Форма редоктирования</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                    <?php
                    $errors_data = session()->has('errors') ? esc(session()->getFlashdata('errors')) : [];
                    ?>

                        <form action="<?= route_to('roster.update', $roster['id']) ?>" method="post" >
                        <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label>Выберите СМП *</label>
                                        <?= display_error($errors_data, 'small_business_entity'); ?>
                                        <select class="form-control <?= add_error_class($errors_data, 'small_business_entity_id'); ?> select2" name="small_business_entity_id" style="width: 100%;">
                                        <option></option>
                                        <?php foreach ($smallBusinessEnties as $smallBusinessEntity): ?>
                                            <?php if ($smallBusinessEntity['id'] == $roster['small_business_entity_id']): ?>
                                                <option value="<?= $smallBusinessEntity['id'] ?>" selected="selected"><?= $smallBusinessEntity['title'] ?></option>
                                            <?php endif; ?>
                                            <option value="<?= $smallBusinessEntity['id'] ?>"><?= $smallBusinessEntity['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= display_error($errors_data, 'small_business_entity_id'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Период проверки с *</label>
                                        <div class="input-group date" id="from" data-target-input="nearest">
                                            <input type="text" name="planned_verification_period_from" class="form-control <?= add_error_class($errors_data, 'planned_verification_period_from'); ?> datetimepicker-input" data-target="#from" value="<?= date('d.m.Y', strtotime($roster['planned_verification_period_from'])) ?>" />
                                            <div class="input-group-append" data-target="#from"  data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <?= display_error($errors_data, 'planned_verification_period_from'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Период проверки по *</label>
                                        <div class="input-group date" id="before" data-target-input="nearest">
                                            <input type="text" name="planned_verification_period_before" class="form-control <?= add_error_class($errors_data, 'planned_verification_period_before'); ?> datetimepicker-input" data-target="#before" value="<?= date('d.m.Y',strtotime($roster['planned_verification_period_before'])) ?>" />
                                            <div class="input-group-append" data-target="#before" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <?= display_error($errors_data, 'planned_verification_period_before'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Контролирующий орган *</label>
                                    <select class="form-control <?= add_error_class($errors_data, 'supervisory_authority_id'); ?> select2" name="supervisory_authority_id" style="width: 100%;">
                                        <option></option>
                                        <?php foreach ($supervisoryAuthorities as $supervisoryAuthority): ?>
                                            <?php if ($supervisoryAuthority['id'] == $roster['supervisory_authority_id']): ?>
                                                <option value="<?= $supervisoryAuthority['id'] ?>" selected="selected"><?= $supervisoryAuthority['title'] ?></option>
                                            <?php endif; ?>
                                            <option value="<?= $supervisoryAuthority['id'] ?>"><?= $supervisoryAuthority['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= display_error($errors_data, 'supervisory_authority_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Плановая длительность проверки *</label>
                                    <input type="input" name="planned_duration_check" class="form-control <?= add_error_class($errors_data, 'planned_duration_check'); ?>" placeholder="Длительность проверки" value="<?= $roster['planned_duration_check']?>">
                                    <?= display_error($errors_data, 'planned_duration_check'); ?>
                                </div>
                            </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Редоктировать</button>
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
<!-- date-range-picker -->
<script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

    })

    $(document).ready(function() {
    // Инициализация DateTimePicker
    $('#from, #before').datetimepicker({
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

<?= $this->endSection() ?>