function renderTable() {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
  
    
    fetch('get_gates.php')
      .then(response => response.json())
      .then(data => {
        
        data.forEach((rowData, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${rowData.gate_id}</td>
            <td>${rowData.gatepassword}</td>
            <td>${rowData.gate_name}</td>
            <td>${rowData.gate_location}</td>
            <td>
              <button onclick="editGate(${rowData.gate_id})" id="editButton${rowData.gate_id}"><image src="edit.jpeg"></button>
              <button onclick="deleteGate(${rowData.gate_id})">
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

function deleteGate(gateId) {
    console.log('Deleting gate with ID:', gateId);
   
    fetch('delete_gate.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ gate_id: gateId }),
    })
      .then(response => response.json())
      .then(data => {
        
        if (data.success) {
          renderTable();
        } else {
          console.error('Error deleting gate:', data.error);
        }
  
      })
      .catch(error => {
        console.error('Error deleting gate:', error);
      });
  }

  function addGate() {
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td><input type="number" id="newGateId"></td>
      <td><input type="text" id="newGatePassword"></td>
      <td><input type="text" id="newGateName"></td>
      <td><input type="text" id="newGateLocation"></td>
      <td>
        <button onclick="saveNewGate()">Kaydet</button>
        <button onclick="exitAddGate()">Çık</button>
      </td>
    `;
  
  
    const tableBody = document.getElementById('table-body');
    tableBody.appendChild(newRow);
  
    const addGateButton = document.getElementById('addGateButton');
    if (addGateButton) {
      addGateButton.style.display = 'none';
    }
  
  }

  function exitAddGate() {
  
    const newRow = document.querySelector('#table-body tr:last-child');
    newRow.remove();
  
    const addGateButton = document.getElementById('addGateButton');
    if (addGateButton) {
      addGateButton.style.display = 'block'; 
    }
  
    renderTable();
    
  }
  
  function saveNewGate(){
    const newGateId = document.getElementById('newGateId').value;
    const newGatePassword = document.getElementById('newGatePassword').value;
    const newGateName = document.getElementById('newGateName').value;
    const newGateLocation = document.getElementById('newGateLocation').value;
  
    
  
    const formData = new FormData();
    formData.append('gate_id', newGateId);
    formData.append('gatepassword', newGatePassword);
    formData.append('gate_name', newGateName);
    formData.append('gate_location', newGateLocation);

  
    
    fetch('add_gate.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      
      if (data.success) {
        renderTable();
      } else {
        console.error('Error adding gate:', data.error);
      }
  
    })
    .catch(error => {
      console.error('Error adding gate:', error);
    });
  
    const addGateButton = document.getElementById('addGateButton');
    if (addGateButton) {
      addGateButton.style.display = 'block'; 
    }
  
  }

  function editGate(gateId) {
    console.log('Editing gate with ID:', gateId);
  
    
    const row = document.querySelector(`#editButton${gateId}`).parentNode.parentNode;
    const cells = row.getElementsByTagName('td');
  
    
    const gateData = {
      gate_id: cells[0].textContent,
      gatepassword: cells[1].textContent,
      gate_name: cells[2].textContent,
      gate_location: cells[3].textContent,
    };
  
    
    const formRow = document.createElement('tr');
    formRow.innerHTML = `
      <td><input type="number" value="${gateData.gate_id}" id="editGateId"></td>
      <td><input type="text" value="${gateData.gatepassword}" id="editGatePassword"></td>
      <td><input type="text" value="${gateData.gate_name}" id="editGateName"></td>
      <td><input type="text" value="${gateData.gate_location}" id="editGateLocation"></td>
      <td>
        <button onclick="saveEditedGate(${gateId})">Kaydet</button>
        <button onclick="renderTable()">Çık</button>
      </td>
    `;
  
   
    row.parentNode.replaceChild(formRow, row);
  
  
  }
  
  
  function saveEditedGate(gateID) {
    const editedGateId = document.getElementById('editGateId').value;
    const editedGatePassword = document.getElementById('editGatePassword').value;
    const editedGateName = document.getElementById('editGateName').value;
    const editedGateLocation = document.getElementById('editGateLocation').value;
   
  
    const formData = new FormData();
    formData.append('gate_id', editedGateId);
    formData.append('gatepassword', editedGatePassword);
    formData.append('gate_name', editedGateName);
    formData.append('gate_location', editedGateLocation);
    formData.append('old_gate_id', gateID) ;

  
  
  
    fetch('update_gate.php', {
      method: 'POST',
      body: formData ,
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        renderTable();
      } else {
        console.error('Error updating gate:', data.error);
      }
    })
    .catch(error => {
      console.error('Error updating gate:', error);
    });
  }
  