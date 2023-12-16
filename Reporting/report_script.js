function renderTable() {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
  
    
    fetch('get_reports.php')
      .then(response => response.json())
      .then(data => {
        
        data.forEach((rowData, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${rowData.frequency}</td>
            <td>${rowData.time}</td>
            <td>${rowData.report_type}</td>
            <td>${rowData.email}</td>
            <td>
              <button onclick="deleteReport(${rowData.id})">
                <img src="delete.jpeg" alt="Delete">        
              </button>
            </td>
          `;
          tableBody.appendChild(row);
        });
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }

document.addEventListener('DOMContentLoaded', () => {
    renderTable();
});


function deleteReport(id) {
  
    fetch('execute_remove_cronjob.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ id: id }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          return fetch('delete_report.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id }),
          });
        } else {
          console.error('Error deleting cronjob:', data.error);
          throw new Error(data.error); 
        }
      })
      .then(deleteResponse => deleteResponse.json())
      .then(deleteData => {
        if (deleteData.success) {
          renderTable();
        } else {
          console.error('Error deleting report:', deleteData.error);
          throw new Error(deleteData.error); 
        }
      })
      .catch(error => {
        console.error('Error:', error);
      })


}


function addReport() {
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td>
            <select name="frequency" id="frequency">
            <option value="Her Gün">Her gün</option>
            <option value="Her Hafta içi">Haftaiçi Her gün</option>
            <option value="Her Cuma">Her Cuma</option>
            <option value="Her Ay Sonu">Her Ay Sonu</option>
            </select>
      </td>
      <td><input type="text" name="time" id="time" required><br></td>
      <td>
            <select name="report_type" id="report_type">
            <option value="dailyreport">Günlük Giriş-Çıkış Raporu </option>
            <option value="dailyreport">Günlük Giriş Raporu </option>
            <option value="dailyreport">Günlük Çıkış Raporu </option>
            </select>
      </td>
      <td><input type="text" name="email" id="email" required><br></td>
      <td>
        <button onclick="saveNewReport()">Kaydet</button>
        <button onclick="exitAddReport()">Çık</button>
      </td>
    `;
  
  
    const tableBody = document.getElementById('table-body');
    tableBody.appendChild(newRow);
  
    const addReportButton = document.getElementById('addReportButton');
    if (addReportButton) {
      addReportButton.style.display = 'none';
    }
  
  }

  function exitAddReport() {
  
    const newRow = document.querySelector('#table-body tr:last-child');
    newRow.remove();
  
    const addReportButton = document.getElementById('addReportButton');
    if (addReportButton) {
      addReportButton.style.display = 'block'; 
    }
  
    renderTable();
    
  }

  function saveNewReport() {
    const newFrequency = document.getElementById('frequency').value;
    const newTime = document.getElementById('time').value;
    const newReportType = document.getElementById('report_type').value;
    const newEmail = document.getElementById('email').value;
  
    const formData = new FormData();
    formData.append('frequency', newFrequency);
    formData.append('time', newTime);
    formData.append('report_type', newReportType);
    formData.append('email', newEmail);
  
    fetch('add_report.php', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          return fetch('execute_add_cronjob.php', {
            method: 'POST',
            body: formData,
          });
        } else {
          console.error('Error adding report:', data.error);
          throw new Error(data.error); 
        }
      })
      .then(cronjobResponse => cronjobResponse.json())
      .then(cronjobData => {
        if (cronjobData.success) {
          renderTable();
        } else {
          console.error('Error adding cronjob:', cronjobData.error);
          throw new Error(cronjobData.error); 
        }
      })
      .catch(error => {
        console.error('Error:', error);
      })
      .finally(() => {
        const addReportButton = document.getElementById('addReportButton');
        if (addReportButton) {
          addReportButton.style.display = 'block';
        }
      });

  }
  
