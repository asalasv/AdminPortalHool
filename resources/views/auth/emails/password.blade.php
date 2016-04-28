{{-- resources/views/emails/password.blade.php --}}

Hola, hemos recibido su petición para una nueva contraseña.<br/><br/>

Presione el enlace de abajo para obtener una nueva contraseña para AdminPortalHook<br/><br/>
 
<a href="{{ url('password/reset/'.$token) }}">Crear una nueva contraseña</a><br/><br/>

Que tenga buen día,<br/>
PortalHook