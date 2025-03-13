/* masquer la notification */

document.getElementById('closeNotification').addEventListener('click', (e)=>{
    console.log('click');
    document.getElementById('notificationSuccess').style.display = "none";
})