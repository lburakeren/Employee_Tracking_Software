const rowsPerPage = 15;
let currentPage = 1;
let totalRows = 0;
let allData = [];
let filteredData = null;

document.addEventListener('DOMContentLoaded', () => {
  fetchDataAndRender();
});


function fetchDataAndRender() {
  fetch('get_movements.php')
    .then(response => response.json())
    .then(data => {
      allData = data;
      totalRows = allData.length;
      filteredData = [...allData];
      renderTable(filteredData);
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
}

function renderTable(data) {
  const tableBody = document.getElementById('table-body');
  tableBody.innerHTML = '';

  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;

  data.slice(startIndex, endIndex).forEach((rowData, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${rowData.employee_id}</td>
      <td>${rowData.first_name}</td>
      <td>${rowData.last_name}</td>
      <td>${rowData.text}</td>
      <td>${rowData.in_out}</td>
      <td>${rowData.gate_name}</td>
      <td>${rowData.gate_location}</td>
      <td>${rowData.date}</td>
      <td>${rowData.time}</td>
    `;
    tableBody.appendChild(row);
  });

  updatePaginationInfo(data.length);
}


function updatePaginationInfo(dataLength) {
  const pageInfo = document.getElementById('page-info');
  const totalPages = Math.ceil(dataLength / rowsPerPage);
  pageInfo.textContent = `Sayfa ${currentPage}/${totalPages}`;
}

function goToPage(pageNumber) {
  if (pageNumber < 1) {
    pageNumber = 1;
  } else if (pageNumber > Math.ceil(filteredData.length / rowsPerPage)) {
    pageNumber = Math.ceil(filteredData.length / rowsPerPage);
  }

  currentPage = pageNumber;
  renderTable(filteredData);
}

function searchTable() {
  const searchInput = document.getElementById('search').value.toLowerCase();
  filteredData = allData.filter(rowData => {
    const text1 = rowData.first_name.toLowerCase();
    const text2 = rowData.last_name.toLowerCase();
    const text3 = rowData.text.toLowerCase();
    const text4 = rowData.in_out.toLowerCase();
    const text5 = rowData.gate_name.toLowerCase();
    const text6 = rowData.gate_location.toLowerCase();
    const text7 = rowData.date.toLowerCase();

    const text = text1 + text2 + text3 + text4 + text5 + text6 + text7;
    return text.includes(searchInput);
  });

  currentPage = 1;
  renderTable(filteredData);
}

function previousPage() {
  goToPage(currentPage - 1);
}

function nextPage() {
  goToPage(currentPage + 1);
}

function goToLastPage() {
  goToPage(Math.ceil(filteredData.length / rowsPerPage));
}
