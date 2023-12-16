const rowsPerPage = 5;
let currentPage = 1;
let totalRows = 0;
let allData = [];
let filteredData = null;

document.addEventListener('DOMContentLoaded', () => {
  fetchDataAndRender();
});


function fetchDataAndRender() {
  fetch('get_employees.php')
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
        <td>${rowData.dept_text}</td>
        <td><img src="EmployeePics/${rowData.picture_name}" alt="Employee Photo" id="employeePhoto${rowData.employee_id}" width="50" height="50"></td>
        <td>
          <button onclick="editEmployee(${rowData.employee_id})" id="editButton${rowData.employee_id}"><image src="edit.jpeg"></button>
          <button onclick="deleteEmployee(${rowData.employee_id})">
          <img src="delete.jpeg" alt="Delete">        
          </button>
        </td>
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
  } else if (pageNumber > Math.ceil(filteredData.length  / rowsPerPage)) {
    pageNumber = Math.ceil(filteredData.length  / rowsPerPage);
  }

  currentPage = pageNumber;
  renderTable(filteredData);
}

function previousPage() {
  goToPage(currentPage - 1);
}

function nextPage() {
  goToPage(currentPage + 1);
}

function goToLastPage() {
  goToPage(Math.ceil(filteredData.length  / rowsPerPage));
}


function searchTable() {
  const searchInput = document.getElementById('search').value.toLowerCase();
  filteredData = allData.filter(rowData => {
    const text1 = rowData.first_name.toLowerCase();
    const text2 = rowData.last_name.toLowerCase();
    const text3 = rowData.dept_text.toLowerCase();

    const text = text1 + text2 + text3 ;
    return text.includes(searchInput);
  });

  currentPage = 1;
  renderTable(filteredData);
}




function deleteEmployee(employeeId) {
  console.log('Deleting employee with ID:', employeeId);
 
  fetch('delete_employee.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ employee_id: employeeId }),
  })
    .then(response => response.json())
    .then(data => {
      
      if (data.success) {
        fetchDataAndRender();
      } else {
        console.error('Error deleting employee:', data.error);
      }

    })
    .catch(error => {
      console.error('Error deleting employee:', error);
    });
}



function addEmployee() {
  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td><input type="number" id="newEmployeeId"></td>
    <td><input type="text" id="newFirstName"></td>
    <td><input type="text" id="newLastName"></td>
    <td>
      <select id="newDeptId">
        <option value=1>Ofis Çalışanı</option>
        <option value=2>Üretim Çalışanı</option>
        <!-- Add other options here if needed -->
      </select>
    </td>
    <td>
    <input type="file" accept="image/*" id="EmployeePhotoInput" name="employee_photo">
    </td>
    <td>
      <button onclick="saveNewEmployee()">Save</button>
      <button onclick="exitAddEmployee()">Exit</button>
    </td>
  `;


  const tableBody = document.getElementById('table-body');
  tableBody.appendChild(newRow);

  const addEmployeeButton = document.getElementById('addEmployeeButton');
  if (addEmployeeButton) {
    addEmployeeButton.style.display = 'none';
  }

}

function exitAddEmployee() {
  
  const newRow = document.querySelector('#table-body tr:last-child');
  newRow.remove();

  const addEmployeeButton = document.getElementById('addEmployeeButton');
  if (addEmployeeButton) {
    addEmployeeButton.style.display = 'block'; 
  }

  fetchDataAndRender();
  
}

function saveNewEmployee(){
  const newEmployeeId = document.getElementById('newEmployeeId').value;
  const newFirstName = document.getElementById('newFirstName').value;
  const newLastName = document.getElementById('newLastName').value;
  const newDeptId = document.getElementById('newDeptId').value;


  const fileInput = document.getElementById('EmployeePhotoInput');
  

  const formData = new FormData();
  formData.append('employee_id', newEmployeeId);
  formData.append('first_name', newFirstName);
  formData.append('last_name', newLastName);
  formData.append('dept_id', newDeptId);
  formData.append('employee_photo', fileInput.files[0]);

  
  fetch('add_employee.php', {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(data => {
    
    if (data.success) {
      fetchDataAndRender();
    } else {
      console.error('Error adding employee:', data.error);
    }

  })
  .catch(error => {
    console.error('Error adding employee:', error);
  });

  const addEmployeeButton = document.getElementById('addEmployeeButton');
  if (addEmployeeButton) {
    addEmployeeButton.style.display = 'block'; 
  }

}


function editEmployee(employeeId) {
  console.log('Editing employee with ID:', employeeId);

  
  const row = document.querySelector(`#editButton${employeeId}`).parentNode.parentNode;
  const cells = row.getElementsByTagName('td');

  
  const employeeData = {
    employee_id: cells[0].textContent,
    first_name: cells[1].textContent,
    last_name: cells[2].textContent,
    dept_text: cells[3].textContent,
  };

  
  const formRow = document.createElement('tr');
  formRow.innerHTML = `
    <td><input type="number" value="${employeeData.employee_id}" id="editEmployeeId"></td>
    <td><input type="text" value="${employeeData.first_name}" id="editFirstName"></td>
    <td><input type="text" value="${employeeData.last_name}" id="editLastName"></td>
    <td>
      <select id="editDeptId">
        <option value="2" ${employeeData.dept_text === "Üretim Çalışanı" ? "selected" : ""}>Üretim Çalışanı</option>
        <option value="1" ${employeeData.dept_text === "Ofis Çalışanı" ? "selected" : ""}>Ofis Çalışanı</option>
      </select>
    </td>
    <td>
      <input type="file" accept="image/*" id="EmployeePhotoInput" name="employee_photo">
    </td>
    <td>
      <button onclick="saveEditedEmployee(${employeeId})">Save</button>
      <button onclick="renderTable()">Exit</button>
    </td>
  `;

 
  row.parentNode.replaceChild(formRow, row);


}


function saveEditedEmployee(employeeId) {
  const editedEmployeeId = document.getElementById('editEmployeeId').value;
  const editedFirstName = document.getElementById('editFirstName').value;
  const editedLastName = document.getElementById('editLastName').value;
  const editedDeptId = document.getElementById('editDeptId').value;

  const fileInput = document.getElementById('EmployeePhotoInput');
  
  

  const formData = new FormData();
  formData.append('employee_id', editedEmployeeId);
  formData.append('first_name', editedFirstName);
  formData.append('last_name', editedLastName);
  formData.append('dept_id', editedDeptId);
  formData.append('employee_photo', fileInput.files[0]);
  formData.append('old_employee_id',employeeId);



  fetch('update_employee.php', {
    method: 'POST',
    body: formData ,
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      fetchDataAndRender();
    } else {
      console.error('Error updating employee:', data.error);
    }
  })
  .catch(error => {
    console.error('Error updating employee:', error);
  });
}


