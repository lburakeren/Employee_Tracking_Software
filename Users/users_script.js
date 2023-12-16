function renderTable() {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
  
    
    fetch('get_users.php')
      .then(response => response.json())
      .then(data => {
        
        data.forEach((rowData, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${rowData.username}</td>
            <td>${rowData.password}</td>
            <td>${rowData.first_name}</td>
            <td>${rowData.last_name}</td>
            <td>${rowData.email}</td>
            <td>
              <button onclick="editUser(${rowData.id})" id="editButton${rowData.id}"><image src="edit.jpeg"></button>
              <button onclick="deleteUser('${rowData.username}')">
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


function deleteUser(username) {
    console.log('Deleting user :', username);
   
    fetch('delete_user.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username : username }),
    })
      .then(response => response.json())
      .then(data => {
        
        if (data.success) {
          renderTable();
        } else {
          console.error('Error deleting user:', data.error);
        }
  
      })
      .catch(error => {
        console.error('Error deleting user:', error);
      });
  }

  function addUser() {
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td><input type="text" id="newUsername"></td>
      <td><input type="text" id="newPassword"></td>
      <td><input type="text" id="newFirstName"></td>
      <td><input type="text" id="newLastName"></td>
      <td><input type="text" id="newEmail"></td>
      <td>
        <button onclick="saveNewUser()">Kaydet</button>
        <button onclick="exitAddUser()">Çık</button>
      </td>
    `;
  
  
    const tableBody = document.getElementById('table-body');
    tableBody.appendChild(newRow);
  
    const addUserButton = document.getElementById('addUserButton');
    if (addUserButton) {
      addUserButton.style.display = 'none';
    }
  
  }

  function exitAddGate() {
  
    const newRow = document.querySelector('#table-body tr:last-child');
    newRow.remove();
  
    const addUserButton = document.getElementById('addUserButton');
    if (addUserButton) {
      addUserButton.style.display = 'block'; 
    }
  
    renderTable();
    
  }
  
  function saveNewUser(){
    const newUsername = document.getElementById('newUsername').value;
    const newPassword = document.getElementById('newPassword').value;
    const newFirstName = document.getElementById('newFirstName').value;
    const newLastName = document.getElementById('newLastName').value;
    const newEmail = document.getElementById('newEmail').value;
    
  
    
  
    const formData = new FormData();
    formData.append('username', newUsername);
    formData.append('password', newPassword);
    formData.append('first_name', newFirstName);
    formData.append('last_name', newLastName);
    formData.append('email', newEmail);


  
    
    fetch('add_user.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      
      if (data.success) {
        renderTable();
      } else {
        console.error('Error adding user:', data.error);
      }
  
    })
    .catch(error => {
      console.error('Error adding user:', error);
    });
  
    const addUserButton = document.getElementById('addUserButton');
    if (addUserButton) {
      addUserButton.style.display = 'block'; 
    }
  
  }



  function editUser(id) {
 
    const row = document.querySelector(`#editButton${id}`).parentNode.parentNode;
    const cells = row.getElementsByTagName('td');
  
    
    const userData = {
      username: cells[0].textContent,
      password: cells[1].textContent,
      first_name: cells[2].textContent,
      last_name: cells[3].textContent,
      email: cells[4].textContent,
    };
  
    
    const formRow = document.createElement('tr');
    formRow.innerHTML = `
      <td><input type="text" value="${userData.username}" id="editUsername"></td>
      <td><input type="text" value="${userData.password}" id="editPassword"></td>
      <td><input type="text" value="${userData.first_name}" id="editFirstName"></td>
      <td><input type="text" value="${userData.last_name}" id="editLastName"></td>
      <td><input type="text" value="${userData.email}" id="editEmail"></td>
      <td>
        <button onclick="saveEditedUser(${id})">Kaydet</button>
        <button onclick="renderTable()">Çık</button>
      </td>
    `;
  
   
    row.parentNode.replaceChild(formRow, row);
  
  
  }
  
  
  function saveEditedUser(id) {
    const editedUsername = document.getElementById('editUsername').value;
    const editedPassword = document.getElementById('editPassword').value;
    const editedFirstName = document.getElementById('editFirstName').value;
    const editedLastName = document.getElementById('editLastName').value;
    const editedEmail = document.getElementById('editEmail').value;

   
  
    const formData = new FormData();
    formData.append('username', editedUsername);
    formData.append('password', editedPassword);
    formData.append('first_name', editedFirstName);
    formData.append('last_name', editedLastName);
    formData.append('email', editedEmail) ;
    formData.append('id', id) ;


  
  
  
    fetch('update_user.php', {
      method: 'POST',
      body: formData ,
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        renderTable();
      } else {
        console.error('Error updating user:', data.error);
      }
    })
    .catch(error => {
      console.error('Error updating user:', error);
    });
  }
  