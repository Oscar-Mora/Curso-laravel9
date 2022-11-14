# Agregado por propietario del Repositorio

## plantillas blade
Al crear plantillas blade, véase carpeta /resources/views/layouts. En ocasiones queremos no reescribir mucho codigo por cada vista entonces usamos blade y sus directivas, explico para que sirven cada una de las más representativas o usadas
- Hacemos referencia a la info que queremos sustituir dentro de los templates con la directiva **@yield('NombreDeLaSeccion/Tag')** ubicadas dentro de las tags html del template, ver plantilla.blade.php del proyecto.
- Cuando queremos que nuestras vistas **hereden** un **contenido** de una plantilla.blade usamos **@extends('ruta.plantilla')** haciendo referencia con lo que hay dentro de los paréntesis a la ruta de la plantilla que queremos implementar, poniendo ésta directiva al inicio del archivo de la vista que está heredando el formato de la plantilla.blade
- Despues ya que hicimos el extend con su ruta, para usarla dentro de la vista que hereda la plantilla-balde, hay que usar las directivas **@section('NombreDeReferenciaContenido','ContenidoQueSustituye')** que sustituye lo que pusimos predeterminado en la section con el nuevo contenido que reemplazará la referencia, **ver plantilla.blade.php y home.blade.php del proyecto** . A demás podemos usar **@section('NombreDelSection') y   @endsection** para delimitar limites de una seccion y poner todo el contenido que sea necesario entre estas 2 directivas,por ejemplo tags HTML, variables u otras directivas de blade para rellenar la seccion.

## DATABASE

Creo que lo más importante aquí es que se revise el archivo database.php en la carpeta config de la carpeta root junto con el archivo .env o .env.example en caso de estar bajando el repositorio despues de haber sido creado

## Migraciones
Son como el control de versiones dentro de las bases de datoslo que permitre al equipo modificar y compartir el esquema de la base de datos de la aplicacion.Cada modificacion que querramos hacer en la DB van a quedar como un registro en las migraciones y todos esos registros van a estar al alcance de mis compañeros de equipo en el pryecto
- Si vamos a la carpeta database dentro de ella vemos una carpeta llamada migrations
por defecto tenemos 3 migraciones
el contenido dentro de ellas es, que veremos una clase CreateUsersTable dentro del file create_users_table.php
- Dentro del metodo CreateUsersTable que se extiende de la clase Migration, tenemos 2 metodos el metodo up y el metodo down
### - Dentro del metodo up 
vemos que se está ejecuntando un metodo create de la clase Schema, que va a recibir como parametro una cadena(que es el nombre de la tabla que se va a crear entre '') y como segundo parametro se recibe una function anónima, que a su vez recibe como parametros un objeto "$table" de tipo Blueprint. 
- Y para que queremos este objeto, pues cuenta con metodos definidos y se utiliza para crear las columnas de nuestras tablas.
> Al llamar al metodo id() del objeto $table crea una nueva columna con las siguientes propiedades:
- Integer Unsigned Increment
- Si no se le asigna un nombre entre los parentesis, se le asigna el nombre 'id' a esa columna
> Cuando ejecute el metodo string() del obj-$table lo que va a hacer es agregar una nueva columna y le va a asignar el tipo de dato varchar y la cantidad de datos que permite almacenar por default es de 255, pero podemos ponerle menos entre los parentesis, pero primero debemos especificar el nombre y luego el limite de caracteres que permitirá.
> Cuando usamos el metodo text() nos permitirá usar más de 255 caracteres, tambien se le pasan entre parentesis, el nombre de la columna y la cantidad de caracteres
> Cuando usamos string('email')->unique() hará que a nivel de DB no se repitan registros con el mismo tipo de dato y el campo se llamará email
> Cuando utilizamos el metodo timestamp('email_verified_at')->nullable(); verifica que sea un correo electrónico y a su vez registra la hora de la verificacion del email, y la propiedad nullable() es porque con esa propiedad el campo va a quedar vacío a la hora del registro, siempre que incluyamos un campo que pueda quedar vacio tenemos que pasarle la propiedad nullable.
>cuando usamos el tipo de metodo rememberToken(), tambien crea una columna varchar pero tamaño 100, le dará el nombre de remembertoken sin que le pasemos parametros, genera un token cada vez que el usuario de click en mantener sesion iniciada
> Cuando usamos el metodo timestamps() crea 2 columnas created_at y updated_at con la fecha y hora en que se creo y o edito un registro
### - Dentro del metodo down 
Vemos como se crea  un metodo de la clase schema dopIfExist('users') pasando como parametro el nombre de la tabla.

### - Buenas practicas con migraciones
- hacer siempre php artisanmake:migration create_nombreS_table para que cree los metodos y todo sea por la convencion con la que laravel genera las migraciones

## ¿Como hacer migraciones sin sobre escribir o Borrar datos ya existentes?
1. Generamos registros en la base de datos.

2. generamos una migracion siendo lo mas descriptivos posibles "php artisan make:migration add_avatar_to_users_table"

**NOTA 1**: En la sentencia final del punto 2 *"add_avatar"* hace referencia a la accion que estamos creando; *"_to_users_table"* es una convencion que se usa como cuando creamos tablas *"create_"*antes y *"_table"* despues; entonces lo que hace es crear una migration con codigo ya escrito, que hará referencia la clase **Schema::** y con un metodo ya no *create* como cuando creamos tablas, sino que llama al metodo **_"table"._**. Si queremos especificar su posicion en la tabla podemos usar los metodos ->after('nombreColumna') y el nombre de la columna dentro como string o ->before()
**"_¿Cuando queremos llamar el metodo table?_"** Cuando queremos modificar una tabla que ya existe, éste metodo recibe como parametros, el nombre de la tabla que queremos modificar y una funcion anónima  con un parametro de tipo objeto blueprint de nombre _$table._ Aquí debemos definir las modificaciones que queremos hacer a la tabla.
**NOTA 2**: Cuando hacemos migraciones y estamos agregando nuevas columnas a tablas que ya tienen registros creados, entonces tenemos que pasar el metodo **nullable()** a las nuevas columnas ya que de lo contrario los registros ya existentes que reciban esa nueva columna devolverían error porque no se pueden llenar con nada entonces con nullable se pone un valor null por defecto dentro de las nuevas columnas a menos que se especifique manualmente en cada registro, es por eso el motivo de la funcion *nullable().*
**NOTA 3**: dentro de la nueva migracion para AGREGAR NUEVA COLUMNA tambien deberíamos agregar el metodo DOWN( ) llamando al objeto $table->dropColumn('avatar') refiriendo a que haga el drop de todo lo que especificamos que modifique dentro de su metodo up().

3. ya que especificamos las modificaciones en los metodos up() y down() de la migracion corremos la migracion con **_php artisan migrate_**

4. **¿Y que hago si me equivoque en algo de lo que especifiqué?**
Es tan sencillo como hacer **_php artisan migrate:rollback;_** (regresa la ultima migracion hecha). 
Generas las modificaciones de correccion y enseguida vuelves a correr **_php artisan migrate_** 

5. **¿Y si quiero hacer otra nueva Modificacion?**
- En la documentacion explica como, pero **lo principal es** 
_descargar doctrine/dbal_ -> **_composer require doctrine/dbal_** [Migration Columns](https://laravel.com/docs/9.x/migrations#modifying-columns)
Y ya instalado es  generar la migracion (VERSION DE MODIFICACION DE LA DB) con 
**php artisan make:migration cambiar_propiedades_to_users_table** la ultima parte del comando difiere de la accion y la tabla; ya despues es seguir los pasos de las siguientes ligas, que sería especificar la banderá ->change(); al final de las nuevas modificaciones 
**NOTA:** las modificaciones se establecen en up()
**PERO en  down() SIEMPRE van las propiedades que habían antes** de las modificaciones, por ejemplo si el campo 'name' tenía varchar(255) eso debe tener down() con el metodo ->change();en cambiar_propiedades_to_users_table.php, para REVERTIR los cambios BIEN en caso de hacer "**rollback**".
[Updating Column Attributes](https://laravel.com/docs/9.x/migrations#updating-column-attributes)
[Renaming Columns](https://laravel.com/docs/9.x/migrations#renaming-columns)

# Models
Para crear modelos usamos php artisan make:model Curso
Los modelos se declaran en singular
Para poder usar modelos podemos hacer de distintas formas, una de ellas e susar tinker
## [Tinker](https://laravel.com/docs/9.x/artisan#usage) 
php artisan tinker
Ejecuta el tinker de Eloquent, que permite ejecutar comandos o scripts desde terminal
 al ejecutar el tinker recibimos su prompt 
 "">   "" y una vez entrando, eloquent trata a cada uno de los registros como si fuera un nuevo objeto
 por ejemplo al hacer en el prompt de tinker:
 podemos llamar una instancia de un modelo "use App\Models\Curso;
 Y generar una nueva variable que cree una instancia del model "$curso = new Curso;
 y despues asignar valores a sus propiedades $curso->name='Laravel';
 $curso -> description = 'El mejor framework de php';
 Y guardar sus registros en la base de datos con el metodo save()  "$curso->save();"
 Llenaría los datos de created_at y updated_at en la base d datos.

 # Seeders
 En esta version se borró las migraciones de edicion de bases de datos y ademas se resetearon los datos de las tablas y se agregó una columna en la tabla cursos, categoria.

- Para hacer uso los Seeders o semillas podemos instanciar un modelo dentro del archivo DatabaseSeeders.php con use (App\Models\NombreModel) y luego, dentro del metodo run() de la clase DatabaseSeeder de éste archivo agregamos una $variable  que instancíe al modelo que vamos a usar(new Curso) y despues le generaríamos la data que queremos que guarde para al final pasarle el metodo save() a la variable y que se guarde en la BD por cada campo ej.($curso->name='laravel'...etc)  y luego $curso->save();.Ésta sería la forma más manual de hacer la inserción de semillas

- Otra forma es usar el comando php artisan make:seeder NombreSeeder 
De éste modo en un archivo aparte separamos por tipo de Use model(llamar al modelo con use) y cantidad de seeders(la instancia de modelo, descripcion de campos y save() por cada registro);esto anterior para cada nuevo archivo Seeder. Para esto en el archivo main de Seeders _(DatabaseSeeder.php)_ dentro de su metodo run() llamamos al seeder hijo de la tabla que vamos a inyectar de info ej. 
$this->call(CursoSeeder::class);

# Factory 
Para trabajar con Factories podemos hacer el commando sail php artisan make:factory CursoFactory --model=Curso
Haciendo referencia en el flag --model=Model al modelo que se usará de referencia, osea la create_model_table.php del modelo para poder simplemente llamar al modelo desde DatabaseSeeder.php con Curso::factory(50)->create();
y despues en el modelo  declarar que hace uso de un factory con use Illuminate\Database\Eloquent\Factories\HasFactory; y con  use HasFactory;

# SINTAXIS FUNCIONES FLECHA, implementadas desde [php7.4](https://www.php.net/manual/es/functions.arrow.php)

# MUTADORES Y ACCESORES  (SETTERS Y GETTERS)
Para hacer un mutador y un accesor debemos identificar el Model que queremos preparar para tenga mutadores y accesores
Así que tenemos que importar en la parte de arriba una "definicion" llamada "Attribute", (use Illuminate\Database\Eloquent\Casts\Attribute;) y tenemos que agregar despues dentro de la class User generamos un metodo protected con el nombre del atributo del modelo.
Y dentro del modelo pediremos que nos retorne una nueva instancia del Attribute osea:
>  protected function name():Attribute{return new Attribute()} 
y dentro del los parentesis del new Attribute se colocarán el mutador , (set) y el accesor(get).
ver ejemplo de model User, los mutadores y accesores fueron definidos con forma funcion flecha y primero(lo que está comentado) mediante funcion anónima.

# GENERANDO EL CRUD

Para la Generacion del CRUD Iniciamos con "ASIGNACION DEL NOMBRE DE RUTA" desde web.php ver comentario NOMBRE DE RUTA 
Generamos primero Index, que devuelve:
1. Renderizado del listado de registros existentes en base de datos
2. Renderiza la paginación de los registros en la base de datos
3. Renderiza botón de Crear Registro
4. Enlace para renderizar cada uno de los registros
- Así que en el metodo index() del Controller podemos generar una $variable que cache del modelo todos los registros --> Model::all();<-- y en la vista correspondiente a la que apunta la ruta de web.php podemos poner en una @seccion de blade lo siguiente (<ul>@foreach($cursos as $curso) <li>{curso->name} </li> @endforeach</ul>)para mostrar la prop nombre,
- Para hacer bien la paginacion deberíamos agregar los botones despues del listado  cambiando en el controller al cachar los datos de la BD Model::paginate(); que devuelve por páginas todos los registros y en la vista, con el siguiente codigo {{$cursos->links()}} laravel nos ayuda a hacer el diseño de las paginaciones
- La siguiente tarea es generar el boton de crear curso con un <a href="{{route('route.nameAssigned')}}"></a> al inicio de la vista, que debería llevar la ruta de nombre asinado 'curso.create'
- Por último  se debe generar el enlace que debe ir en cada registro para que al dar click nos lleve a visualizar la data de cada registro.




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

