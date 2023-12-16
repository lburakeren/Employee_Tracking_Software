function renderTable() {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
  
    
    fetch('get_cards.php')
      .then(response => response.json())
      .then(data => {
        
        data.forEach((rowData, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${rowData.card_id}</td>
            <td>${rowData.employee_id}</td>
            <td>${rowData.first_name}</td>
            <td>${rowData.last_name}</td>
            <td>
              <button data-card-id="${rowData.card_id}" onclick="editCard(this)"><image src="edit.jpeg"></button>
              <button data-card-id="${rowData.card_id}" onclick="deleteCard(this)">
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

function deleteCard(cardId) {
  console.log('Deleting card with ID:', cardId);
 
  fetch('delete_card.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ card_id: cardId }),
  })
    .then(response => response.json())
    .then(data => {
      
      if (data.success) {
        renderTable();
      } else {
        console.error('Error deleting card:', data.error);
      }

    })
    .catch(error => {
      console.error('Error deleting card:', error);
    });
}


function addCard() {
  const newRow = document.createElement('tr');
  
  fetch('../Employees/get_employees.php')
    .then(response => response.json())
    .then(employees => {
      const employeeSelect = document.createElement('select');
      employeeSelect.id = 'newEmployeeId';

      employees.forEach(employee => {
        const option = document.createElement('option');
        option.value = employee.employee_id;
        option.textContent = `${employee.first_name} ${employee.last_name}`;
        employeeSelect.appendChild(option);
      });

      newRow.innerHTML = `
        <td><input type="number" id="newCardId"></td>
        <td>${employeeSelect.outerHTML}</td>
        <td>
          <button onclick="saveNewCard()">Kaydet</button>
          <button onclick="exitAddCard()">Çık</button>
        </td>
      `;

      const tableBody = document.getElementById('table-body');
      tableBody.appendChild(newRow);

      const addCardButton = document.getElementById('addCardButton');
      if (addCardButton) {
        addCardButton.style.display = 'none';
      }
    })
    .catch(error => console.error('Error fetching employees:', error));
}

function exitAddCard() {
  
  const newRow = document.querySelector('#table-body tr:last-child');
  newRow.remove();

  const addCardButton = document.getElementById('addCardButton');
  if (addCardButton) {
    addCardButton.style.display = 'block'; 
  }

  renderTable();
  
}

function saveNewCard(){
  
  const newCardId = document.getElementById('newCardId').value;
  const newEmployeeId = document.getElementById('newEmployeeId').value;

  const formData = new FormData();
  formData.append('card_id', newCardId);
  formData.append('employee_id', newEmployeeId);


  
  fetch('add_card.php', {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(data => {
    
    if (data.success) {
      renderTable();
    } else {
      console.error('Error adding card:', data.error);
    }

  })
  .catch(error => {
    console.error('Error adding card:', error);
  });

  const addCardButton = document.getElementById('addCardButton');
  if (addCardButton) {
    addCardButton.style.display = 'block'; 
  }

}


function editCard(button) {
  
  const cardId = button.getAttribute('data-card-id');
  console.log('Editing card with ID:', cardId);

  const row = button.closest('tr'); 
  const cells = row.getElementsByTagName('td');

  
  const cardData = {
    card_id: cells[0].textContent,
    employee_id: cells[1].textContent,
  };

  
  const formRow = document.createElement('tr');
  formRow.innerHTML = `
    <td><input type="text" value="${cardData.card_id}" id="editCardId"></td>
    <td><input type="number" value="${cardData.employee_id}" id="editEmployeeId"></td>
    <td>
      <button onclick="saveEditedCard('${cardId}')">Kaydet</button>
      <button onclick="renderTable()">Çık</button>
    </td>
  `;

 
  row.parentNode.replaceChild(formRow, row);


}


function saveEditedCard(cardId) {
  
  const editedCardId = document.getElementById('editCardId').value;
  const editedEmployeeId = document.getElementById('editEmployeeId').value;

  console.log(cardId);


  const formData = new FormData();
  formData.append('card_id', editedCardId);
  formData.append('employee_id', editedEmployeeId);
  formData.append('old_card_id', cardId);


  fetch('update_card.php', {
    method: 'POST',
    body: formData ,
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      renderTable();
    } else {
      console.error('Error updating card:', data.error);
    }
  })
  .catch(error => {
    console.error('Error updating card:', error);
  });
}

