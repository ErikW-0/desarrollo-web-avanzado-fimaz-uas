# desarrollo-web-avanzado-fimaz-uas
Repositorio de evidencias de la asignatura Desarrollo Web Avanzado – LISI – FIMAZ - UAS

El sistema implementa un modelo simple de usuarios utilizando programación orientada a objetos en PHP. Se define una clase base llamada Usuario y dos clases derivadas: Admin y Alumno.

El sistema valida el formato del correo electrónico y utiliza manejo de excepciones para controlar errores cuando los datos ingresados no son válidos.

la clase Usuario es la base y contiene los atributos correo y nombre, ademas de la validacion

la clase admin manda a llamar la clase de Usuario y agrega el método getRol() que retorna "Administrador".

la clase Alumno hereda de Usuario sus atributos, agrega el atributo matricula y el método getRol() que retorna "Alumno".

Se utiliza try/catch en index.php para capturar excepciones cuando se intenta crear un usuario con un correo inválido.

Si el correo no cumple con el formato correcto, el sistema lanza una excepción con un mensaje de error.
