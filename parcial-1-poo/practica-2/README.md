# desarrollo-web-avanzado-fimaz-uas
Repositorio de evidencias de la asignatura Desarrollo Web Avanzado – LISI – FIMAZ - UAS


En esta práctica se aplicó el concepto de herencia de la programación orientada a objetos.  
La clase Admin extiende la clase Usuario, lo que significa que hereda sus atributos y métodos.  
Gracias a esto, la clase Admin puede usar los métodos `getNombre()` y `getCorreo()` sin tener que volver a programarlos.

 Diferencias entre Usuario y Admin
Usuario
Contiene los atributos `nombre` y `correo`.
Tiene constructor, getters y setters.

Admin
 Hereda todo lo de la clase Usuario.
 Añade el método `getRol()` que devuelve `"Administrador"`.

Evidencia de ejecución
Al ejecutar `index.php` en el navegador se muestra:

Nombre: Erik  
Correo: erikwr3@email.com  
Rol: Administrador