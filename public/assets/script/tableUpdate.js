function tableUpdate (data) {

  const tableColumns = [

    'SBE_title', 
    'SA_title',
    'from_before', 
    'planned_duration_check', 
    
  ]

    let dataTable = $('#example1').DataTable();
    
    dataTable.clear().draw();
    let newData = [];
    let itame = 1;

    for (const row of data) {
          
      var record = [];
      record.push(itame);
      ++itame
      for (const column of tableColumns) {
        
        if (column == 'from_before') {
          
          record.push(moment(row.planned_verification_period_from, 'YYYY-MM-DD HH:mm:ss').format('DD.MM.YYYY')+'-'+moment(row.planned_verification_period_before, 'YYYY-MM-DD HH:mm:ss').format('DD.MM.YYYY'));

          continue;
        }
        
        record.push(row[column]);
      }
          
      record.push(`
        <div class="icheck-primary d-inline">
          <input type="radio" class="radio-group" id="radioPrimary${row.id}" name="r" value="${row.id}">
          <label for="radioPrimary${row.id}"></label>
        </div>
      `);
         
      newData.push(record);  
    }
  
  dataTable.rows.add(newData).draw();
}