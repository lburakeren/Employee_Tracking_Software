// SIDEBAR ACTIVE MENU
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');


allSideMenu.forEach(item=>{
    const li = item.parentElement

    item.addEventListener('click' , function(){
        allSideMenu.forEach(i=>{
            i.parentElement.classList.remove('active') ;
        })
        li.classList.add('active');
    })

})

// Function to update the active menu item based on the current page URL
function setActiveMenuItem() {
    const currentUrl = window.location.pathname;
    allSideMenu.forEach(item => {
        const href = item.getAttribute('href');
        const li = item.parentElement;
        if (currentUrl === href) {
            li.classList.add('active');
        } else {
            li.classList.remove('active');
        }
    });
}

//TOGGLE SIDEBAR

const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sideBar = document.getElementById('sidebar');

menuBar.addEventListener('click', function(){
    sideBar.classList.toggle('hide');
});


// Call the function when the page loads
document.addEventListener('DOMContentLoaded', setActiveMenuItem);


// LOGOUT
function confirmLogout() {
    console.log("sadfaasdf");
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "/GateBackend/Logout/logout.php"; 
    } 
}
