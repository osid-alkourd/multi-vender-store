import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// each authenticated user it is a private channal the laravel ECHO will listen to it 
// App.Models.User.${userID} it is the channle 
var channel = Echo.private(`App.Models.User.${userID}`);
channel.notification(function(data) {
    console.log(data);
    alert(data.body);
});