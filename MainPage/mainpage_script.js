function renderTable() {
  const tableBody = document.getElementById('table-body');
  tableBody.innerHTML = '';

  fetch('get_active_gates.php')
    .then(response => response.json())
    .then(data => {
      if (data.error && data.error === 'No gates authenticated') {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td style="visibility: hidden;">Hiçbir Kapı Aktif Değil</td>
          <td>Hiçbir Kapı Aktif Değil</td> 
          <td style="visibility: hidden;">Hiçbir Kapı Aktif Değil</td>  
        `;
        tableBody.appendChild(row);
      } else {
        data.forEach((rowData, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${rowData.gate_id}</td>
            <td>${rowData.gate_name}</td>
            <td>${rowData.gate_location}</td>
          `;
          tableBody.appendChild(row);
        });
      }
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
  renderTable();
});